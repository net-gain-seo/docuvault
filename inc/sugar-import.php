<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	require('/home/docuvaul/public_html/wp-load.php');

	echo "wp-load loaded.<br><br>\r\nChecking for new leads...<br>\r\n";

	$wpdb->show_errors();
	$results = $wpdb->get_results("SELECT * FROM sugar_leads WHERE sent_to_sugar = 0", ARRAY_A);
	$wpdb->print_error();

	if ($results) {

		/*
		====================================================
		SEND TO SUGARCRM START
		====================================================
		*/

		/***
		* Following Code is for saving leads into SugarCRM captured via form
		* Author : Hardik
		* Version : 1.0 For SugarCRM version 4.5.x
		* Please make sure primary variables are always correct like url, username, password
		***/

		$url  = "https://docuvaultdv.sugarondemand.com/service/v4_1/rest.php";
		$username = "dvsugarimport";
		$password = "GRp74gts";
		$account = trim($_POST['Company_Name']);
		$lead_source = 'Corkd';
		$lead_source_description = 'NDS Connect';
		$campaign_id = "d3295a4a-4c49-b91e-d0ad-5391beeb696b";


		//login ---------------------------------

		$login_parameters = array(
		     "user_auth"=>array(
		          "user_name"=>$username,
		          "password"=>md5($password),
		          "version"=>"1"
		     ),
		     "application_name"=>"RestTest",
		     "name_value_list"=>array(),
		);

		$login_result = call("login", $login_parameters, $url);

		$user_id = "9026574a-8339-fa93-51bd-54e20b9d3d52";

		echo "\r\nLogged into Sugar.<br>\r\n";

		//get session id
		$session_id = $login_result->id;

		echo "Session ID: $session_id<br>\r\n";

		foreach ($results as $result) {
			// Use for marking this as sent to Sugar when done
			$lead_id = $result['lead_id'];

			####################################################################

			//Let's Check if Account already Exist for this Company

			$account = $result['account_name'] ? $result['account_name'] : 'Residential Customer';

			$query = "accounts.name LIKE '".$account."'";

			$get_entry_parameters = array(
			     //session id
			     "session" => $session_id,

			     //The name of the module from which to retrieve records.
			     "module_name" => "Accounts",

			     "query" => $query,

			    'order_by' => "",

			    'offset'=> 0,  

			     //Optional. A list of fields to include in the results.
			     'select_fields' => array( 'id'
			        ),     

			    'deleted' => '0',


			);

			$set_entry_result = call("get_entry_list", $get_entry_parameters, $url);
			$account_count = $set_entry_result->result_count;

			if( $account_count == 0 ){

			    // This will insert new entry if Account is not there

			    $set_entry_parameters = array(
			         //session id
			         "session" => $session_id,

			         //The name of the module from which to retrieve records.
			         "module_name" => "Accounts",

			         //Record attributes
			         "name_value_list" => array(
			              //to update a record, you will nee to pass in a record id as commented below


			                array("name" => "name", "value" => $account),
			                array("name" => "assigned_user_id", "value" => $user_id ),

			         ),
			    );

			    $set_entry_result = call("set_entry", $set_entry_parameters, $url);

			    $account_id = $set_entry_result->id;    

			} else{

			    $account_id = $set_entry_result->entry_list[0]->id;
			}

			// Now as we have set up Account id, Let's insert Lead

			$set_entry_parameters = array(
			     //session id
			     "session" => $session_id,

			     //The name of the module from which to retrieve records.
			     "module_name" => "Leads",

			     //Record attributes
			     "name_value_list" => array(
			          //to update a record, you will nee to pass in a record id as commented below

						array("name" => "first_name", "value" => $result['first_name']),
						array("name" => "last_name", "value" => $result['last_name']),
						array("name" => "account_name", "value" => $account),		  
						array("name" => "email1", "value" => $result['webtolead_email1']),
						array("name" => "phone_work", "value" => $result['phone_work']),
						//array("name" => "primary_address_city", "value" => $_POST['city']),
						//array("name" => "primary_address_state", "value" => $state_abbreviation),
						array("name" => "primary_address_postalcode", "value" => $result['primary_address_postalcode']),			
						array("name" => "account_id", "value" => $account_id ),
						array("name" => "assigned_user_id", "value" => $result['assigned_user_id'] ),
						array("name" => "lead_source", "value" => $result['lead_source']),
						array("name" => "lead_source_description", "value" => $result['lead_source_description']),
						array("name" => "campaign_id", "value" => $result['campaign_id']),
						array("name" => "lead_status", "value" => "New"),
						array("name" => "type_of_service_needed_c", "value" => $result['services_c']),
						array("name" => "how_often_service_needed_c", "value" => $result['shred_frequency_c']),
						array("name" => "how_can_we_help_c", "value" => 'Weight estimate: ' . $result['ss_c']),
						array("name" => "description", "value" => $result['description'])

			     ),
			);

			$set_entry_result = call("set_entry", $set_entry_parameters, $url);

			echo "Imported lead " . $result['first_name'] . ' ' . $result['last_name'] . " to Sugar!<br>\r\n";

			// Mark lead as imported in the DB
			$wpdb->show_errors();
			$wpdb->query("UPDATE sugar_leads SET sent_to_sugar = 1 WHERE lead_id = $lead_id");
			$wpdb->print_error();
		}

		/*
		====================================================
		SEND TO SUGARCRM END
		====================================================
		*/
	} else {
		// No leads to import right now
		echo "No new leads found.<br>\r\n";
	}


	//function to make cURL request
	function call($method, $parameters, $url)
	{
	    ob_start();
	    $curl_request = curl_init();

	    curl_setopt($curl_request, CURLOPT_URL, $url);
	    curl_setopt($curl_request, CURLOPT_POST, 1);
	    curl_setopt($curl_request, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
	    curl_setopt($curl_request, CURLOPT_HEADER, 1);
	    curl_setopt($curl_request, CURLOPT_SSL_VERIFYPEER, 0);
	    curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($curl_request, CURLOPT_FOLLOWLOCATION, 0);

	    $jsonEncodedData = json_encode($parameters);

	    $post = array(
	         "method" => $method,
	         "input_type" => "JSON",
	         "response_type" => "JSON",
	         "rest_data" => $jsonEncodedData
	    );

	    curl_setopt($curl_request, CURLOPT_POSTFIELDS, $post);
	    $result = curl_exec($curl_request);
	    curl_close($curl_request);

	    $result = explode("\r\n\r\n", $result, 2);
	    $response = json_decode($result[1]);
	    ob_end_flush();

	    return $response;
	}

?>
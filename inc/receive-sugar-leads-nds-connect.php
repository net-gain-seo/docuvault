<?php
	/*
		Receive Sugar Leads - NDS Connect
		This script receives shredding leads from NDS Connect's lead posting system and enters them into the local DV database,
		to be posted by Sugar via the existing cron job.
	 */

	/* Require WP functions/databases */
	require('../../../../wp-load.php');

	echo "wp-load loaded.<br>\r\n";
	
	require_once('Mail.php');

	echo "Mail.php loaded.<br>\r\n";
						
	/* Prepare the values from $_POST for DB insertion */

	$account_name = ''; // NDS Connect does not provide company name

	// split full name into 2 fields
	list($first_name, $last_name) = explode(" ", $_POST['Name']);

	if (trim($first_name) == '') {
	        $first_name = '.';
	}
	if (trim($last_name) == '') {
	        $last_name = '.';
	}

	$phone_work					= $_POST['Phone'];
	$webtolead_email1			= $_POST['Email'];
	$primary_address_street		= $_POST['Address'];
	$primary_address_postalcode	= $_POST['ZipCode'];
	$location_type_c			= $_POST['LocationType'];
	$shred_location_c			= $_POST['ShredLocation'];
	$shred_frequency_c			= $_POST['Frequency'];
	$ss_c 						= $_POST['BoxQuantity'];
	$description 				= $_POST['Comments'];
	$campaign_id 				= 'd3295a4a-4c49-b91e-d0ad-5391beeb696b';
	$assigned_user_id 			= '9026574a-8339-fa93-51bd-54e20b9d3d52';
	$lead_source 				= 'Corkd';
	$lead_source_description 	= 'Corkd';

	
	// Insert into DB for Sugar import later
	$wpdb->show_errors();
	$wpdb->query("INSERT INTO sugar_leads (account_name, first_name, last_name, phone_work, webtolead_email1, primary_address_street,  
		primary_address_postalcode, location_type_c, shred_location_c, shred_frequency_c, ss_c, services_c, description, campaign_id, 
		assigned_user_id, lead_source, lead_source_description) VALUES ('$account_name', '$first_name', '$last_name', '$phone_work', 
		'$webtolead_email1', '$primary_address_street', '$primary_address_postalcode', '$location_type_c', '$shred_location_c', 
		'$shred_frequency_c', '$ss_c', '$services_c', '$description', '$campaign_id', '$assigned_user_id', '$lead_source', 
		'$lead_source_description')");
	$wpdb->print_error();

	echo "Lead posted to Sugar!";
?>

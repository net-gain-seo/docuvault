<?php
sleep(180);
$DEBUG = TRUE;
 error_reporting(E_ALL);
 ini_set("display_errors", 1);

$mm_logger = new mm_debugLogger($DEBUG);

// calls less than this duration will be skipped via exception
$minimum_call_duration = 30;
// this function will catch the thrown exception to exit cleanly
set_exception_handler('exceptionHandler');

$url = 'https://docuvaultdv.sugarondemand.com/';

$username = 'dvsugarimport';
$password = 'GRp74gts';
$update_bean = false;
$update_fields = array();

$parameters = array(
    'user_auth' => array(
        'user_name' => "{$username}",
        'password' => md5("{$password}"),
    ),
);

$mm_logger->logHTML("Parsing URL Variables", 'BR');

foreach ($_GET as $key => $value) {
    $mm_logger->logHTML("{$key}={$value}", 'BR');
    $key_lower = strtolower($key);
    switch ($key_lower) {
        case "matchmodule";
            $matchmodule = $value;
            $matchmodule_lower = strtolower($matchmodule);
            break;
        case "matchfield";
            $matchfield = $value;
            $matchfield_explode = explode(",", $matchfield);
            break;
        case "matchvalue";
            $matchvalue = $value;
            if (strlen($matchvalue) == 10) {
                $npa = substr($matchvalue, 0, 3);
                $nxx = substr($matchvalue, 3, 3);
                $remain = substr($matchvalue, -4);
                $matchregex = "{$npa}[- \.]?{$nxx}[- \.]?{$remain}";
            } else {

            }
            break;
        case "duration_c":
            if($value < $minimum_call_duration) {
                $mm_logger->logHTML('Exiting - Call Duration Insufficient! Miniumum:'.$minimum_call_duration.' Actual:'.$value, 'BR');
                // throw an exception to break execution
                throw new CleanExit();
            }
            break;
        default:
            $update_fields[] = array('name' => "{$key}", 'value' => "{$value}");
    }
}
$mm_logger->logHTML("Parsed matchfield=" . var_export($matchfield_explode, TRUE), 'PRE');
$mm_logger->logHTML("Parsed matchvalue={$matchvalue}", 'BR');

$mm_logger->logHTML("Parsed update values=" . var_export($update_fields, TRUE), 'PRE');


if ($update_fields) {
    $sessionInfo = sugarREQUEST($url, 'login', $parameters, $mm_logger);
    $mm_logger->logHTML(var_export($sessionInfo, TRUE), 'PRE');


    foreach ($matchfield_explode as $matchfield_single) {
        $mm_logger->logHTML("checking matchfield={$matchfield_single}", 'BR');
		$get_entry_list_params = array(
            'session' => $sessionInfo->id,
            'module_name' => "{$matchmodule}",
            'query' => "{$matchmodule_lower}.{$matchfield_single} REGEXP '{$matchregex}'",
            'order_by' => "date_entered DESC",
            'offset' => 0,
            'select_fields' => array(
                'id',
                'first_name',
                'last_name',
                'account_name',
                'account_id',
                'email1',
                'phone_work',
            ),
            'link_name_to_fields_array' => '',
            'max_results' => 2,
            'deleted' => false
        );
        $mm_logger->logHTML(var_export($get_entry_list_params, TRUE), 'PRE');
        $get_entry_list_result = sugarREQUEST($url, 'get_entry_list', $get_entry_list_params, $mm_logger);
        $mm_logger->logHTML(var_export($get_entry_list_result, TRUE), 'PRE');

        if ($get_entry_list_result) {
            if ($get_entry_list_result->entry_list) {
                $mm_logger->logHTML("FOUND A MATCH FOR {$matchvalue} in the field {$matchfield_single}", 'BR');
                $update_bean = $get_entry_list_result->entry_list[0]->id;
            } else {
                $mm_logger->logHTML("no match for {$matchvalue} in the field {$matchfield_single}", 'BR');
            }
        }
        $mm_logger->logHTML("bean to update={$update_bean}", 'BR');
        if ($update_bean) {
            break;
        }
    }


    if ($update_bean) {

        $final_update = array(
            array('name' => 'id', 'value' => $update_bean),
        );
    }else{
        $final_update = array(
            array('name' => 'last_name', 'value' => 'New Mongoose AccuTrack Lead'),
        );    }
    foreach ($update_fields as $key => $update_field) {
        $final_update[] = $update_field;
    }
    $parameters = array(
        'session' => $sessionInfo->id,
        'module' => "{$matchmodule}",
        'name_value_list' => $final_update,
    );
    $mm_logger->logHTML(var_export($parameters, TRUE), 'PRE');
    $write_info = sugarREQUEST($url, 'set_entry', $parameters, $mm_logger);
    $mm_logger->logHTML(var_export($write_info, TRUE), 'PRE');
}



function sugarREQUEST($url, $method, $parameters, $mm_logger) {
    $url = "{$url}/service/v2/rest.php";
// specify the REST web service to interact with
// Open a curl session for making the call
    $curl = curl_init($url);
// Tell curl to use HTTP POST
    curl_setopt($curl, CURLOPT_POST, true);
// Tell curl not to return headers, but do return the response
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); 
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// Set the POST arguments to pass to the Sugar server

    $json = json_encode($parameters);

    $postArgs = "method={$method}&input_type=JSON&response_type=JSON&rest_data={$json}";
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postArgs);
// Make the REST call, returning the result
    $response = curl_exec($curl);

// Close the connection
    curl_close($curl);
// Convert the result from JSON format to a PHP array
    $result = json_decode($response);

    return $result;
}

class mm_debugLogger {

    protected $DEBUG;

    public function __construct($DEBUG=FALSE) {
        $this->DEBUG = $DEBUG;
        if ($this->DEBUG) {
            error_reporting(E_ALL);
            ini_set("display_errors", 1);
        }
    }

    public function logHTML($log_text, $output_type=NULL) {
        if ($this->DEBUG) {
            $output_function = '_output_' . $output_type;
            if (method_exists($this, $output_function)) {
                $this->$output_function($log_text);
            } else {
                $this->_output_BR($log_text);
            }
        }
    }

    protected function _output_BR($log_text) {
        echo "{$log_text}<br/>";
    }

    protected function _output_PRE($log_text) {
        echo "<pre>{$log_text}</pre>";
    }

}
// provides a way to exit cleanly
class CleanExit extends Exception {}
function exceptionHandler($exception) 
{
    // catches otherwise uncaught exceptions
    // do nothing
}

?>
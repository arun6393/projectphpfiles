<?php
require_once('loader.php');

// return json response 
$json = array();

$nameUser  = stripUnwantedHtmlEscape($_POST["name"]);
$emailUser = stripUnwantedHtmlEscape($_POST["email"]);
$gcmRegID  = stripUnwantedHtmlEscape($_POST["regId"]); // GCM Registration ID got from device
$imei      = stripUnwantedHtmlEscape($_POST["imei"]);

// Send this message to device
$message = $nameUser."^".$imei."^Registered on server.";

/**
 * Registering a user device in database
 * Store reg id in users table
 */
if (isset($nameUser) && isset($emailUser) && isset($gcmRegID) && $nameUser!="" && $imei!="" && $gcmRegID!="" && $emailUser!="") {
   
   if(!isUserExisted($emailUser,$gcmRegID))
   {
	// Store user details in db
    $res = storeUser($nameUser, $emailUser, $gcmRegID,$imei);

    $registatoin_ids = array($gcmRegID);
    $messageSend = array("message" => $message);

    $result = send_push_notification($registatoin_ids, $messageSend);

   }//echo $result;
} else {
    // user details not found
	echo "Wrong values.";
}
?>
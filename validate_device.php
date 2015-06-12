<?php

 require_once('loader.php');
 
 $imei     = $_REQUEST['data1'];
 $regID    = $_REQUEST['data2'];
 
//$resultUsers =  getRegIDUser($regID);
$resultUsers =  getIMEIUser($imei);
	
if ($resultUsers != false)
	$NumOfUsers = mysql_num_rows($resultUsers);
else
	$NumOfUsers = 0;

$jsonData      = array();

if ($NumOfUsers > 0) {
					
 while ($rowUsers = mysql_fetch_array($resultUsers)) {
	 
	
	$jsonTempData = array(); 
	
	$jsonTempData['regid']        = $rowUsers["gcm_regid"];
	$jsonTempData['name']         = $rowUsers["name"];
	$jsonTempData['email']        = $rowUsers["email"];
	$jsonTempData['imei']         = $rowUsers["imei"];
	$jsonTempData['status']       = "update";
   
	$jsonData[] = $jsonTempData;
	
   }
}
else{
	
	$jsonTempData = array();
	
	$jsonTempData['regid']        = "";
	$jsonTempData['name']         = "";
	$jsonTempData['email']        = "";
	$jsonTempData['imei']         = "";
	$jsonTempData['status']       = "install";
   
	$jsonData[] = $jsonTempData;
	
}
 
$outputArr = array();
$outputArr['Android'] = $jsonData;	  

// Encode Array To JSON Data
print_r( json_encode($outputArr));
 
?>

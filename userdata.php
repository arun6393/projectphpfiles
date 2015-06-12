<?php

 require_once('loader.php');
 
 $resultUsers =  getAllUsers();
	if ($resultUsers != false)
		$NumOfUsers = mysql_num_rows($resultUsers);
	else
		$NumOfUsers = 0;

$jsonData      = array();
if ($NumOfUsers > 0) {
  
   $jsonTempData = array();
   $jsonTempData['imei']         = "All";
   $jsonTempData['regid']        = "All";
   $jsonTempData['name']         = "Send To All";
   $jsonTempData['error']        = "y";          
   $jsonData[] = $jsonTempData;
   
 while ($rowUsers = mysql_fetch_array($resultUsers)) {
	 
	  $jsonTempData = array();
	  $jsonTempData['imei']         = $rowUsers["imei"];
	  $jsonTempData['regid']        = $rowUsers["gcm_regid"];
	  $jsonTempData['name']         = $rowUsers["name"];
	  $jsonTempData['error']        = "y";
	   
	  $jsonData[] = $jsonTempData;
	
	}
   
   
   
}
else{
   $jsonTempData = array();
   $jsonTempData['imei']         = "Data not found.";
   $jsonTempData['regid']        = "Data not found.";
   $jsonTempData['name']         = "Data not found.";
   $jsonTempData['error']        = "n";
   $jsonData[] = $jsonTempData;
}

   $outputArr = array();
   $outputArr['Android'] = $jsonData;
   
// Encode Array To JSON Data
   print_r( json_encode($outputArr));
?>

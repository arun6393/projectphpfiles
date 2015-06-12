<?php

 require_once('loader.php');
 
 $imei    		= $_REQUEST['data1'];
 $message 		= $_REQUEST['data2'];
 $sendToIMEI 	= $_REQUEST['data3'];
 $regID 	    = $_REQUEST['data4'];
 
 $UserName = getIMEIUserName($sendToIMEI);
 
 $message = $UserName."^".$sendToIMEI."^".$message;
 
 if($imei == "All")
   $resultUsers =  getAllUsers();
 else
   $resultUsers =  getRegIDUser($regID);
		
	if ($resultUsers != false)
		$NumOfUsers = mysql_num_rows($resultUsers);
	else
		$NumOfUsers = 0;
	
	
	if ($NumOfUsers > 0) {
						
	 while ($rowUsers = mysql_fetch_array($resultUsers)) {
		 
		$gcmRegID    = $rowUsers["gcm_regid"]; // GCM Registration ID got from device
		$pushMessage = $message;
		
		if (isset($gcmRegID) && isset($pushMessage)) {
			
			
			$registatoin_ids = array($gcmRegID);
			$messageSend = array("message" => $pushMessage);
		
			$result = send_push_notification($registatoin_ids, $messageSend);
		    
			echo $result;
			//echo "Message sent.";
		}
	   }
	}
	else
	  print "Data not found.";
		  
  
 
 
?>

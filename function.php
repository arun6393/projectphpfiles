<?php

   /**
     * Storing new user
     * returns user details
     */
   function storeUser($name, $email, $gcm_regid,$imei) {
        // insert user into database
        $result = mysql_query("INSERT INTO gcm_users(name, email, gcm_regid, imei , created_at) VALUES('$name', '$email', '$gcm_regid','$imei', NOW())");
        // check for successful store
        if ($result) {
            // get user details
            $id = mysql_insert_id(); // last inserted id
            $result = mysql_query("SELECT * FROM gcm_users WHERE id = $id") or die(mysql_error());
            // return user details
            if (mysql_num_rows($result) > 0) {
                return mysql_fetch_array($result);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Get user by email
     */
   function getUserByEmail($email) {
        $result = mysql_query("SELECT * FROM gcm_users WHERE email = '$email' LIMIT 1");
        return $result;
    }

    /**
     * Getting all registered users
     */
   function getAllUsers() {
        $result = mysql_query("select * FROM gcm_users");
        return $result;
    }

     /**
     * Getting users detail by IMEI
     */
   function getIMEIUser($imei) {
        $result = mysql_query("select * FROM gcm_users where imei='$imei'");
        return $result;
    }
	
	/**
     * Getting users detail by REGID
     */
   function getRegIDUser($regID) {
        $result = mysql_query("select * FROM gcm_users where gcm_regid='$regID'");

        return $result;
    }
	
	/**
     * Getting users
     */
   function getIMEIUserName($imei) {
	    $UserName = "";
        $result = mysql_query("select name FROM gcm_users where imei='$imei'");
      // echo "the resuke is".$result;
		if(mysql_num_rows($result))
		{
		   while($row = mysql_fetch_assoc($result))
		   {
			   $UserName  = $row['name'];
		   }
	    }
        return $UserName;
    }

    /**
     * Validate user
     */
  function isUserExisted($email,$gcmRegID) {
        $result    = mysql_query("SELECT email from gcm_users WHERE email = '$email' and gcm_regid = '$gcmRegID'");
        $NumOfRows = mysql_num_rows($result);
        if ($NumOfRows > 0) {
            // user existed
            return true;
        } else {
            // user not existed
            return false;
        }
    }
	
	/**
     * Sending Push Notification
     */
   function send_push_notification($registatoin_ids, $message) {
        

        // Set POST variables
        $url = 'https://android.googleapis.com/gcm/send';

        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => $message,
        );

        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
		//print_r($headers);
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);
        echo $result;
    }
	
	
	function stripUnwantedTags($str)
	{
		$tempStr = $str;
		
		$tempStr  = str_replace('script','scriptd',$tempStr);
	    $tempStr  = str_replace('iframe','iframed',$tempStr);
		$tempStr  = str_replace('base64','',$tempStr);
		$tempStr  = str_replace('eval(','',$tempStr);
		$tempStr  = str_replace('data:','',$tempStr);
		//$tempStr  = htmlentities($tempStr, ENT_QUOTES, "UTF-8");
		
		return $tempStr;
	}
    
	function escapeStr($str)
        {
				$tempStr  = htmlentities($str, ENT_QUOTES, "UTF-8");
				return str_replace("'","",$tempStr);
        }
	function escapeStrMysql($str){
		
		 return  mysql_real_escape_string($str);
	 }	
	 
   
  function stripHtmlTags($str){
		
		 return  strip_tags($str);
	 }
	 
  function stripUnwantedHtmlEscape($str)
  {
	  return escapeStrMysql(escapeStr(stripUnwantedTags(stripHtmlTags($str))));  
  }
?>
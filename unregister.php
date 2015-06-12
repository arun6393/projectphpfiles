<?php

$gcmRegID  = stripUnwantedHtmlEscape($_POST["regId"]); // GCM Registration ID got from device
$imei      = stripUnwantedHtmlEscape($_POST["imei"]);

 //mysql_query("delete from gcm_users where imei='$imei'");
?>
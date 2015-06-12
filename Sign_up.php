<?php
$response=array();
if(isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $passsword = $_GET['password'];
    $field = $_GET['field'];
    $lat=$_GET['lat'];
    $long=$_GET['long'];

    //$query = "SELECT source,dest,bus_no FROM bus_info WHERE bus_id=" . $bus_id . " limit 1";
    $query = "INSERT INTO login (username, password, field,latitude,longitude)
VALUES ('$user_id','$passsword','$field',$lat,$long)";

    $con = mysql_connect('localhost', 'whereist_user', 'arun@123');

    if ($con) {
        $r = mysql_select_db('whereist_businfo', $con);
        if ($r == true) {
            $result = mysql_query($query);
            if ($result) {

                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}
    ?>
<?php
$response=array();
if(isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $password = $_GET['pass'];
    $lat=$_GET['lat'];
    $long=$_GET['long'];
    //echo $user_id;
    $query = "SELECT * FROM login WHERE username='$user_id' and password='$password'";

    //echo $query;
//".'$user_id';
        //."and password=".$password;

    $con = mysql_connect('localhost', 'whereist_user', 'arun@123');

    if ($con) {
        $r = mysql_select_db('whereist_businfo', $con);
        if ($r == true) {
            $result = mysql_query($query);
            if($result) {
                $flag=0;
                $rows = array();	//new
                for($i=0; @$row=mysql_fetch_assoc($result); $i++) {
                    $flag=1;
                    //below line new
//                    $rows[] = array("no"=>$row['bus_no'],"Source"=>$row['source'],"dest"=>$row['dest']);;

                }
                if($flag=="0") {
//                    $res=array("success"=>"0","message"=>"No records found!");
//                    echo json_encode($res);

                    echo "error";
                } else if($flag=="1") {
                    // 3 new line
//                    header('Content-Type: application/json');
//                    $data = array('row' => $rows);
//                    print json_encode($data,128);
                    echo mysql_num_rows($result);
                    if(mysql_num_rows($result)==1)
                    {
                        //echo "hello";
                        $query1="UPDATE login
SET latitude = $lat, longitude =$long where username='$user_id'";
                        $result1 = mysql_query($query1);
                        if($result1) {
                          //  echo "updated";
                        }
                    }
                }
            } else {
                $res=array("success"=>"0","message"=>"query error!");
                echo json_encode($res);
            }
        } else {
            $res=array("success"=>"0","message"=>"db error!");
            echo json_encode($res);
        }
    } else {
        $res=array("success"=>"0","message"=>"Connection error!");
        echo json_encode($res);
    }
} else {
    $res=array("success"=>"0","message"=>"error!");
    echo json_encode($res);
}

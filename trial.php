<?php
$response=array();
if(isset($_GET['busdestination'])) {
    $bus_destination=$_GET['busdestination'];
    //$lat=$_GET['lat'];
    //$long=$_GET['long'];

    $query="SELECT bus_no FROM Bus_Routes WHERE stop='".$bus_destiation."'";
//$query1="SELECT bus_stop,latitude,longitude from BUS1 where busno in (SELECT bus_no FROM bus_track3 WHERE stop='".$bus_destiation."')";

    $query1="SELECT bus_stop,latitude, longitude
FROM Bus_Stop_Location
WHERE bus_stop
IN (

SELECT bus_stop
FROM Bus_No_Bus_Stop
WHERE busno
IN (SELECT bus_no FROM Bus_Routes WHERE stop='".$bus_destination."')
)";

    $con=mysql_connect('localhost','whereist_user','arun@123');

    if($con) {
        $r=mysql_select_db('whereist_businfo',$con);
        if($r==true) {
            $result=mysql_query($query);
            $result1=mysql_query($query1);
            if($result1 && $result) {
                $flag=0;
                $rows = array();	//new
                $rows1 = array();	//new
                for($i=0; $row=mysql_fetch_assoc($result1); $i++) {
                    $flag=1;
                    //below line new
                    //$rows[] = array("bus_no"=>$row['bus_no']);
                    $rows[] = array("bus_stop"=>$row['bus_stop'],"bus_lat"=>$row['latitude'],"bus_long"=>$row['longitude']);
                }

                for($i1=0; $row1=mysql_fetch_assoc($result); $i1++) {
                    $flag=1;
                    //below line new
                    $rows1[] = array("bus_no"=>$row1['bus_no']);
                    //$rows1[] = array("bus_stop"=>$row['bus_stop']);
                }

                if($flag=="0") {
                    $res=array("success"=>"0","message"=>"No records found!");
                    echo json_encode($res);
                } else if($flag=="1") {
                    // 3 new line
                    header('Content-Type: application/json');
                    $data = array('row' => $rows);
                    $data1 = array('rows' => $rows1);

                    print json_encode($data,128);
                    print json_encode($data1,128);

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
?>
<?php
$response=array();
if(isset($_GET['bus_no'])) {
    $bus_no=$_GET['bus_no'];
    $source_stop=$_GET['source_stop'];
    $bus_destination=$_GET['dest'];
    //$query="SELECT source,dest,bus_no FROM bus_info WHERE bus_id=". $bus_id." limit 1";
   $query="SELECT bus_id,bus_no,bus_lat,bus_long
FROM bus_info
WHERE dest ='$bus_destination'
AND  bus_no=".$bus_no;

    $query2="select * from Bus_Stop_Location where bus_stop='$source_stop'";

   /* $query="SELECT bus_no,bus_lat,bus_long
FROM bus_info
WHERE bus_no=356
AND dest =TATA POWER STATION";*/
    $con=mysql_connect('localhost','whereist_user','arun@123');

    if($con) {
        $r=mysql_select_db('whereist_businfo',$con);
        if($r==true) {
            $result=mysql_query($query);
            $result1=mysql_query($query2);

            if($result) {
                $flag=0;
                $rows = array();	//new
                $rows1 = array();
                for($i=0; @$row=mysql_fetch_assoc($result); $i++) {
                    $flag=1;
                    //below line new
                    $rows[] = array("id"=>$row['bus_id'],"bus_no"=>$row['bus_no'],"lat"=>$row['bus_lat'],"long"=>$row['bus_long']);
                }
                for($i1=0; @$row1=mysql_fetch_assoc($result1); $i1++) {
                    //$flag=1;
                    //below line new
                    $rows[] = array("id"=>0,"bus_stop"=>$row1['bus_stop'],"lat"=>$row1['latitude'],"long"=>$row1['longitude']);
                }
                if($flag=="0") {
                    $res=array("success"=>"0","message"=>"No records found!");
                    //echo json_encode($res);
                    echo "null";
                } else if($flag=="1") {
                    // 3 new line
                    header('Content-Type: application/json');
                    $data = array('row' => $rows);
                    //$data['no']=array('row1' => $rows1);
                    print json_encode($data,128);
                    //print json_encode($data1,128);
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

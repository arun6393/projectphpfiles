<?php

$response=array();

if(true)
{

    $source=$_GET['source'];
$dest=$_GET['destination'];
    $busno=$_GET['busno'];
    // echo $source;
    //echo $busno;

    $query="select id from Bus_Routes where stop='$source' and bus_no=$busno";
    $query1="select id from Bus_Routes where stop='$dest' and bus_no=$busno";

    $con=mysql_connect('localhost','whereist_user','arun@123');

    if($con) {
        $r=mysql_select_db('whereist_businfo',$con);
        if($r==true) {
            $result=mysql_query($query);
            $result1=mysql_query($query1);
            if($result) {
                $flag=0;
                $rows;	//new
                $rows1;	//new
                for($i=0; $row=mysql_fetch_assoc($result); $i++) {
                    $flag=1;
                    //below line new
                    $rows =$row['id'];

                }
//                echo "source stop no is".$rows;
                for($i1=0; $row1=mysql_fetch_assoc($result1); $i1++) {
                    $flag=1;
                    //below line new
                    $rows1 =$row1['id'];
                }

                //echo "destination stop no is".$rows1;

                if($flag=="0") {
                    $res=array("success"=>"0","message"=>"No records found!");
                    echo json_encode($res);
                } else if($flag=="1") {
                    // 3 new line
//                    header('Content-Type: application/json');
//                    $data = array('row' => $rows);
//                    print json_encode($data,128);
//                    echo $rows-$rows1;
                    $ans=abs($rows1-$rows)+1;
                    echo $ans;




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
    echo "first if fail";
    $res=array("success"=>"0","message"=>"error!");
    echo json_encode($res);
}
?>
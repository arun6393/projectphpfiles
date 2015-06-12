<?php
$response=array();
$rows2;	//new
$rows3;	//new
$rows4;
$z1;
$z2;
if(true){
$source=$_GET['source'];
$destination=$_GET['destination'];

$query="Select bus_no from Bus_Routes t1 where stop='".$source."'
and (select count(*) from Bus_Routes where stop='".$destination."' and
bus_no=t1.bus_no)>0";
$con=mysql_connect('localhost','whereist_user','arun@123');

if($con) {
    $r=mysql_select_db('whereist_businfo',$con);
    if($r==true) {
        $result=mysql_query($query);
        if($result) {
            $flag=0;
            $rows = array();	//new
            for($i=0; $row=mysql_fetch_assoc($result); $i++) {
                $flag = 1;
                //below line new
                $rows[] = array("bus_no" => $row['bus_no']);


                $z = $row['bus_no'];

//                echo "bus no is".$z;


                $query1 = "SELECT source,dest FROM bus_info WHERE bus_no=$z. limit 1";
                $result1 = mysql_query($query1);
                if ($result1) {
                    //     $flag1 = 0;
                    $rows1 = array();    //new
                    for ($i1 = 0; $row1 = mysql_fetch_assoc($result1); $i1++) {
                        //       $flag1 = 1;
                        //below line new
                        $rows1[] = array("Source" => $row1['source'], "dest" => $row1['dest']);

                        $z1 = $row1['source'];
                        $z2 = $row1['dest'];

//                        echo "source is" . $z1 . "and destination is" . $z2;

                    }
                    //                      echo "hi hello".$z1.$z;

                    $query2 = "select id from Bus_Routes where stop='$z1' and bus_no=$z";
                    $query3 = "select id from Bus_Routes where stop='$z2' and bus_no=$z";
                    $query4 = "select id from Bus_Routes where stop='$destination' and bus_no=$z";
                    $query5 = "select id from Bus_Routes where stop='$source' and bus_no=$z";
//                        echo "hi hello".$z1.$z;

                    $result2 = mysql_query($query2);
                    $result3 = mysql_query($query3);
                    $result4 = mysql_query($query4);
                    $result5 = mysql_query($query5);

                    //                    echo "hi hello".$z1.$z;


                    //    for ($i21 = 0; $row21 = mysql_fetch_assoc($result2); $i21++) {
                    //  $flag=1;
                    //below line new
                    // $r=mysql_num_rows($result2);
                    // echo "rows affected are".$r;
                    for ($a = 0; $row21 = mysql_fetch_assoc($result2); $a++) {
                        //  echo "hi";
                        //                      echo "hi hello".$z1.$z;

                        $rows21 = $row21['id'];

                    }
                  //      echo "source stop id is".$rows21;
                    for ($i3 = 0; $row3 = mysql_fetch_assoc($result3); $i3++) {
                        //            $flag=1;
                        //below line new
                        $rows3 = $row3['id'];
                    }
	
        //                                  echo "destination stop id is".$rows3;

                    for ($i4 = 0; $row4 = mysql_fetch_assoc($result4); $i4++) {
                        // $flag=1;
                        //below line new
                        $rows4 = $row4['id'];
                    }

          //          echo "my destination id is".$rows4;


                    for ($i51 = 0; $row51 = mysql_fetch_assoc($result5); $i51++) {
                        // $flag=1;
                        //below line new
                        $rows51 = $row51['id'];
                    }


                }


                if ($flag == "1") {
                    $stopcount = abs($rows51 - $rows4) + 1;
                    // 3 new line
                    $finalres = ($rows4 - $rows21) + 1;

           //         echo "my destination - bus ka source is".$finalres;
                    $finalres1 = ($rows4 - $rows3) + 1;
             //       echo "my destination - bus ka destination is".$finalres1;

                    if (($rows51-$rows4)<0) {      
                          // echo "i m going toward" . $z2;
                        $rows[] = array("bus_destination" => $z2);
                        $rows11[] = array("bus_no" => $row['bus_no'],"bus_destination" =>$z2,"no_of_stops" => $stopcount);
                    } else {
              //                           echo "im going towarda" . $z1;
                        $rows[] = array("bus_destination" => $z1);
                        $rows11[] = array("bus_no" => $row['bus_no'],"bus_destination" =>$z1,"no_of_stops" => $stopcount);
                    }

                    //$stopcount = abs($rows51 - $rows4) + 1;
                    //            echo "total stops count is".$stopcount;
                   // $rows11[] = array("bus_no" => $row['bus_no'],"bus_destination" =>$rows['bus_destination'],"no_of_stops" => $stopcount);
                }
            }



                    header('Content-Type: application/json');
                    $data = array('row' => $rows11);
                    print json_encode($data, 128);


        } else {
            $res=array("success"=>"0","message"=>"query error!");
            echo json_encode($res);
        }
    } else {
        $res=array("success"=>"0","message"=>"db error!");
        echo json_encode($res);
    }
} else {
    $res = array("success" => "0", "message" => "Connection error!");
    echo json_encode($res);
}

}
 else {
    echo "first if fail";
    $res=array("success"=>"0","message"=>"error!");
    echo json_encode($res);
}
?>
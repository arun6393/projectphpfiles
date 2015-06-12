<?php
$response = array();

if (isset($_GET['destination'])) {
    $destination = $_GET['destination'];


    $query = "select DISTINCT bus_no from Bus_Routes where stop='$destination'";

    $con = mysql_connect('localhost', 'whereist_user', 'arun@123');

    if ($con) {
        $r = mysql_select_db('whereist_businfo', $con);
        if ($r == true) {
            $result = mysql_query($query);
            if ($result) {
                $flag = 0;
                $rows = array();    //new
                $ad = array();
                for ($i = 0; $row = mysql_fetch_assoc($result); $i++) {
                    $flag = 1;
                    //below line new
                    $z = $row['bus_no'];


                    //echo "bus no used is".$z;

                    $query1 = "select bus_stop,latitude,longitude from Bus_Stop_Location where bus_stop in
                              (select stop from Bus_Routes where bus_no=$z)";


                    $result1 = mysql_query($query1);

                    if ($result1) {
                        for ($i1 = 0; $row1 = mysql_fetch_assoc($result1); $i1++) {
                            //$flag=1;
                            //below line new
                            $ad[] = array("Stops" => $row1['bus_stop'], "Latitude" => $row1['latitude'], "Longitude" => $row1['longitude']);
//                            $rows[] = array("Bus_no" => $row['bus_no'], "stops" => $row1['bus_stop'], "Latitude" => $row1['latitude'], "Longitude" => $row1['longitude']);

                            //echo implode("",$ad)."\t"."<br>";
                        }

                        $rows[] = array("Bus_no" => $row['bus_no'], "stops" => $ad['Stops'], "Latitude" => $ad['Latitude'], "Longitude" => $ad['Longitude']);



                        //$rows[] = array("Bus_no"=>$row['bus_no'],"stops"=>$row1['Stops'],"Latitude" => $row1['latitude'],"Longitude" => $row1['longitude']);


                    } else {
                        echo "error";
                    }


                }
                if ($flag == "0") {
                    $res = array("success" => "0", "message" => "No records found!");
                    echo json_encode($res);
                } else if ($flag == "1") {
                    // 3 new line
                    header('Content-Type: application/json');
                    $data = array('row' => $rows);
                    print json_encode($data, 128);
                    //print json_encode($ad,128);
                }
            } else {
                $res = array("success" => "0", "message" => "query error!");
                echo json_encode($res);
            }
        } else {
            $res = array("success" => "0", "message" => "db error!");
            echo json_encode($res);
        }
    } else {
        $res = array("success" => "0", "message" => "Connection error!");
        echo json_encode($res);
    }
} else {
    echo "first if fail";
    $res = array("success" => "0", "message" => "error!");
    echo json_encode($res);
}
?>
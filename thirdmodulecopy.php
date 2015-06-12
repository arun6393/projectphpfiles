<?php
$response = array();
$rows = array();    //new
$dis = 11000;
$no = array();
$no1 = 0;
$ad1 = array();
if (isset($_GET['destination'])) {
    $destination = $_GET['destination'];
    $lat = $_GET['lat'];
    $long = $_GET['long'];


    $query = "select DISTINCT bus_no from Bus_Routes where stop='$destination'";

    $con = mysql_connect('localhost', 'whereist_user', 'arun@123');

    if ($con) {
        $r = mysql_select_db('whereist_businfo', $con);
        if ($r == true) {
            $result = mysql_query($query);
            if ($result) {
                $flag = 0;

                $ad = array();
                for ($i = 0; $row = mysql_fetch_assoc($result); $i++) {
                    $flag = 1;

                    //$z2 bus no retrived
                    $z2 = $row['bus_no'];
                    $query1 = "select bus_stop,latitude,longitude from Bus_Stop_Location where bus_stop in
                              (select stop from Bus_Routes where bus_no=$z2)";


                    $result1 = mysql_query($query1);

                    if ($result1) {
                        for ($i1 = 0; $row1 = mysql_fetch_assoc($result1); $i1++) {

                            $ad[] = array("Stops" => $row1['bus_stop'], "Latitude" => $row1['latitude'], "Longitude" => $row1['longitude']);


                            $rows[] = array("stops" => $row1['bus_stop'], "Latitude" => $row1['latitude'], "Longitude" => $row1['longitude']);
                            //$z and $z1 is the lat n long of bus stop wehere the bus no halts
                            $z = $row1['latitude'];
                            $z1 = $row1['longitude'];

                            $response1 = json_decode(file_get_contents('http://maps.googleapis.com/maps/api/distancematrix/json?origins=' . $lat . ',' . $long . '&destinations=' . $z . ',' . $z1 . '&mode=bus'));
                  //          echo var_dump($response1);


                            foreach ($response1->rows as $rows3) {

                                foreach ($rows3->elements as $elements) {

                                    foreach ($elements->distance as $distance) {
               //                         echo "the distance for bus no" . $z2 . "is" . $distance . "from stop" . $row1['bus_stop'] . "<br>";

                                        $distance1 = chop($distance, "km");
                 //                       echo "the value of variable dis is" . $dis . "<br>";
                                        if ($distance1 < $dis) {
                          //                  echo $distance1 . "<" . $dis . "<br>";
                                            $dis = $distance1;

                   //                         echo "smallest distance is" . $dis . "<br>";
                                            $nearest_stop = $row1['bus_stop'];
                                            $nearest_stop_lat = $row1['latitude'];
                                            $nearest_stop_long = $row1['longitude'];
                                            break;

                                        } else {
                     //                       echo $distance1 . ">" . $dis . "<br>";
                                            break;
                                        }
                                    }
                                }

                            }
                            }


                        }else {
                        echo "error";
                    }


                }
                if ($flag == "0") {
                    $res = array("success" => "0", "message" => "No records found!");
                    echo json_encode($res);
                } else if ($flag == "1") {
                $ad2 = array();
                    $ad2[] = array("near_stop" => $nearest_stop, "lat" => $nearest_stop_lat, "long" => $nearest_stop_long);

//                    $query3 = "SELECT id,bus_no
//FROM Bus_Routes
//WHERE stop IN ('$destination', '$nearest_stop')
//GROUP BY bus_no
//HAVING COUNT(*) = 2 ";
//                    $result3 = mysql_query($query3);
//
//
//                    if ($result3) {
//                        for ($i3 = 0; $row3 = mysql_fetch_assoc($result3); $i3++) {
//
//                            $ad2[] = array("bus_no" => $row3['bus_no']);
//                        }
//                    }

                    header('Content-Type: application/json');
                    $data = array('row' => $ad2);
                    print json_encode($data, 128);
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





<?php
$response=array();
if(isset($_GET['profile'])) {


    $person_profile = $_GET['profile'];
    $all = "all";
    $range=10;
    $lat=$_GET['lat'];
    $long=$_GET['long'];

    if ($person_profile == $all) {
        $query = "SELECT * FROM login";
    } else {
        $query = "SELECT * FROM login WHERE field='$person_profile'";
    }
    $con = mysql_connect('localhost', 'whereist_user', 'arun@123');

    if ($con) {
        $r = mysql_select_db('whereist_businfo', $con);
        if ($r == true) {
            $result = mysql_query($query);
            if ($result) {
                $flag = 0;
                $rows = array();    //new
                for ($i = 0; @$row = mysql_fetch_assoc($result); $i++) {
                    $flag = 1;
                    //below line new
                    $rows1[] = array("username" => $row['username'], "password" => $row['password'], "password" => $row['password'], "longitude" => $row['longitude'], "latitude" => $row['latitude'], "field" => $row['field']);


                    $response1 = json_decode(file_get_contents('http://maps.googleapis.com/maps/api/distancematrix/json?origins=' . $lat . ',' . $long . '&destinations=' . $row['latitude'] . ',' . $row['longitude'] . '&mode=bus'));
         //           echo var_dump($response1);


                    foreach ($response1->rows as $rows3) {

                        foreach ($rows3->elements as $elements) {

                            //  var_dump($elements);

                            foreach ($elements->distance as $distance) {
                                //                         echo "the distance for bus no" . $z2 . "is" . $distance . "from stop" . $row1['bus_stop'] . "<br>";

                                $distance1 = chop($distance, "km");
                                //                       echo "the value of variable dis is" . $dis . "<br>";
                                    //                  echo $distance1 . "<" . $dis . "<br>";
                                    $dis = $distance1;
                                    $rows[] = array("username" => $row['username'], "password" => $row['password'], "password" => $row['password'], "longitude" => $row['longitude'], "latitude" => $row['latitude'], "field" => $row['field'],"distance"=>$dis);

                                break;



                            }
                        }

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
                    //     print json_encode($rows1, 128);
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
}
else {
    $res = array("success" => "0", "message" => "error!");
    echo json_encode($res);
}


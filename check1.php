<?php
$response1 = json_decode(file_get_contents('http://maps.googleapis.com/maps/api/distancematrix/json?origins=19.039598,72.895248&destinations=19.106084,72.835913&mode=bus'));


//echo $r=json_decode($response1);
echo "hi";
//$i=0;
//foreach($i as $x)
//{
//    $i++;
//    echo "ji';";
//    //echo json_encode($z);
//}
var_dump($response1);
foreach ($response1->rows as $rows1) {
    echo "hello";
    echo json_decode($rows1);
    foreach ($rows1->elements as $elements1) {

        foreach ($elements1->distance as $distance1) {
            echo $distance1;
            break;
        }
    }

}
?>
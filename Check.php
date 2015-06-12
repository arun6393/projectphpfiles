<?php
$response1 = json_decode(file_get_contents('http://maps.googleapis.com/maps/api/distancematrix/json?origins=19.039598,72.895248&destinations=19.106084,72.835913&mode=bus'));

echo "hi";
foreach ($response1->rows as $rows1) {
    echo "hello";
    foreach ($rows1->elements as $elements1) {

        foreach ($elements1->distance as $distance1) {
            echo $distance1;
            break;
        }
    }

}
?>
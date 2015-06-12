
<?php

$response=array();
if(isset($_GET['bus_no'])) {
    $bus_no=$_GET['bus_no'];
    $source_stop=$_GET['source_stop'];
    $bus_destination=$_GET['dest'];
    //$query="SELECT source,dest,bus_no FROM bus_info WHERE bus_id=". $bus_id." limit 1";
   $query="SELECT bus_no,bus_lat,bus_long
FROM bus_info
WHERE dest ='$bus_destination'
AND  bus_no=".$bus_no.

   /* $query="SELECT bus_no,bus_lat,bus_long
FROM bus_info
WHERE bus_no=356
AND dest =TATA POWER STATION";*/
    
	$con=mysql_connect('localhost','whereist_user','arun@123');

    if($con) {
        $r=mysql_select_db('whereist_businfo',$con);
        if($r==true) {
            $result=mysql_query($query);
            if($result) {
                $flag=0;
               // $rows = array();	//new
                for($i=0; @$row=mysql_fetch_assoc($result); $i++) {
                    $flag=1;
                    //below line new
                    $rows= array($row['bus_no']);
		    //sort($rows);
		//$rows1=array("lat"=>$row['bus_lat'],"dest"=>$row['bus_long']);
			
               			
}

$clength = count($rows);
for($x = 0; $x <  $clength; $x++) {
     echo $rows[$x];
     echo "<br>";
}
			
				
}
}
}
}



?>
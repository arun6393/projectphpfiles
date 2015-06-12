<?php

$response=array();
	if(true) {
        //$bus_no=$_GET['bus_no'];
        //$lat=$_GET['lat'];
        //$long=$_GET['long'];

        //$query="SELECT source,dest FROM bus_info WHERE bus_no=".$bus_no.". limit 1";
        $query= "SELECT DISTINCT bus_no from Bus_Routes";
        $con=mysql_connect('localhost','whereist_user','arun@123');

        if($con) {
            $r=mysql_select_db('whereist_businfo',$con);
            if($r==true) {
                $result=(mysql_query($query));
                if($result) {
                    $flag=0;
                     // echo mysql_num_rows($result);
                    for($i=0; $row=mysql_fetch_assoc($result); $i++)
		 {
                        $flag=1;
                        //below line new
                        $rows = array($row['bus_no']);
			echo implode("",$rows).",";
			//echo "&nbsp";

		}


		
	
	}
		}
			}
				}

?>


		


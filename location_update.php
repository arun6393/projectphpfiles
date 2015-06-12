<?php
	$response=array();
	if(isset($_GET['id'])) {
		$bus_id=$_GET['id'];
		$bus_lat=$_GET['lat'];
		$bus_long=$_GET['long'];
		
		


$query="UPDATE bus_info SET bus_lat='".$bus_lat."',bus_long='".$bus_long."' WHERE bus_id='".$bus_id."'";

		
		$con=mysql_connect('localhost','whereist_user','arun@123');

		if($con) {
			$r=mysql_select_db('whereist_businfo',$con);
			if($r==true) {
				$result=mysql_query($query,$con);
				if($result) {
					if(mysql_affected_rows()>0)
				{	echo "updated";
				}
				
				else
		{
			echo "error";
		echo "error".mysql_errno();	
		}
				}
			}
		}
		
	}
?>
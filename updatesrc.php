<?php
	$response=array();
	if(isset($_GET['id'])) {
		$bus_id=$_GET['id'];
		$bus_source=$_GET['source'];
		$bus_dest=$_GET['destination'];
		
		


$query="UPDATE bus_info SET source='".$bus_source."',dest='".$bus_dest."' WHERE bus_id='".$bus_id."'";

		
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
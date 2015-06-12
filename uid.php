<?php
	$response=array();
	
		$id=$_GET['busid'];
		$bno=$_GET['busno'];
		$src=$_GET['bussrc'];
		$des=$_GET['busdes'];
		
	
$query="INSERT into Driver_info(u_id,bus_no,source,destination) values ('$id','$bno','$src','$des')";
	
	$con=mysql_connect('localhost','whereist_user','arun@123');

		if($con) {
			$r=mysql_select_db('whereist_businfo',$con);
			if($r==true) {
				if(mysql_query($query,$con));
				echo "data inserted";
			}
		}
	
	else
	{
	echo "error";	
	}
echo 	json_encode($id);
		?>
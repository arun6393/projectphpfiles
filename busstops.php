<?php
	$response=array();
	if(isset($_GET['busdestination'])) {
		$bus_destiation=$_GET['busdestination'];
		//$lat=$_GET['lat'];
		//$long=$_GET['long'];

$query="SELECT busno FROM BUS2 WHERE bus_stop='KHAR'";

  	$con=mysql_connect('localhost','whereist_user','arun@123');

		if($con) {
			$r=mysql_select_db('whereist_businfo',$con);
			if($r==true) {
				$result=mysql_query($query);
				if($result) {
					$flag=0;
					$rows = array();	//new
					for($i=0; $row=mysql_fetch_assoc($result); $i++) {
						$flag=1;
						//below line new
						$rows[] = array("busno"=>$row['busno']);;
					} 
					if($flag=="0") {
						$res=array("success"=>"0","message"=>"No records found!");
						echo json_encode($res);
					} else if($flag=="1") {
						// 3 new line
						header('Content-Type: application/json');
						$data = array('row' => $rows);
						print json_encode($data,128);
					}
				} else {
					$res=array("success"=>"0","message"=>"query error!");
					echo json_encode($res);
				}
			} else {
				$res=array("success"=>"0","message"=>"db error!");
				echo json_encode($res);
			}	
		} else {
			$res=array("success"=>"0","message"=>"Connection error!");
			echo json_encode($res);
		}
	} else {
		echo "first if fail";
			$res=array("success"=>"0","message"=>"error!");
			echo json_encode($res);
	}
?>
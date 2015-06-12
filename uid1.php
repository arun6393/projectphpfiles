<?php
	$response=array();
	$lat=$_GET['buslat'];
	$long=$_GET['buslong'];
	$id=$_GET['busid'];
	$query="UPDATE driver_info1 SET lat=$lat,long=$long WHERE id=$id";
	//UPDATE settings SET postsPerPage = $postsPerPage, style = $style WHERE id = '1'"
	$con=mysql_connect('localhost','whereist_user','arun@123');
	echo $lat.$long.$id;
		if($con) {
			$r=mysql_select_db('whereist_businfo',$con);
			if($r==true) 
				{
				mysql_query($query,$con);	
				//	while($row=mysql_fetch_assoc($result))
					//echo $row['no'];
				//	$s=mysql_num_rows($result);
					//echo $s;
				
			/*	else
				{
					echo "no row selected":
				}*/
				echo "successgul";
				}
			
		}else
		{
			echo "error";
		}
		
				
		
		?>
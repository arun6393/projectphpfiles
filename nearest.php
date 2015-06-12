<?php

$response=array();

if(true)
{

$bus_no=$_GET['bus_no'];
$bus_stop=$_GET['bus_stop'];
//$towards=$_GET['towards'];

$query="select latitude,longitude from Bus_Stop_Location where bus_stop=".$bus_stop."";
$query1="select latitude,longitude from bus_info where bus_no=".$bus_no.""; 
	
	$con=mysql_connect('localhost','whereist_user','arun@123');

   	if($con) {

            $r=mysql_select_db('whereist_businfo',$con);
            
		if($r==true) {
                
			$result=(mysql_query($query));
				
				if($result)
                		{
					$row=mysql_fetch_assoc($result);
					$a=row["latitude"];
					$b=row["longitude"];
					echo $a;
				}   

		$result1=(mysql_query($query1));
		
		 for($i1=0; $row1=mysql_fetch_assoc($result1); $i1++) 
			{
			if($a<$row1['latitude'] && $b<row['longitude'])
				{
				echo $a." and ".$b;
				}
			else 
			{
			echo $row1['latitude'];
			echo $row1['longitude'];
			}	


			}





              
		 
}
}
}




?>

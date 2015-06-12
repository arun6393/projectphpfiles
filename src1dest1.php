<?php


if(true)

{

//$source=$_GET['source'];
    $destination=$_GET['destination'];
//$busno=$_GET['busno'];

    $query="select DISTINCT bus_no from Bus_Routes where stop='$destination'";

    //$query1="select id from Bus_Routes where stop='$source' and bus_no=$busno";
//$query2="select id from Bus_Routes where stop='$destination' and bus_no=$busno";

    $con=mysql_connect('localhost','whereist_user','arun@123');

    if($con)
    {

        $r=mysql_select_db('whereist_businfo',$con);
        if($r==true) {
            $result=mysql_query($query);
            // $result1=mysql_query($query1);
            // $result2=mysql_query($query2);

            if($result)
            {


                for($i=0; $i<mysql_num_rows($result) ; $i++)
                {
                    $row=mysql_fetch_assoc($result);
                    $flag=1;
                    //below line new
                    $as = array($row['bus_no']);
                    //echo "bus no are".implode("",$as)."<br>";
                    echo "bus no are".$as;


                    $query1="select bus_stop,latitude,longitude from Bus_Stop_Location where bus_stop in (select stop from Bus_Routes where bus_no=$as[$i])";

                    $result1=mysql_query($query1);

                    if($result1)

                    {
                        for($i1=0; $row1=mysql_fetch_assoc($result1); $i1++)
                        {
                            $flag=1;
                            //below line new
                            $ad = array("Stops" => $row1['bus_stop'],"Latitude" => $row1['latitude'],"Longitude" => $row1['longitude']);
                            echo implode("",$ad)."\t"."<br>";
                        }


                    }


                }


            }

        }


    }


}


?>
<?php
    $key=$_GET['key'];
    $array = array();
    $con=mysqli_connect("localhost","root","navin@mca","medical-store");
    //$db=mysql_select_db("demos",$con);
    $query=mysqli_query($con,"select * from medicine where name LIKE '%{$key}%'");
    while($row=mysqli_fetch_assoc($query))
    {
      $array[] = $row['name'];
    }
    echo json_encode($array);
?>

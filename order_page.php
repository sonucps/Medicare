<?php
session_start();
$_SESSION['med'];
//print_r($_SESSION);

?>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!DOCTYPE HTML>
<!--
	Projection by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>
	<head>
		<title>E-Meds</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	</head>
	<body>

		<!-- Header -->
			<header id="header">
				<div class="inner">
					<a href="index.html" class="logo"><strong>E-Meds</strong><img src="images/phrmcy.png" width="50"></a>
					<nav id="nav">
						<a href="index.html">Home&nbsp;&nbsp;&nbsp;</a>


						<?php
							if($_SESSION['customer']=="")
							{
								header('location:index.html');
							}
							else
							{
								echo "Welcome: ".$_SESSION['customer'];
							}
						?>
						
					   <a href="order_page.php">Order History</a>

					   <a style="color: #fff;" href="distroy_session.php">Logout</a>

					</nav>
					<a href="#navPanel" class="navPanelToggle"><span class="fa fa-bars"></span></a>
				</div>

				<style type="text/css">
					#tab
						{
							color: #000;
							background-color: #cccccc;
							border-radius: 5px;
						}
				</style>

			</header>

		<!-- Banner -->
			<section id="banner">
				<div class="inner">
					<header>
						<?php
						include 'config.php';
						if(!($dbconn = @mysqli_connect($dbhost, $dbuser, $dbpass,$db))) exit('Error connecting to database.');
						//mysql_select_db($db);
						$email_x=$_SESSION['customer'];
						$med=$_SESSION['med'];
						$original_quantity;
						$getTxnId = mysqli_query($dbconn,"SELECT * FROM purchase where email='$email_x'");

						$rowcount=mysqli_num_rows($getTxnId);

						if($rowcount==0)
						{
										echo "<div class='alert alert-danger alert-dismissible'>
										 <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
										 <strong>Sorry!</strong> You Have No Order History.
										 </div>";

										 echo "<a href='index.html'><button style='color:#f2dede !important; margin-bottom: 20px;' type='button' class='btn btn-success'>Continue Shoping</button></a>";
						}
						else
						{
							while ($row = mysqli_fetch_array($getTxnId))
							{
								echo "<table id='tab'><tr>";
								echo "<th>Email Id</th><th>Buy Date</th><th>Medicine Name</th><th>Quantity</th></tr><tr>";
								echo "<td>".$row['email']."</td>";
								echo "<td>".$row['buy_time']."</td>";
								echo "<td>".$row['medicine_name']."</td>";
								echo "<td>".$row['quatity']."</td>";								
								//echo $row['buy_timestamp']." ".$row['expiry_date']." ".$row['chem_amount']." ".$row['qty']." ".$row['sp'];
								echo "</tr></table>";
								$original_quantity=$row['quatity'];
							}

							echo "<a href='index.html'><button style='color:#f2dede !important; margin-bottom: 20px;' type='button' class='btn btn-success'>Continue Shoping</button></a>";

							?>

					</header>

					<?php 
					}
					?>

					
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
		<style type="text/css">
			#header a {
    color: #ffffff;
    text-decoration: none;}
		</style>

		<!-- Header -->
			<header id="header">
				<div class="inner">
					<a href="index.html" class="logo"><img src="images/phrmcy.png" width="50"><strong><font size="15">Medicare</font></a>
					<nav id="nav">
						<a style="color: #fff;" href="index.html">Home&nbsp;&nbsp;&nbsp;</a>


						<?php
						if($_SESSION['customer']=="")
						{
							header('location:index.html');
						}
						else
						{
							echo "<span style='color: #fff;''>Welcome: ".$_SESSION['customer']."</span>";
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
						$med=$_SESSION['med'];
						$original_quantity;
						$getTxnId = mysqli_query($dbconn,"SELECT * FROM medicine where name='$med'");

						$rowcount=mysqli_num_rows($getTxnId);

						if($rowcount==0)
						{
										echo "<div class='alert alert-danger alert-dismissible'>
										 <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
										 <strong>Sorry!</strong> No Such Medicine Found.
										 </div>";

										 echo "<a href='index.html'><button style='color:#f2dede !important; margin-bottom: 20px;' type='button' class='btn btn-success'>Continue Shoping</button></a>";
						}
						else
						{
							while ($row = mysqli_fetch_array($getTxnId))
							{
								echo "<table id='tab'><tr>";
								echo "<th>Medicine Name</th><th>Expire Date</th><th>Chemical Compound</th><th>Quantity</th><th>Selling Price</th></tr><tr>";
								echo "<td>".$row['name']."</td>";
								echo "<td>".$row['expiry_date']."</td>";
								echo "<td>".$row['chem_amount']."</td>";
								echo "<td>".$row['qty']."</td>";
								echo "<td>".$row['sp']."</td>";
								
								//echo $row['buy_timestamp']." ".$row['expiry_date']." ".$row['chem_amount']." ".$row['qty']." ".$row['sp'];
								echo "</tr></table>";
								$original_quantity=$row['qty'];
							}


						

						
							if(isset($_GET['Order']))
							{
								$Quantity=$_GET['med_quan'];
								if($Quantity>$original_quantity)
								{
									echo "<div class='alert alert-danger alert-dismissible'>
										 <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
										 <strong>Notice!</strong> You Can Only Buy Limited no. of Medicines.
										 </div>";
								}
								else
								{
									$new_qty=$original_quantity-$Quantity;
									$email=$_SESSION['customer'];
									$date=date("Y-m-d");
									// Create connection
									$conn = new mysqli($dbhost, $dbuser, $dbpass,$db);

									$sql = "INSERT INTO purchase VALUES ('$email','$date','$med','$Quantity')";
									$conn->query($sql);
									$sql2 = "UPDATE medicine SET qty='$new_qty' WHERE name='$med'";
									$conn->query($sql2);

									$conn->close();

									echo "<div class='alert alert-success alert-dismissible'>
										 <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
										 <strong>Thank-You!</strong> Your Order is Successfully Booked with Us. Medicines will be delivered in 4-5hrs on your registered address.
										 </div>";

									echo "<a href='index.html'><button style='color:#f2dede !important; margin-bottom: 20px;' type='button' class='btn btn-success'>Continue Shoping</button></a>";
								}
							}

							?>

									<div class="container">
										
									
									  	<form class="form-inline"  action="perchase_pro_x.php" method="GET">
									  		<div class="form-group">
									    <label style="color: #fff;">Select The Quantity You Want To Order:</label>
									    <input class="form-control" name="med_quan" type="number">
									    <input type="submit" value="Place Order" name="Order">
											</div>
									    </form>
									  

									</div>
					</header>

					<?php 
					}
					?>

					
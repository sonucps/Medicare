

<?php 
session_start();
//print_r($_SESSION);

	if(@$_SESSION['customer']=="")
	{
		unset($_SESSION['customer']); 
	}
	else
	{
		$_SESSION['med']=$_GET['med'];
		 header('Location:perchase_pro_x.php');	
	}

?>

<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <style type="text/css">
  body
  {
  	background-image: url("images/banner.jpg");
  }
  #img {
    vertical-align: middle;
    width: 80px;
    margin: 28px;
}
  	#box
  	{
  		width: 48%;
  		height: 530px;
  		background-color: #ccc;
  		margin: 7px;
  		border-radius: 13px;
  	}
  	.btn-success {
    color: #fff;
    background-color: #5cb85c;
    border-color: #4cae4c;
    border-radius: 5px;
    width: 100px;
    padding: 7px;
    margin-top: 10px;
}
.input-group {
    position: relative;
    display: table;
    border-collapse: separate;
    margin-top: 16px;
}
  </style>
</head>
<body>

	<div class="container">
		<div class="col-md-12">
			<center><img id="img" src="images/phrmcy.png" ><strong style="color: #fff;"><font size="15">Medicare</font></center>
		</div>

		<div class="col-md-12">

			<div id="box" class="col-md-6">
			<center><img style="margin-top: 37px;" src="images/Registration.png"></center>
		   <form style="margin-top: 30px;" method="post" action="registration_process.php">
			<div class="input-group">
		     <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
		     <input id="name" type="text" class="form-control" name="name" placeholder="Name">
		     <input  type="hidden" name="med_x" value="<?php echo $_GET['med'];?>" >
		    </div>

			<div class="input-group">
		     <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
		     <input id="email" type="email" class="form-control" name="email" placeholder="Email">
		    </div>

		    <div class="input-group">
		      <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
		      <input id="password" type="password" class="form-control" name="password" placeholder="Password">
		    </div>

		    <div class="input-group">
		      <span class="input-group-addon"><i class="glyphicon glyphicon-flag"></i></span>
		      <textarea class="form-control" name="address" rows="5" id="comment"></textarea>
		    </div>

			<input type="submit" name="reg" class="btn-success" text="Register">
			</form>
			</div>


			<div id="box" class="col-md-6">
			<img  src="images/login.png">
			<form method="post" action="login_process.php">
			<div class="input-group">
		     <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
		     <input id="email" type="text" class="form-control" name="email" placeholder="Email">
		     <input  type="hidden" name="med_x" value="<?php echo $_GET['med'];?>" >
		    </div>
		    <div class="input-group">
		      <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
		      <input id="password" type="password" class="form-control" name="password" placeholder="Password">
		    </div>
			<input type="submit" name="login" class="btn-success" text="Login">
			</form>
			</div>

		</div>
	</div>
</body>
</html>



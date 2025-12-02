<?php
session_start();

if(@$_SESSION['customer']=="")
		{	
			if (isset($_POST["reg"]))
			{
				include 'config.php';
				echo $med=$_POST['med_x'];
				$name=$_POST['name'];
				$email= $_POST['email'];
				$pass= $_POST['password'];
				echo $add=$_POST['address'];

				// Create connection
				$conn = new mysqli($dbhost, $dbuser, $dbpass, $db);
				// Check connection
				if ($conn->connect_error) 
				{
					die("Connection failed: " . $conn->connect_error);
				} 

				$sql = "INSERT INTO customer VALUES ('$name','$email','$pass','$add')";

					if ($conn->query($sql) === TRUE) 
					{
						$_SESSION['customer']=$email;
						$_SESSION['med']=$med;
						header('Location:perchase_pro_x.php');
					} 
					else 
					{
						header('Location:perchase_pro_x.php');
						echo "Error: " . $sql . "<br>" . $conn->error;
					}

				$conn->close();
			}
		}
?>
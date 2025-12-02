<?php

session_start();
if (isset($_POST["login"]))
			{
				include 'config.php';
				echo $med=$_POST['med_x'];
				$email= $_POST['email'];
				$pass= $_POST['password'];


				// Create connection
				$conn = new mysqli($dbhost, $dbuser, $dbpass, $db);
				// Check connection
				if ($conn->connect_error) 
				{
					die("Connection failed: " . $conn->connect_error);
				} 

				$sql = "SELECT * FROM customer where email='$email' AND password='$pass'";

					if ($result=mysqli_query($conn,$sql)) 
					{
						if($rowcount=mysqli_num_rows($result)==1)
						{
							echo "Selected..........";
							echo $_SESSION['customer']=$email;
							echo $_SESSION['med']=$med;
							echo $med=$_REQUEST['med'];
							 header('Location:perchase_pro_x.php');
						}  
					} 
					else 
					{
						echo "cant fetch";
					}

				$conn->close();
			}
		?>
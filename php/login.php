<?php
    session_start();

    include "connection.php";
    
	global $conn;

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(isset($_POST["username"]) && isset($_POST["password"])){
			$myusername = $_POST["username"];
			$mypassword = $_POST["password"];

			$query = "SELECT * FROM MAHASISWA WHERE username='$myusername' AND password='$mypassword'";
			$result = mysqli_query($conn, $query);
			$row = mysqli_fetch_assoc($result);
			if($row["username"] == $myusername)
			{
				if($row["password"] == $mypassword)
				{
					$_SESSION["activeuser"] = $row["username"];
					$_SESSION["log_id"] = $row["id"];
					header("Location: home.php");
				}
			}
			else
			{
				echo "the combination of username and password is invalid";
			}
		}
	}	
?>

<!Doctype html>
<html>
	<head>
		<meta charset = "utf-8">
		<title>Login</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link id="general_theme" rel="stylesheet" type = "text/css" href = "../css/style.css"/>
		<link id="local_theme" rel="stylesheet" type = "text/css" href = "../css/login.css"/>
		<link type = "text/css" rel="stylesheet" href="../css/bootstrap.min.css"/>
	</head>

	<body style="overflow-x:hidden">
		<div class="header">
			<div id="navWrapper">
				<nav id="mainNavigation" class="navbar navbar-inverse navbar-fixed-top">
					<div class="container-fluid">
						<div class="navbar-header">
					    	<h3 class="navbar-title" href="#">
					    		SISIDANG
					    	</h3>
						</div>
					</div>
				</nav>
			</div>
		</div>


		<div class="outer">
			<div class="middle">
				<div class="inner">
					<form class="form" method="post" action="login.php">
						<h1>Login</h1>
						<input id="username" type="text" name="username" placeholder="Username">
						<input id="password" type="password" name="password" placeholder="Password">
						<button type="submit" id="login-button">
						Login</button>
					</form>
				</div>
			</div>
		</div>



		
		
		<footer>
			
		</footer>
		<script type="text/javascript" src=""></script>

	</body>
</html>


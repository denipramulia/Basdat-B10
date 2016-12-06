<?php
    session_start();

    include "connection.php";
    
	global $conn;

	// if(mysql_ping()){
	// 	echo "konek";
	// }

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(isset($_POST["username"]) && isset($_POST["password"])){
			$myusername = $_POST["username"];
			$mypassword = $_POST["password"];

			$query = "SELECT * FROM MAHASISWA WHERE Username='$myusername' AND Password='$mypassword'";
			$result = mysqli_query($conn, $query);
			$row = mysqli_fetch_assoc($result);
			if($row["Username"] == $myusername)
			{
				if($row["Password"] == $mypassword)
				{
					$_SESSION["activeuser"] = $row["Username"];
					$_SESSION["log_id"] = $row["NPM"];
					$_SESSION["user_type"] = "mahasiswa";
					header("Location: home.php");
				}
			}
			$query = "SELECT * FROM dosen WHERE Username='$myusername' AND Password='$mypassword'";
			$result = mysqli_query($conn, $query);
			$row = mysqli_fetch_assoc($result);
			if($row["Username"] == $myusername)
			{
				if($row["Password"] == $mypassword)
				{
					$_SESSION["activeuser"] = $row["username"];
					$_SESSION["log_id"] = $row["NIP"];
					$_SESSION["user_type"] = "dosen";
					header("Location: home.php");
				}
			}

			$query = "SELECT * FROM admin WHERE Username='$myusername' AND Password='$mypassword'";
			$result = mysqli_query($conn, $query);
			$row = mysqli_fetch_assoc($result);
			if($row["Username"] == $myusername)
			{
				if($row["Password"] == $mypassword)
				{
					$_SESSION["activeuser"] = $row["Username"];
					$_SESSION["log_id"] = $row["IdAdmin"];
					$_SESSION["user_type"] = "admin";
					header("Location: jadwal.php");
				}
			}
			
			else
			{
				echo $myusername . $mypassword;
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
		<nav class="navbar navbar-inverse">
		  <div class="container-fluid">
		    <div class="navbar-header">
		      <a class="navbar-brand" href="#">SISIDANG</a>
		    </div>
		    <ul class="nav navbar-nav">
		      
		    </ul>
		  </div>
		</nav>


		<div class="outer">
			<div class="middle">
				<div class="inner">
					<form class="form" method="post" action="login.php">
						<h1>Login</h1>
						<input id="username" type="text" name="username" placeholder="Username">
						<input id="password" type="password" name="password" placeholder="Password">
						<button onclick="jadwal.php" type="submit" id="login-button">
						Login</button>
					</form>
				</div>
			</div>
		</div>



		
		
		<footer>
			
		</footer>
		<script type="text/javascript" src="../js/jquery-3.1.1.js"></script>

	</body>
</html>


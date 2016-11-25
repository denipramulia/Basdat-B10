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
		<title>Jadwal</title>
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

		<br>
		<br>
		<br>
		<br>

		<div class="tabel-jadwal">
			<div class="btn-group" role="group" aria-label="...">
				<h3>Sort by: </h3>
				<button type="button" class="btn btn-default">Mahasiswa</button>
				<button type="button" class="btn btn-default">Jenis Sidang</button>
				<button type="button" class="btn btn-default">Waktu</button>
			</div>
			<table class="table table-striped">
				<thead>
		  			<tr>
						<th>Mahasiswa</th>
						<th>Jenis Sidang</th> 
						<th>Judul</th>
						<th>Waktu dan Lokasi</th>
						<th>Dosen Pembimbing</th>
						<th>Dosen Penguji</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Aan Kurniawan</td>
						<td>Skripsi</td> 
					    <td>Sistem Operasi Masa Depan</td>
					    <td>17 Nov 2016, 16:00 - 17:00, 1101</td>
					    <td>Ani Sulistyowati</td>
					    <td>Budi Gunawan</td>
					    <td>Edit</td>
					</tr>
					<tr>
					    <td>Aan Kurniawan</td>
						<td>Skripsi</td> 
					    <td>Sistem Operasi Masa Depan</td>
					    <td>17 Nov 2016, 16:00 - 17:00, 1101</td>
					    <td>Ani Sulistyowati</td>
					    <td>Budi Gunawan</td>
					    <td>Edit</td>
					</tr>
					<tr>
					    <td>Aan Kurniawan</td>
						<td>Skripsi</td> 
					    <td>Sistem Operasi Masa Depan</td>
					    <td>17 Nov 2016, 16:00 - 17:00, 1101</td>
					    <td>Ani Sulistyowati</td>
					    <td>Budi Gunawan</td>
					    <td>Edit</td>
					</tr>
					<tr>
					    <td>Aan Kurniawan</td>
						<td>Skripsi</td> 
					    <td>Sistem Operasi Masa Depan</td>
					    <td>17 Nov 2016, 16:00 - 17:00, 1101</td>
					    <td>Ani Sulistyowati</td>
					    <td>Budi Gunawan</td>
					    <td>Edit</td>
					</tr>
					<tr>
					    <td>Aan Kurniawan</td>
						<td>Skripsi</td> 
					    <td>Sistem Operasi Masa Depan</td>
					    <td>17 Nov 2016, 16:00 - 17:00, 1101</td>
					    <td>Ani Sulistyowati</td>
					    <td>Budi Gunawan</td>
					    <td>Edit</td>
					</tr>
				</tbody>
			</table>
		</div>


		
		
		<footer>
			
		</footer>
		<script type="text/javascript" src=""></script>

	</body>
</html>


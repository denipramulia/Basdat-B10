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
		<nav class="navbar navbar-inverse">
		  <div class="container-fluid">
		    <div class="navbar-header">
		      <a class="navbar-brand" href="#">SISIDANG</a>
		    </div>
		    <ul class="nav navbar-nav">
		      <li class="active"><a href="#">Home</a></li>
		      <li><a href="#">Tambah Peserta MKS</a></li>
		      <li><a href="#">Buat Jadwal Sidang MKS</a></li> 
		      <li><a href="#">Buat Jadwal Non-Sidang Dosen</a></li>
		      <li><a href="#">Lihat Jadwal Sidang</a></li>
		      <li><a href="#">Lihat Daftar MKS</a></li> 
		      <li><a href="login.php">Logout</a></li> 
		    </ul>
		  </div>
		</nav>



		<div class="tabel-jadwal container">
			<div class="row">
				<div class="col-md-1"><p id="left">Sort by: </p></div>
				<div id="right" class="col-md-9" role="group" aria-label="...">
					<button type="button" class="btn btn-default">Mahasiswa</button>
					<button type="button" class="btn btn-default">Jenis Sidang</button>
					<button type="button" class="btn btn-default">Waktu</button>
				</div>
			</div>
			<br>
			<div class="row">
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
			<div class="row">
				<div class="col-md-1 pull-right">
					<button id="btn-tambah" class="btn btn-primary">Tambah</button>
				</div>
			</div>
		</div>


		
		<footer>
			
		</footer>
		<script type="text/javascript" src=""></script>

	</body>
</html>


<?php
    session_start();

    include "connection.php";
    
	global $conn;

	$user_type = $_SESSION["user_type"];
	$username = $_SESSION["activeuser"];
	$log_id = $_SESSION["log_id"];

	if ($_SESSION["user_type"] == "mahasiswa") {
		$query = "SELECT * FROM mahasiswa WHERE npm = $log_id";
		$result = mysqli_query($conn, $query);
		$mahasiswa = mysqli_fetch_assoc($result);

	}
	if ($_SESSION["user_type"] == "dosen"){
		$query = "SELECT * FROM mata_kuliah_spesial 
				  INNER JOIN dosen_penguji 
				  ON mata_kuliah_spesial.IdMKS = dosen_penguji.IDMKS 
				  WHERE NIPdosenpenguji = CAST($log_id as varchar(20))";
		$result = mysqli_query($conn, $query);
		$mksuji = mysqli_fetch_assoc($result);
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
		      <li><a href="jadwal.php">Lihat Jadwal Sidang</a></li>
		      <li><a href="#">Lihat Daftar MKS</a></li> 
		      <li><a href="logout.php">Logout</a></li> 
		    </ul>
		  </div>
		</nav>

		<?php
			if($user_type == "mahasiswa"){
				$npm = $mahasiswa["NPM"];
				$nama = $mahasiswa["Nama"];
				$email = $mahasiswa["Email"];
				$email_alt = $mahasiswa["Email_alternatif"];
				$telepon = $mahasiswa["Telepon"];
				echo "
				<div class='biodata container'>
					<div class='row'>
						<table class='table table-striped'>
							<thead>
					  			<tr>
									<th>NPM</th>
									<th>Nama</th> 
									<th>Email</th>
									<th>Email Alternatif</th>
									<th>Nomor Telepon</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>$npm</td>
									<td>$nama</td> 
								    <td>$email</td>
								    <td>$email_alt</td>
								    <td>$telepon</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>";
			}
		?>

		

		
		<footer>
			
		</footer>
		<script type="text/javascript" src=""></script>

	</body>
</html>


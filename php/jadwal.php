<?php
    session_start();

    include "connection.php";
    
	global $conn;

	$user_type = $_SESSION["user_type"];
	$username = $_SESSION["activeuser"];
	$log_id = $_SESSION["log_id"];

	if ($_SESSION["user_type"] == "mahasiswa") {
		$query = "SELECT * FROM mata_kuliah_spesial WHERE npm = $log_id";
		$result = mysqli_query($conn, $query);
		$mks = mysqli_fetch_assoc($result);
		$IdMKS = $mks['IdMKS']; 

		$query = "SELECT * FROM jadwal_sidang WHERE IdMKS = $IdMKS";
		$result = mysqli_query($conn, $query);
		$jadwal = mysqli_fetch_assoc($result);

		$query = "SELECT * FROM dosen INNER JOIN dosen_pembimbing ON dosen.NIP = dosen_pembimbing.NIPdosenpembimbing WHERE IDMKS = $IdMKS";
		$result = mysqli_query($conn, $query);
		$pembimbing = mysqli_fetch_assoc($result);

		$query = "SELECT * FROM dosen INNER JOIN dosen_penguji ON dosen.NIP = dosen_penguji.NIPdosenpenguji WHERE IDMKS = $IdMKS";
		$result = mysqli_query($conn, $query);
		$penguji = mysqli_fetch_assoc($result);
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
		      <li><a href="home.php">Home</a></li>
		      <li><a href="#">Tambah Peserta MKS</a></li>
		      <li><a href="#">Buat Jadwal Sidang MKS</a></li> 
		      <li><a href="#">Buat Jadwal Non-Sidang Dosen</a></li>
		      <li class="active"><a href="#">Lihat Jadwal Sidang</a></li>
		      <li><a href="#">Lihat Daftar MKS</a></li> 
		      <li><a href="logout.php">Logout</a></li> 
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
					</tbody>
			</div>
		</div>


		<div class="tabel-jadwal container">
			<?php 
				if($_SESSION["user_type"] == "admin"){
					echo 
					"
						<div class='row'>
							<div class='col-md-1'><p id='left'>Sort by: </p></div>
							<div id='right' class='col-md-9' role='group' aria-label='...'>
								<button type='button' class='btn btn-default'>Mahasiswa</button>
								<button type='button' class='btn btn-default'>Jenis Sidang</button>
								<button type='button' class='btn btn-default'>Waktu</button>
							</div>
						</div>
						<br>
						<div class='row'>
							<table class='table table-striped'>
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
						<div class='row'>
							<div class='col-md-1 pull-right'>
								<button id='btn-tambah' class='btn btn-primary'>Tambah</button>
							</div>
						</div>
					";
				}
				if($_SESSION["user_type"] == "mahasiswa"){
					if($mks['IjinMajuSidang'] == TRUE) {
				   		$ijin = "Diizinkan maju sidang, ";
				   	}
				   	else{
				   		$ijin = "Belum diizinkan maju sidang, ";
				   	}
				   	if($mks["PengumpulanHardCopy"] == TRUE) {
				   		$kumpul = "Hardcopy telah dikumpulkan";
				   	}
				   	else{
				   		$kumpul = "Hardcopy belum dikumpulkan";
				   	}
				   	$judul = $mks['Judul'];
				   	$tanggal = $jadwal['Tanggal'];
				   	$JamMulai = $jadwal['JamMulai'];
				   	$pembimbing = $pembimbing['Nama'];
				   	$penguji = $penguji['Nama'];
					echo "
					<div class='row'>
					<table class='table table-reflow'>
						<thead>
							<th>Judul Tugas Akhir</th>
							<th>Jadwal Sidang</th>
							<th>Waktu Sidang</th>
							<th>Dosen Pembimbing</th>
							<th>Status</th>
							<th>Dosen Penguji</th>
						</thead>
						<tbody>
			    			<td>$judul</td>
			    			<td>$tanggal</td>
			    			<td>$JamMulai</td>
			    			<td>$pembimbing</td>
			    			<td>$ijin, $kumpul</td>
					    	<td>$penguji</td>
			    		</tbody>
					</table>
					</div>";
				}
				if($_SESSION["user_type"] == "dosen"){
					
				}
			?>
		</div>
		


		
		<footer>
			
		</footer>
		<script type="text/javascript" src=""></script>

	</body>
</html>


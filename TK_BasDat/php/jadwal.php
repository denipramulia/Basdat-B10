<?php
    session_start();

    include "connection.php";
    
	global $conn;

	if(!isset($_SESSION["log_id"])){
	  	header('Location: login.php');
	}

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
		$post = array();
		$post['mahasiswa'] = array();
		$post['jenis_sidang'] = array();
		$post['judul'] = array();
		$post['tanggal'] = array();
		$post['jam_mulai'] = array();
		$post['jam_selesai'] = array();
		$post['lokasi'] = array();
		$post['orang_lain'] = array(array());
		$post['orang_lain'] = array(array());
		$post['status'] = array();
		$post['sebagai'] = array();

		$query = "SELECT * FROM mata_kuliah_spesial 
				  INNER JOIN dosen_penguji 
				  ON mata_kuliah_spesial.IdMKS = dosen_penguji.IDMKS 
				  WHERE NIPdosenpenguji = CONVERT($log_id, char(20))";
		$result = mysqli_query($conn, $query);

		$i = 0;
		while($mks = mysqli_fetch_assoc($result))
		{
			$post['sebagai'][$i] = "penguji";
			$npm = $mks["NPM"];
			$query = "SELECT * FROM mahasiswa WHERE NPM = $npm";
			$res = mysqli_query($conn, $query);
			$mahasiswa = mysqli_fetch_assoc($res);
			$post['mahasiswa'][$i]    	 = $mahasiswa["Nama"];

			$IdJenisMKS = $mks["IdJenisMKS"];
			$query = "SELECT * FROM JENISMKS WHERE ID = $IdJenisMKS";
			$res = mysqli_query($conn, $query);
			$jenis_MKS = mysqli_fetch_assoc($res);
			$post['jenis_sidang'][$i]	 = $jenis_MKS["NamaMKS"];
			
			$post['judul'][$i]   		 = $mks["Judul"];

			$IdMKS = $mks["IdMKS"];
			$query = "SELECT * FROM jadwal_sidang WHERE IdMKS = $IdMKS";
			$res = mysqli_query($conn, $query);
			$jadwal = mysqli_fetch_assoc($res);
			$post['tanggal'][$i]    = $jadwal["Tanggal"];
			$post['jam_mulai'][$i]  = $jadwal["JamMulai"];
			$post['jam_selesai'][$i]= $jadwal["JamSelesai"];
			$IDRuangan= $jadwal["IDRuangan"];
			$query = "SELECT * FROM ruangan WHERE IDRuangan = $IDRuangan";
			$res = mysqli_query($conn, $query);
			$ruangan = mysqli_fetch_assoc($res);
			$post["lokasi"] = $ruangan["NamaRuangan"];

			$query = "SELECT * FROM dosen_penguji INNER JOIN dosen ON dosen_penguji.NIPDosenPenguji = dosen.NIP WHERE IdMKS = $IdMKS";
			$res = mysqli_query($conn, $query);
			$j = 0;
			while($orang_lain = mysqli_fetch_assoc($res)){
				$post['orang_lain'][$i][$j] = $orang_lain["Nama"];
				$j++;
			}
			
			if($mks["IjinMajuSidang"] == 0){
				$post["status"][$i] = "Belum Boleh Masuk Sidang, ";
			} else {
				$post["status"][$i] = "Boleh Masuk Sidang, ";
			}
			if($mks["PengumpulanHardCopy"] == 0){
				$post["status"][$i] = $post["status"][$i]."Belum Mengumpulkan Hard Copy";
			} else {
				$post["status"][$i] = $post["status"][$i]."Sudah Mengumpulkan Hard Copy";
			}
			$i++;
		}

		$query = "SELECT * FROM mata_kuliah_spesial 
				  INNER JOIN dosen_pembimbing 
				  ON mata_kuliah_spesial.IdMKS = dosen_pembimbing.IDMKS 
				  WHERE NIPdosenpembimbing = CONVERT($log_id, char(20))";
		$result = mysqli_query($conn, $query);
		while($mks = mysqli_fetch_assoc($result))
		{

			$post['sebagai'][$i] = "pembimbing";
			$npm = $mks["NPM"];
			$query = "SELECT * FROM mahasiswa WHERE NPM = $npm";
			$res = mysqli_query($conn, $query);
			$mahasiswa = mysqli_fetch_assoc($res);
			$post['mahasiswa'][$i]    	 = $mahasiswa["Nama"];

			$IdJenisMKS = $mks["IdJenisMKS"];
			$query = "SELECT * FROM JENISMKS WHERE ID = $IdJenisMKS";
			$res = mysqli_query($conn, $query);
			$jenis_MKS = mysqli_fetch_assoc($res);
			$post['jenis_sidang'][$i]	 = $jenis_MKS["NamaMKS"];
			
			$post['judul'][$i]   		 = $mks["Judul"];

			$IdMKS = $mks["IdMKS"];
			$query = "SELECT * FROM jadwal_sidang WHERE IdMKS = $IdMKS";
			$res = mysqli_query($conn, $query);
			$jadwal = mysqli_fetch_assoc($res);
			$post['tanggal'][$i]    = $jadwal["Tanggal"];
			$post['jam_mulai'][$i]  = $jadwal["JamMulai"];
			$post['jam_selesai'][$i]= $jadwal["JamSelesai"];
			$IDRuangan= $jadwal["IDRuangan"];
			$query = "SELECT * FROM ruangan WHERE IDRuangan = $IDRuangan";
			$res = mysqli_query($conn, $query);
			$ruangan = mysqli_fetch_assoc($res);
			$post["lokasi"] = $ruangan["NamaRuangan"];

			$query = "SELECT * FROM dosen_penguji INNER JOIN dosen ON dosen_penguji.NIPDosenPenguji = dosen.NIP WHERE IdMKS = $IdMKS";
			$res = mysqli_query($conn, $query);
			$j = 0;
			while($orang_lain = mysqli_fetch_assoc($res)){
				$post['orang_lain'][$i][$j] = $orang_lain["Nama"];
				$j++;
			}
			
			if($mks["IjinMajuSidang"] == 0){
				$post["status"][$i] = "Belum Boleh Masuk Sidang, ";
			} else {
				$post["status"][$i] = "Boleh Masuk Sidang, ";
			}
			if($mks["PengumpulanHardCopy"] == 0){
				$post["status"][$i] = $post["status"][$i]."Belum Mengumpulkan Hard Copy";
			} else {
				$post["status"][$i] = $post["status"][$i]."Sudah Mengumpulkan Hard Copy";
			}
			$i++;
		}
	}

	if ($_SESSION["user_type"] == "admin"){
		$post = array();
		$post['mahasiswa'] = array();
		$post['jenis_sidang'] = array();
		$post['judul'] = array();
		$post['tanggal'] = array();
		$post['jam_mulai'] = array();
		$post['jam_selesai'] = array();
		$post['lokasi'] = array();
		$post['dosen_pembimbing'] = array(array());
		$post['dosen_penguji'] = array(array());
		$post['status'] = array();

		$query = "SELECT * FROM mata_kuliah_spesial";
		$result = mysqli_query($conn, $query);

		$i = 0;
		while($mks = mysqli_fetch_assoc($result))
		{
			$npm = $mks["NPM"];
			$query = "SELECT * FROM mahasiswa WHERE NPM = $npm";
			$res = mysqli_query($conn, $query);
			$mahasiswa = mysqli_fetch_assoc($res);
			$post['mahasiswa'][$i]    	 = $mahasiswa["Nama"];

			$IdJenisMKS = $mks["IdJenisMKS"];
			$query = "SELECT * FROM JENISMKS WHERE ID = $IdJenisMKS";
			$res = mysqli_query($conn, $query);
			$jenis_MKS = mysqli_fetch_assoc($res);
			$post['jenis_sidang'][$i]	 = $jenis_MKS["NamaMKS"];
			
			$post['judul'][$i]   		 = $mks["Judul"];

			$IdMKS = $mks["IdMKS"];
			$query = "SELECT * FROM jadwal_sidang WHERE IdMKS = $IdMKS";
			$res = mysqli_query($conn, $query);
			$jadwal = mysqli_fetch_assoc($res);
			$post['tanggal'][$i]    = $jadwal["Tanggal"];
			$post['jam_mulai'][$i]  = $jadwal["JamMulai"];
			$post['jam_selesai'][$i]= $jadwal["JamSelesai"];
			$IDRuangan= $jadwal["IDRuangan"];
			$query = "SELECT * FROM ruangan WHERE IDRuangan = $IDRuangan";
			$res = mysqli_query($conn, $query);
			$ruangan = mysqli_fetch_assoc($res);
			$post["lokasi"][$i] = $ruangan["NamaRuangan"];

			$query = "SELECT * FROM dosen_penguji INNER JOIN dosen ON dosen_penguji.NIPDosenPenguji = dosen.NIP WHERE IdMKS = $IdMKS";
			$res = mysqli_query($conn, $query);
			$j = 0;
			while($orang_lain = mysqli_fetch_assoc($res)){
				$post['dosen_penguji'][$i][$j] = $orang_lain["Nama"];
				$j++;
			}
			$query = "SELECT * FROM dosen_pembimbing INNER JOIN dosen ON dosen_pembimbing.NIPdosenpembimbing = dosen.NIP WHERE IdMKS = $IdMKS";
			$res = mysqli_query($conn, $query);
			$j = 0;
			while($orang_lain = mysqli_fetch_assoc($res)){
				$post['dosen_pembimbing'][$i][$j] = $orang_lain["Nama"];
				$j++;
			}
			
			$i++;
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
			<?php 
				if($_SESSION["user_type"] == "admin"){
					echo "
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
							<tbody>";
							for ($i=0; $i < count($post['mahasiswa']); $i++){
								$mahasiswa = $post['mahasiswa'][$i];
								$jenis_sidang = $post['jenis_sidang'][$i];
								$judul = $post['judul'][$i];
								$tanggal = $post['tanggal'][$i];
								$jam_mulai = $post['jam_mulai'][$i];
								$jam_selesai = $post['jam_selesai'][$i];
								$lokasi = $post['lokasi'][$i];
								$dosen_pembimbing = $post['dosen_pembimbing'][$i];
								$dosen_penguji = $post['dosen_penguji'][$i];
								echo "
								<tr>
									<td>$mahasiswa</td>
						    		<td>$jenis_sidang</td>
						    		<td>$judul</td>
						    		<td>$tanggal, $jam_mulai - $jam_selesai, Ruangan $lokasi</td>
						    		<td>";
						    		for ($j=0; $j < count($dosen_pembimbing); $j++) { 
						    			echo $dosen_pembimbing[$j].", ";
						    		}
						    		echo
						    		"</td><td>";
						    		for ($j=0; $j < count($dosen_penguji); $j++) { 
						    			echo $dosen_penguji[$j].", ";
						    		}
						    		echo
						    		"</td>
						    		<td>Edit</td>
								</tr>";
							}
								
							echo "
							</tbody>
						</table>
					</div>";
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
					echo "
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
									<th>Pembimbing Lain</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>";
							for ($i=0; $i < count($post['mahasiswa']); $i++){
								$sebagai = $post['sebagai'][$i];
								$mahasiswa = $post['mahasiswa'][$i];
								$jenis_sidang = $post['jenis_sidang'][$i];
								$judul = $post['judul'][$i];
								$tanggal = $post['tanggal'][$i];
								$jam_mulai = $post['jam_mulai'][$i];
								$jam_selesai = $post['jam_selesai'][$i];
								$lokasi = $post['lokasi'][$i];
								$orang_lain = $post['orang_lain'][$i];
								$status = $post['status'][$i];
								echo "
								<tr>
									<td>$mahasiswa      
									Sebagai : $sebagai </td>
						    		<td>$jenis_sidang</td>
						    		<td>$judul</td>
						    		<td>$tanggal, $jam_mulai - $jam_selesai, Ruangan $lokasi</td>
						    		<td>";
						    		for ($j=0; $j < count($orang_lain); $j++) { 
						    			echo $orang_lain[$j].", ";
						    		}
						    		echo
						    		"</td>
								    <td>$status</td>
								</tr>";
							}
								
							echo "
							</tbody>
						</table>
					</div>";
				}
			?>
		</div>
		


		
		<footer>
			
		</footer>
		<script type="text/javascript" src=""></script>

	</body>
</html>


<?php
    session_start();

    if(!isset($_SESSION["log_id"])){
	  	header('Location: login.php');
	}

    include "connection.php";
    
	global $db;

	$user_type = $_SESSION["user_type"];
	$username = $_SESSION["activeuser"];
	$log_id = $_SESSION["log_id"];

	if ($_SESSION["user_type"] == "mahasiswa") {
		$query = "SELECT * FROM mahasiswa WHERE npm = '$log_id'";
		$result = pg_query($db, $query);
		$mahasiswa = pg_fetch_assoc($result);
	}
	if ($_SESSION["user_type"] == "dosen"){
		$query = "SELECT * FROM mata_kuliah_spesial 
				  INNER JOIN dosen_penguji 
				  ON mata_kuliah_spesial.idmks = dosen_penguji.idmks
				  WHERE NIPdosenpenguji = '$log_id'";
		$result = pg_query($db, $query);
		$mksuji = pg_fetch_assoc($result);
		
		$query = "SELECT tanggal 
				FROM jadwal_sidang INNER JOIN mata_kuliah_spesial 
					ON jadwal_sidang.idmks = mata_kuliah_spesial.idmks
				WHERE Extract(month FROM tanggal) = Extract(month FROM CURRENT_DATE) 
				AND Extract(year FROM tanggal) = Extract(year FROM CURRENT_DATE)
				AND mata_kuliah_spesial.idmks IN (
					SELECT dosen_penguji.idmks 
					FROM dosen_penguji INNER JOIN mata_kuliah_spesial
						ON dosen_penguji.idmks = mata_kuliah_spesial.idmks
					WHERE dosen_penguji.nipdosenpenguji = '$log_id')";
		$result = pg_query($db, $query);
		$dates = pg_fetch_assoc($result);
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
		$result = pg_query($db, $query);

		$i = 0;
		while($mks = pg_fetch_assoc($result))
		{
			$npm = $mks["npm"];
			$query = "SELECT * FROM mahasiswa WHERE npm = '$npm'";
			$res = pg_query($db, $query);
			$mahasiswa = pg_fetch_assoc($res);
			$post['mahasiswa'][$i]    	 = $mahasiswa["nama"];

			$idjenismks = $mks["idjenismks"];
			$query = "SELECT * FROM JENISMKS WHERE ID = $idjenismks";
			$res = pg_query($db, $query);
			$jenis_MKS = pg_fetch_assoc($res);
			$post['jenis_sidang'][$i]	 = $jenis_MKS["namamks"];
			
			$post['judul'][$i]   		 = $mks["judul"];

			$idmks = $mks["idmks"];
			$query = "SELECT * FROM jadwal_sidang WHERE idmks = $idmks";
			$res = pg_query($db, $query);
			$jadwal = pg_fetch_assoc($res);
			$post['tanggal'][$i]    = $jadwal["tanggal"];
			$post['jam_mulai'][$i]  = $jadwal["jammulai"];
			$post['jam_selesai'][$i]= $jadwal["jamselesai"];
			$idruangan= $jadwal["idruangan"];
			if($idruangan != NULL)
			{
				$query = "SELECT * FROM ruangan WHERE idruangan IS NOT NULL and idruangan = $idruangan";
				$res = pg_query($db, $query);
				$ruangan = pg_fetch_assoc($res);
				$post["lokasi"][$i] = $ruangan["namaruangan"];
			}else{
				$ruangan = "-";
				$post["lokasi"][$i] = "-";
			}
			
			$query = "SELECT * FROM dosen_penguji INNER JOIN dosen ON dosen_penguji.nipDosenPenguji = dosen.nip WHERE idmks = $idmks";
			$res = pg_query($db, $query);
			$j = 0;
			while($orang_lain = pg_fetch_assoc($res)){
				$post['dosen_penguji'][$i][$j] = $orang_lain["nama"];
				$j++;
			}
			$query = "SELECT * FROM dosen_pembimbing INNER JOIN dosen ON dosen_pembimbing.nipdosenpembimbing = dosen.nip WHERE idmks = $idmks";
			$res = pg_query($db, $query);
			$j = 0;
			while($orang_lain = pg_fetch_assoc($res)){
				$post['dosen_pembimbing'][$i][$j] = $orang_lain["nama"];
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
		<link href="../css/calendar.css" type="text/css" rel="stylesheet" />
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
				$npm = $mahasiswa["npm"];
				$nama = $mahasiswa["nama"];
				$email = $mahasiswa["email"];
				$email_alt = $mahasiswa["email_alternatif"];
				$telepon = $mahasiswa["telepon"];
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
			if($_SESSION["user_type"] == "dosen"){
				include 'calendar.php';
 
				$calendar = new Calendar();
				 
				echo $calendar->show();
			}
			if($_SESSION["user_type"] == "admin"){
				echo "
				<div class='biodata container'>
					<div class='row'>
						<table class='table table-striped'>
							<thead>
					  			<tr>
									<th>Jenis Sidang</th>
									<th>Mahasiswa</th>
									<th>Dosen Pembimbing</th>
									<th>Dosen Penguji</th>
									<th>Waktu dan Lokasi</th>
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
								if($tanggal != NULL){
									echo "
									<tr>
										<td>$jenis_sidang</td>
										<td>$mahasiswa</td>";
										echo "<td>";
										for ($j=0; $j < count($dosen_pembimbing); $j++) { 
											echo $dosen_pembimbing[$j].", ";
										}
										echo "</td><td>";
										for ($j=0; $j < count($dosen_penguji); $j++) { 
											echo $dosen_penguji[$j].", ";
										}
										echo
										"</td>
										<td>$tanggal, $jam_mulai - $jam_selesai, Ruangan $lokasi</td>
										<td>Edit</td>
									</tr>";
								}
							}
								
							echo "
							</tbody>
						</table>
					</div>
				</div>";
			}
		?>

		

		
		<footer>
			
		</footer>
		<script type="text/javascript" src="../js/jquery-3.1.1.js"></script>

	</body>
</html>


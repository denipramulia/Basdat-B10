<?php
    session_start();

    include "connection.php";
    
	global $db;

	if(!isset($_SESSION["log_id"])){
	  	header('Location: login.php');
	}

	$user_type = $_SESSION["user_type"];
	$username = $_SESSION["activeuser"];
	$log_id = $_SESSION["log_id"];
	if ($_SESSION["user_type"] == "mahasiswa") {
		$query = "SELECT * FROM mata_kuliah_spesial WHERE npm = '$log_id'";
		$result = pg_query($db, $query);
		$mks = pg_fetch_assoc($result);
		$idmks = $mks['idmks']; 

		$query = "SELECT * FROM jadwal_sidang WHERE idmks = '$idmks'";
		$result = pg_query($db, $query);
		$jadwal = pg_fetch_assoc($result);

		$query = "SELECT * FROM dosen INNER JOIN dosen_pembimbing ON dosen.nip = dosen_pembimbing.nipdosenpembimbing WHERE IDMKS = $idmks";
		$result = pg_query($db, $query);
		$pembimbing = pg_fetch_assoc($result);

		$query = "SELECT * FROM dosen INNER JOIN dosen_penguji ON dosen.nip = dosen_penguji.nipdosenpenguji WHERE IDMKS = $idmks";
		$result = pg_query($db, $query);
		$penguji = pg_fetch_assoc($result);
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
		
		$query = "SELECT * FROM dosen WHERE nip='$log_id'";
		$result = pg_query($db, $query);
		$dosen = pg_fetch_assoc($result);
		$nama_dosen = $dosen["nama"];
		
		$query = "SELECT * FROM mata_kuliah_spesial 
				  INNER JOIN dosen_penguji 
				  ON mata_kuliah_spesial.idmks = dosen_penguji.IDMKS 
				  WHERE nipdosenpenguji = '$log_id'";
		$result = pg_query($db, $query);

		$i = 0;
		while($mks = pg_fetch_assoc($result))
		{
			$post['sebagai'][$i] = "penguji";
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
				$post['orang_lain'][$i][$j] = $orang_lain["nama"];
				$j++;
			}
			
			if($mks["ijinmajusidang"] == 0){
				$post["status"][$i] = "Belum Boleh Masuk Sidang, ";
			} else {
				$post["status"][$i] = "Boleh Masuk Sidang, ";
			}
			if($mks["pengumpulanhardcopy"] == 0){
				$post["status"][$i] = $post["status"][$i]."Belum Mengumpulkan Hard Copy";
			} else {
				$post["status"][$i] = $post["status"][$i]."Sudah Mengumpulkan Hard Copy";
			}
			$i++;
		}

		$query = "SELECT * FROM mata_kuliah_spesial 
				  INNER JOIN dosen_pembimbing 
				  ON mata_kuliah_spesial.idmks = dosen_pembimbing.IDMKS 
				  WHERE nipdosenpembimbing = '$log_id'";
		$result = pg_query($db, $query);
		while($mks = pg_fetch_assoc($result))
		{

			$post['sebagai'][$i] = "pembimbing";
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
				$post['orang_lain'][$i][$j] = $orang_lain["nama"];
				$j++;
			}
			
			if($mks["ijinmajusidang"] == 0){
				$post["status"][$i] = "Belum Boleh Masuk Sidang, ";
			} else {
				$post["status"][$i] = "Boleh Masuk Sidang, ";
			}
			if($mks["pengumpulanhardcopy"] == 0){
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
	</head>

	<body style="overflow-x:hidden">
		<nav class="navbar navbar-inverse">
		  <div class="container-fluid">
		    <div class="navbar-header">
		      <a class="navbar-brand" href="#">SISIDANG</a>
		    </div>
		    <ul class="nav navbar-nav">
		    <?php
		      echo '<li><a href="home.php">Home</a></li>';
		      echo '<li><a href="#">Tambah Peserta MKS</a></li>';
		      if($_SESSION['user_type'] == "admin"){
		      	echo '<li><a href="#">Buat Jadwal Sidang MKS</a></li>';
		      } 
		      if($_SESSION['user_type'] == "admin" || $_SESSION['user_type'] == "dosen" ){
		      echo '<li><a href="createMKS.php">Buat Jadwal Non-Sidang Dosen</a></li>';
		  	  }
		      echo '<li class="active"><a href="#">Lihat Jadwal Sidang</a></li>';
		      echo '<li><a href="listMKS.php">Lihat Daftar MKS</a></li>'; 
		      echo '<li><a href="logout.php">Logout</a></li>;' 
		    ?>
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
								if($tanggal != NULL){
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
							}
								
							echo "
							</tbody>
						</table>
					</div>";
				}
				if($_SESSION["user_type"] == "mahasiswa"){
					if($mks['ijinmajusidang'] == TRUE) {
				   		$ijin = "Diizinkan maju sidang, ";
				   	}
				   	else{
				   		$ijin = "Belum diizinkan maju sidang, ";
				   	}
				   	if($mks["pengumpulanhardcopy"] == TRUE) {
				   		$kumpul = "Hardcopy telah dikumpulkan";
				   	}
				   	else{
				   		$kumpul = "Hardcopy belum dikumpulkan";
				   	}
				   	$judul = $mks['judul'];
				   	$tanggal = $jadwal['tanggal'];
				   	$JamMulai = $jadwal['jammulai'];
				   	$pembimbing = $pembimbing['nama'];
				   	$penguji = $penguji['nama'];
					echo "
					<div class='row'>
					<table class='table table-reflow' id='tabel-jadwal'>
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
							<button id='btn-mhs' type='button' class='btn btn-default'>Mahasiswa</button>
							<button id='btn-jns' type='button' class='btn btn-default'>Jenis Sidang</button>
							<button id='btn-wkt' type='button' class='btn btn-default'>Waktu</button>
						</div>
					</div>
					<br>
					<div class='row'>
						<table id='tabel-jadwal' class='table table-striped'>
							<thead>
					  			<tr>
									<th>Mahasiswa</th>
									<th>Jenis Sidang</th> 
									<th>Judul</th>
									<th>Waktu dan Lokasi</th>
									<th>Dosen Lain</th>
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
								if($tanggal != NULL)
								{	
									echo "
									<tr>
										<td>$mahasiswa      
										Sebagai : $sebagai </td>
										<td>$jenis_sidang</td>
										<td>$judul</td>
										<td>$tanggal, $jam_mulai - $jam_selesai, Ruangan $lokasi</td>
										<td>";
										for ($j=0; $j < count($orang_lain); $j++) { 
											if($orang_lain[$j] != $nama_dosen)
											echo $orang_lain[$j].", ";
										}
										echo
										"</td>
										<td>$status</td>
									</tr>";
								}
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
		<script type="text/javascript" src="../js/jquery-3.1.1.js"></script>
		<script>

		</script>
		<script type="text/javascript" src="../js/jadwal.js"></script>
	</body>
</html>


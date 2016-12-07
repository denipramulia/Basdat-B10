<?php
	
	session_start();

	include "connection.php";

		global $db;
/*
	if(isset($_POST['Simpan'])){
		pg_query($db, "INSERT INTO Jadwal_Sidang (IDJadwal, IdMKS, Tanggal, JamMulai, JamSelesai, IDRuangan) VALUES (SELECT count(*) AS exact_count FROM Jadwal_Sidang;, '1', $_POST['Tanggal'], $_POST['Mulai'], $_POST['Selesai'], $_POST['Ruang'])" );
	}
	header('Location: home.php');

*/
	if(isset($_POST['Batal'])){
		header('Location: login.php');
	}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Tambah Jadwal</title>
		<meta name="keywords" content="SiSidang,Basdat,Please Give Us an A">
		<meta name="description" content="">
		<link rel="icon" href="http://barbaraambach.com/favicon.ico">
		<link href="bootstrap.min.css" rel="stylesheet" type="text/css"/>
	</head>
	<body>
	<div class="header">
	<h3>Tambah Jadwal Sidang MKS</h3>
	<br>
	<button type="submit" name="Simpan" class="btn btn-default">Simpan</button>
	<button type="submit" name="Batal" class="btn btn-default">Batal</button>
	<br>
	<br>
	<div class="form-group">
  		<label for="sel1">Mahasiswa:</label>
  		<select class="form-control" name="Mhs" id="sel1">
  		<?php
  		$query = pg_query($db, "select nama from Mahasiswa");
  		
		foreach (pg_fetch_array($query) as $row) {
   		echo '<option value="'.$row.'">'.$row.'</option>';
		}
  		?>
  </select>
</div>
	<br>
<form action='' method='POST'>
    <div class="form-group">
      <label for="Tanggal">Tanggal:</label>
      <input type="date" class="form-control" id="Tanggal" name='Tanggal'>
    </div>
    <div class="form-group">
      <label for="Mulai">Jam Mulai:</label>
      <input type="time" class="form-control" id="Mulai" name='Mulai'>
      </div>
     <div class="form-group">
      <label for="Selesai">Jam Selesai:</label>
      <input type="time" class="form-control" id="Selesai" name='Selesai'>
      </div>
</form> 
	<br>
	<div class="form-group">
  		<label for="sel1">Ruangan:</label>
  		<select class="form-control" name="Ruang" id="sel1">
  		<?php
  		$query = pg_query($db, "select NamaRuangan from Ruangan");
  		
		foreach (pg_fetch_array($query) as $row) {
   		echo '<option value="'.$row.'">'.$row.'</option>';
		}
  		?>
  </select>
</div>
	<br>
	<div class="form-group">
  		<label for="sel1">Penguji 1:</label>
  		<select class="form-control" name="Pen1" id="sel1">
  		<?php
  		$query = pg_query($db, "select nama from Dosen");
  		
		foreach (pg_fetch_array($query) as $row) {
   		echo '<option value="'.$row.'">'.$row.'</option>';
		}
  		?>
  </select>
</div>
	<br>
	<div class="form-group">
  		<label for="sel1">Penguji 2:</label>
  		<select class="form-control" name="Pen2" id="sel1">
  		<?php
  		$query = pg_query($db, "select nama from Dosen");
  		
		foreach (pg_fetch_array($query) as $row) {
   		echo '<option value="'.$row.'">'.$row.'</option>';
		}
  		?>
  </select>
</div>
    <br>
    <br>
    <label>Pengumpulan HardCopy</label>
	<form action="">
		<input type="radio" name="gender" value="Sudah"> Sudah
	</form>
	<br>
	<button type="button" class="btn btn-primary">+ Tambah Penguji</button>
	</div>
</html>

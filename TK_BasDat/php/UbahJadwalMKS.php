<?php
/*
 $db = pg_connect('host=localhost port=5432 dbname=postgres user=postgres');
 if(!$db) {
 	echo "Error : unable to open database \n";
 	die();
 }

$dom = new DOMDocument();
$dom->loadHTML($html);

$xpath = new DOMXPath($dom);

$tags = $xpath->query('//input[@name="id"]');
foreach ($tags as $tag) {
    var_dump(trim($tag->getAttribute('value')));
}
*/
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
	<h3>Ubah Jadwal Sidang MKS</h3>
	<br>
	<button type="button" class="btn btn-primary">Simpan</button>
	<button type="button" class="btn btn-primary">Batal</button>
	<br>
	<br>
	<div class="form-group">
  		<label for="sel1">Mahasiswa:</label>
  		<select class="form-control" id="sel1">
  		<?php
  		/*
  		$query = pg_query(select nama from Mahasiswa);

		foreach (pg_fetch_array($query) as $row) {
   		echo '<option value="'.$row.'">'.$row.'</option>';
		}*/
  		?>
  </select>
</div>
	<br>
<form>
    <div class="form-group">
      <label for="Tanggal">Tanggal:</label>
      <input type="text" class="form-control" id="Tanggal" placeholder="HH/BB/TTTT">
    </div>
    <div class="form-group">
      <label for="Mulai">Jam Mulai:</label>
      <input type="text" class="form-control" id="Mulai" placeholder="JJ:MM">
      </div>
     <div class="form-group">
      <label for="Selesai">Jam Selesai:</label>
      <input type="text" class="form-control" id="Selesai" placeholder="JJ:MM">
      </div>
</form> 
	<br>
	<label>Ruangan:</label>
	<button class="btn btn-default dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">Ruangan
    <span class="caret"></span></button>
    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
      <li role="presentation"><a role="menuitem" tabindex="-1" href="#">HTML</a></li>
      <li role="presentation"><a role="menuitem" tabindex="-1" href="#">CSS</a></li>
      <li role="presentation"><a role="menuitem" tabindex="-1" href="#">JavaScript</a></li>
    </ul>
	<br>
	<label>Penguji 1:</label>
	<button class="btn btn-default dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">Penguji 1
    <span class="caret"></span></button>
    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
      <li role="presentation"><a role="menuitem" tabindex="-1" href="#">HTML</a></li>
      <li role="presentation"><a role="menuitem" tabindex="-1" href="#">CSS</a></li>
      <li role="presentation"><a role="menuitem" tabindex="-1" href="#">JavaScript</a></li>
    </ul>
	<br>
	<label>Penguji 2:</label>
	<button class="btn btn-default dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">Penguji 2
    <span class="caret"></span></button>
    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
      <li role="presentation"><a role="menuitem" tabindex="-1" href="#">HTML</a></li>
      <li role="presentation"><a role="menuitem" tabindex="-1" href="#">CSS</a></li>
      <li role="presentation"><a role="menuitem" tabindex="-1" href="#">JavaScript</a></li>
    </ul>
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

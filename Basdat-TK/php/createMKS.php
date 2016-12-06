<?php
  session_start();
  $user = '';
  if (!isset($_SESSION['user_type']) && $_SESSION['user_type'] != "admin") {
      header('Location: login.php');
  } else {
      $nav = '';
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create MKS</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="../js/jquery.min.js" type="text/javascript"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/generator.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
<header>
    <body>
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
		      	echo '<li class="active"><a href="#">Buat Jadwal Sidang MKS</a></li>';
		      } 
		      if($_SESSION['user_type'] == "admin" || $_SESSION['user_type'] == "dosen" ){
		      echo '<li><a href="createMKS.php">Buat Jadwal Non-Sidang Dosen</a></li>';
		  	  }
		      echo '<li><a href="#">Lihat Jadwal Sidang</a></li>';
		      echo '<li><a href="listMKS.php">Lihat Daftar MKS</a></li>'; 
		      echo '<li><a href="logout.php">Logout</a></li>;' 
		    ?>
		    </ul>
		  </div>
		</nav>
</header>
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="panel">
                        <div class="panel-heading">
                            <h2> Buat Mata Kuliah Spesial </h2>
                        </div>
                        <div class="panel-body">

                            <form method="post" id="form-mks">
                                <table class="table">
                                    <tbody>
                                        <tr><td colspan="2"><h2> Informasi MKS </h2></td></tr>
                                        <tr>
                                            <td> Term </td>
                                            <td>
                                                <div class="form-group">
                                                    <select class="form-control" id="term" name="term"></select>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> Mahasiswa </td>
                                            <td>
                                                <div class="form-group">
                                                    <select class="form-control" id="mahasiswa" name="mahasiswa">
                                        </div>
                                 </td>
                               </tr>
                               <tr>
                                   <td> Jenis MKS </td>
                                   <td>
                                       <div class="form-group">
                                         <select class="form-control" id="jenismks" name="jenismks">
                                        </div>
                                 </td>
                               </tr>
                               <tr>
                                   <td> Judul MKS </td>
                                   <td>
                                       <div class="form-group">
                                         <input type="text" class="form-control" id="judulmks"/>
                                        </div>
                                 </td>
                               </tr>
                               <tr><td colspan="2"><h2> Pembimbing </h2></td></tr>
                               <tr>
                                   <td> Pembimbing 1 </td>
                                   <td>
                                       <div class="form-group">
                                           <select class="form-control pembimbing" id="pembimbing1" name="pembimbing1">
                                                <option value='0'>Pilih Dosen</option>
                                           </select>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> Pembimbing 2 </td>
                                            <td>
                                                <div class="form-group">
                                                    <select class="form-control pembimbing" id="pembimbing2" name="pembimbing2">
                                                <option value='0'>Pilih Dosen</option>
                                           </select>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> Pembimbing 3 </td>
                                            <td>
                                                <div class="form-group">
                                                    <select class="form-control pembimbing" id="pembimbing3" name="pembimbing3">
                                                <option value='0'>Pilih Dosen</option>
                                           </select>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr><td colspan="2"><h2> Penguji <span id="tambah-penguji" class="btn btn-primary"> Tambah penguji </span> <span id="remove-penguji" class="btn btn-danger"> Kurangi penguji </span> </h2></td></tr>
                                        <tr>
                                            <td> Penguji </td>
                                            <td>
                                                <div id="penguji-wrapper">
                                                    <div class="form-group ">
                                                        <select class="form-control penguji" id="penguji" name="penguji">
                                                   <option value="0">Pilih Dosen</option>
                                               </select>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button href="home.php" id="btnCreate" type="button" class="btn btn-primary"> Buat </button>
                                <a href="listMKS.php" type="button" class="btn btn-primary"> Cancel </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="../js/mkscreate.js" type="text/javascript"></script>
    </body>
    </html

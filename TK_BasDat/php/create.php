<?php
  session_start();
  $user = '';
  if (!isset($_SESSION['loggedRole']) && $_SESSION['loggedRole'] != "admin") {
      header('Location: ../Login/index.php');
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
    <script src="../../libs/js/jquery.min.js" type="text/javascript"></script>
    <script src="../../libs/js/bootstrap.min.js"></script>
    <script src="../../src/js/generator.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../../libs/css/reset.css">
    <link rel="stylesheet" href="../../libs/css/bootstrap.min.css">
<header>
    <body>
<nav class="navbar navbar-inverse">
        <div class="container">
          <a class="navbar-brand" href="../HalamanUtama/admin.php"> Sisidang </a>
          <ul class="nav navbar-nav">
            <li class="nav-item">
              <li class="dropdown">
                <a href="#" data-toggle="dropdown"> Mata Kuliah Spesial <span class="arrow">&#9660;  </span></a>
                <ul class="dropdown-menu">
                  <li><a href="../mks/index.php"> Lihat Daftar </a></li>
                  <li><a href="../mks/create.php"> Tambah MKS </a></li>
                </ul>
              </li> <!--dropdown-->
            </li> <!--nav-item-->
            <li class="nav-item">
              <li class="dropdown">
              <a href="#" data-toggle="dropdown">Jadwal Sidang <span class="arrow">&#9660;  </span></a>
              <ul class="dropdown-menu">
                <li><a href="../LihatJadwalSidang/jadwalAdmin.php">Lihat Daftar</a></li>
                <li><a href="../JadwalSidang/create.php">Buat</a></li>
              </ul>
              </li> <!--dropdown-->
            </li> <!--nav-item-->
            <li class="nav-item">
             <li class="dropdown">
                <a href="#" data-toggle="dropdown"> Jadwal Non Sidang <span class="arrow">&#9660;  </span></a>
                <ul class="dropdown-menu">
                  <li><a href="../JadwalNonSidang/lihatNonSidang.php"> Tambah Jadwal Non Sidang </a></li>
                  <li><a href="../JadwalNonSidang/daftarNonSidang.php"> Daftar Jadwal Non Sidang </a></li>
                </ul>
              </li> <!--dropdown-->
            </li><!--nav-item-->
            <li class="nav-item">
              <li><a href="../IzinMajuSidang/admin.php">Izin Jadwal Sidang</a></li>
            </li><!--nav-item-->
            <li class="nav-item">
              <li><a href="../Logout/logout.php">Logout</a></li>
            </li><!--nav-item-->
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
                                <button href="../HalamanUtama/admin.php" id="btnCreate" type="button" class="btn btn-primary"> Buat </button>
                                <a href="../HalamanUtama/admin.php" type="button" class="btn btn-primary"> Cancel </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="../../src/js/mkscreate.js" type="text/javascript"></script>
    </body>
    </html

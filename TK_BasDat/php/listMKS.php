<?php
  session_start();
  $user = '';
  if (!isset($_SESSION['loggedRole'])) {
      header('Location: ../Login/index.php');
  } else {
      $nav = '';
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>List MKS</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="../../libs/js/jquery.min.js" type="text/javascript"></script>
    <script src="../../libs/js/bootstrap.min.js"></script>
    <script src="../../src/js/generator.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../../libs/css/reset.css">
    <link rel="stylesheet" href="../../libs/css/bootstrap.min.css" />
</head>
<body>
<header>
<?php
    if ($_SESSION['loggedRole'] == 'admin') {
        echo '<nav class="navbar navbar-inverse">
        <div class="container">
          <a class="navbar-brand" href="../HalamanUtama/admin.php"> Sisidang </a>
          <ul class="nav navbar-nav">
            <li class="nav-item">
              <li class="dropdown">
                <a href="#" data-toggle="dropdown"> Mata Kuliah Spesial <span class="arrow">&#9660;  </span></a>
                <ul class="dropdown-menu">
                  <li><a href="../mks/listMKS.php"> Lihat Daftar </a></li>
                  <li><a href="../mks/createMKS.php"> Tambah MKS </a></li>
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
      </nav>';
    } else {
        echo '<nav class="navbar navbar-inverse">
        <div class="container">
          <a class="navbar-brand" href="../HalamanUtama/dosen.php"> Sisidang </a>
          <ul class="nav navbar-nav">
            <li class="nav-item">
              <li><a href="../mks/index.php" > Mata Kuliah Spesial</a></li>
            </li> <!--nav-item-->
            <li class="nav-item">
              <li><a href="../LihatJadwalSidang/jadwalDosen.php" >Jadwal Sidang </a></li>
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
      </nav>';
    }
?>

</header>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h2> Mata Kuliah Spesial </h2>
                            <?php
                                if ($_SESSION['loggedRole'] == 'admin') {
                                    echo '<a class="btn btn-primary" href="createMKS.php"> Tambah MKS </a>';
                                }
                            ?>
                            <div class="sort">
                                <h4> Sort By </h4>
                                <select id="sort" class="form-control" name="showperpage">
                                    <option value="mahasiswa"> Nama Mahasiswa </option>
                                    <option value="term"> Term </option>
                                    <option value="jenismks"> Jenis MKS </option>
                                </select>
                            </div>
                        </div>
                        <div class="pull-right">
                            <div class="input-group">
                                <h4> Show </h4>
                                <select id="showperpage" class="form-control" name="showperpage">
                                    <option value="10"> 10 </option>
                                    <option value="20"> 20 </option>
                                    <option value="50"> 50 </option>
                                </select>
                            </div>
                            <div class="input-group">
                                <h4> Term </h4>
                                <select id="selectTerm" class="form-control" name="selectTerm">
                                </select>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="panel-body">
                        <table id="mkstable" class="table table-inverse">
                            <thead>
                                <tr>
                                    <th> ID </th>
                                    <th colspan="1"> Judul </th>
                                    <th> Mahasiswa </th>
                                    <th> Term </th>
                                    <th> Jenis MKS </th>
                                    <th> STATUS </th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <div class="text-center">
                            <div class="pagination">
                                <span> Page </span>
                                <select style="display:inline-block;width:auto" id="pagination" class="form-control">
                          </select>
                                <span id="pageNum"></span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="../../src/js/mksindex.js" type="text/javascript"></script>
</body>
</html>

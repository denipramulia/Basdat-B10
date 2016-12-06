<?php
  session_start();
  $user = '';
  if (!isset($_SESSION['user_type'])) {
      header('Location: login.php');
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
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
</head>
<body>
<header>
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="#">SISIDANG</a>
        </div>
        <ul class="nav navbar-nav">
        <?php
          echo '<li><a href="home.php">Home</a></li>';
          echo '<li><a href="#">Tambah Peserta MKS</a></li>';
          if(!_SESSION['user_type'] == "admin"){
            echo '<li><a href="#">Buat Jadwal Sidang MKS</a></li>';
          } 
          if(!_SESSION['user_type'] == "admin" || !_SESSION['user_type'] == "dosen" ){
          echo '<li><a href="#">Buat Jadwal Non-Sidang Dosen</a></li>';
          }
          echo '<li class="active"><a href="#">Lihat Jadwal Sidang</a></li>';
          echo '<li><a href="#">Lihat Daftar MKS</a></li>'; 
          echo '<li><a href="logout.php">Logout</a></li>;' 
        ?>
        </ul>
      </div>
    </nav>
</header>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h2> Mata Kuliah Spesial </h2>
                            <?php
                                if ($_SESSION['user_type'] == 'admin') {
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
<?php
    session_start();
    include '../php/connection.php';
    include '../controller/MahasiswaHandler.php';
    include '../controller/DosenHandler.php';
    include '../controller/MKSHandler.php';
    include '../controller/JenisMKSHandler.php';
    include '../controller/TermHandler.php';
    include '../controller/RuanganHandler.php';
    include '../controller/TimelineHandler.php';
    include '../controller/JadwalSidangHandler.php';
	
	global $db;
	
    header('Content-Type: application/json');
    $response = [
        'status' => 'success',
        'data' => "none",
        'message' => ''
    ]; // default response

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'GET_MAHASISWA':
                $mahasiswaList = MahasiswaHandler::getAllMahasiswa($db);
                $data = pg_fetch_all($mahasiswaList);
                $response['data'] = $data;
                break;

            case 'GET_TERM':
                $termList = TermHandler::getAllTerm($db);
                $data = pg_fetch_all($termList);
                $response['data'] = $data;
                break;

            case 'GET_DOSEN':
                $dosenList = DosenHandler::getAllDosen($db);
                $data = pg_fetch_all($dosenList);
                $response['data'] = $data;
                break;

            case 'GET_JENIS_MKS':
                $jenisMKSList = JenisMKSHandler::getAllJenisMKS($db);
                $data = pg_fetch_all($jenisMKSList);
                $response['data'] = $data;
                break;

            case 'GET_MKS':
                $skip = $_GET['skip'];
                $take = $_GET['take'];
                $sort = $_GET['sort'];
                $result = MKSHandler::getMKSwith($db, $skip, $take, $sort);
                $response['data'] = $result;
                break;

            case 'GET_MKS_WITH_TERM' :
                $skip = $_GET['skip'];
                $take = $_GET['take'];
                $sort = $_GET['sort'];
                $term = $_GET['term'];
                $role = $_SESSION['user_type'];
                $result;
                if ($role == "admin") {
                    $result = MKSHandler::getMKSwithTerm($db, $skip, $take, $sort, $term);
                } else if ($role == "dosen") {
                    $nip = $_SESSION['log_id'];
                    $result = MKSHandler::getMKSWithDosen($db, $skip, $take, $sort, $term, $nip);
                }
                $response['data'] = $result;
                break;

            case 'GET_MKS_IZIN_MAJU_SIDANG' :
                $result = MKSHandler::getMKSWithSiapSidang($db);
                $response['data'] = $result;
                break;

            case 'GET_MAHASISWA_WITHOUT_MKS_TERM' :
                $term = $_GET['term'];
                $result = MahasiswaHandler::getMahasiswaWithoutMKS($db, $term);
                $response['data'] = $result;
                break;

            case 'GET_RUANGAN':
                $ruanganList = RuanganHandler::getAllRuangan($db);
                $data = pg_fetch_all($ruanganList);
                $response['data'] = $data;
                break;

            case 'GET_TIMELINE':
                $timelineList = TimelineHandler::getAllTimeline($db);
                $data = pg_fetch_all($timelineList);
                $data['events'] = $data;
                $response['data'] = $data;
                break;
            case 'GET_JADWAL_SIDANG':
                $jadwalsidangList = JadwalSidangHandler::getAllJadwalSidang($db);
                $data = pg_fetch_all($jadwalsidangList);
                $data['event'] = $data;
                $response['data'] = $data;
                break;
            default:
                break;
        }
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'CREATE_MKS':
                $idmks = $_POST['idmks'];
                $term = $_POST['term'];
                $npm = $_POST['npm'];
                $type = $_POST['type'];
                $title = $_POST['title'];
                $adviserList = $_POST['adviserlist'];
                $examinerList = $_POST['examinerlist'];
                $result = MKSHandler::create($db, $idmks, $term, $npm, $type, $title);
                foreach ($adviserList as $adviser) {
                    DosenHandler::addPembimbingMKS($db, $idmks, $adviser);
                }
                foreach ($examinerList as $examiner) {
                    DosenHandler::addPengujiMKS($db, $idmks, $examiner);
                }
                $response['data'] = $result;
                break;

            case 'CREATE_JADWAL_SIDANG':
                $idmks = $_POST['idmks'];
                $tanggal = $_POST['tanggal'];
                $jamMulai = $_POST['jamMulai'];
                $jamSelesai = $_POST['jamSelesai'];
                $idruangan = $_POST['ruangan'];
                $pengujiList = $_POST['pengujiList'];
                $result = JadwalSidangHandler::create($db, $idmks, $tanggal, $jamMulai, $jamSelesai, $idruangan, $pengujiList);
                $response['message'] = pg_last_error($db);
                break;

            default :
                $response['status'] = "failed";
                $response['message'] = "wrong action command";
        }
    }
    echo json_encode($response);

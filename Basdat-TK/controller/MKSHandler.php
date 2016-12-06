<?php

  class MKSHandler
  {
      private $conn;
      public function __construct($connection)
      {
          $this->conn = $connection;
      }

      public static function create($db, $idmks, $term, $npm, $type, $title)
      {

          // check mks for current term and semester
          try {
              $insert = 'INSERT INTO sisidang.mata_kuliah_spesial (idmks, npm, tahun, semester, judul, IdJenisMKS) ';
              $values = "VALUES ($idmks, '$npm', '$term[0]', '$term[1]', '$title', '$type')";
              $sql = $insert.$values;
              $create = pg_query($db, $sql);

              return $create;
          } catch (Exception $e) {
              return $e;
          }
      }

      public function getAllMKS($db)
      {
          $query = 'SELECT * FROM sisidang.mata_kuliah_spesial';
          $MKSList = pg_query($this->conn, $query);

          return $MKSList;
      }

      public static function getMKSWith($db, $skip, $take, $sort)
      {
          $query = "SELECT MKS.idmks, MKS.judul, M.nama, MKS.tahun, MKS.semester, J.namamks as jenis, MKS.IsSiapSidang, MKS.PengumpulanHardCopy, MKS.IjinMajuSidang
         FROM SISIDANG.MATA_KULIAH_SPESIAL AS MKS, SISIDANG.MAHASISWA AS M, SISIDANG.JENISMKS AS J
         WHERE MKS.npm = M.npm AND MKS.idjenismks = J.id
         OFFSET $skip LIMIT $take";
          if ($sort != '') {
              $query .= " ORDER BY $sort";
          }
          $MKSList = pg_query($db, $query);
          $query = 'SELECT COUNT(*) FROM sisidang.mata_kuliah_spesial';
          $count = pg_query($db, $query);

          return ['mkslist' => pg_fetch_all($MKSList), 'total' => pg_fetch_row($count)[0] / $take];
      }

      public static function getMKSWithTerm($db, $skip, $take, $sort, $term)
      {
          $query = "SELECT MKS.idmks, MKS.judul, M.nama, MKS.tahun, MKS.semester, J.namamks as jenis, MKS.IsSiapSidang, MKS.PengumpulanHardCopy, MKS.IjinMajuSidang
         FROM SISIDANG.MATA_KULIAH_SPESIAL AS MKS, SISIDANG.MAHASISWA AS M, SISIDANG.JENISMKS AS J
         WHERE MKS.npm = M.npm AND MKS.idjenismks = J.id AND MKS.tahun = $term[0] AND MKS.semester = $term[1]";
         if ($sort != '') {
             $key = 'M.nama';
             if ($sort == 'mahasiswa') {
                 $key = 'M.nama';
             } else if ($sort == 'jenismks') {
                 $key = 'J.namamks';
             } else if ($sort == 'term') {
                 $key = 'MKS.tahun, MKS.semester';
             }
             $query .= " ORDER BY $key";

         } else {
             $query .= ' ORDER BY M.nama';
         }

         $query .= " OFFSET $skip LIMIT $take";
		 $term_var = $term[0];
		 $term_var2 = $term[1];
          $MKSList = pg_query($db, $query);
          $query = "SELECT COUNT(*) FROM SISIDANG.MATA_KULIAH_SPESIAL AS MKS
            WHERE MKS.tahun = $term_var AND MKS.semester = $term_var2
          ";
          $count = pg_query($db, $query);

          return ['mkslist' => pg_fetch_all($MKSList), 'total' => pg_fetch_row($count)[0] / $take];
      }

      public static function getMKSWithDosen($db, $skip, $take, $sort, $term, $nip)
      {
          $query = "SELECT DISTINCT MKS.idmks, MKS.judul, M.nama, MKS.tahun, MKS.semester, J.namamks as jenis, MKS.IsSiapSidang, MKS.PengumpulanHardCopy, MKS.IjinMajuSidang
          FROM SISIDANG.MATA_KULIAH_SPESIAL AS MKS, SISIDANG.MAHASISWA AS M, SISIDANG.JENISMKS AS J, SISIDANG.DOSEN_PEMBIMBING AS DP , SISIDANG.DOSEN_PENGUJI AS SDP
          WHERE DP.nipdosenpembimbing = '$nip' AND MKS.npm = M.npm AND MKS.idjenismks = J.id AND MKS.tahun = $term[0] AND MKS.semester = $term[1] AND DP.idmks = MKS.idmks AND SDP.idmks = MKS.idmks";

          if ($sort != '') {
              $key = 'M.nama';
              if ($sort == 'mahasiswa') {
                  $key = 'M.nama';
              } else if ($sort == 'jenismks') {
                  $key = 'J.namamks';
              } else if ($sort == 'term') {
                  $key = 'MKS.tahun, MKS.semester';
              }
              $query .= " ORDER BY $key";

          } else {
              $query .= ' ORDER BY M.nama';
          }
          $query .= " OFFSET $skip LIMIT $take";
          $MKSList = pg_query($db, $query);
		  $term0 = $term[0];
		  $term1 = $term[1];
          $query = "SELECT DISTINCT count(*)
          FROM SISIDANG.MATA_KULIAH_SPESIAL AS MKS, SISIDANG.MAHASISWA AS M, SISIDANG.JENISMKS AS J, SISIDANG.DOSEN_PEMBIMBING AS DP , SISIDANG.SARAN_DOSEN_PENGUJI AS SDP
          WHERE MKS.npm = M.npm AND MKS.idjenismks = J.id AND MKS.tahun = $term0 AND MKS.semester = $term1 AND DP.idmks = MKS.idmks AND SDP.idmks = MKS.idmks AND DP.nipdosenpembimbing = '$nip' AND SDP.nipdosenpenguji = '$nip'
          OFFSET $skip LIMIT $take";
          $count = pg_query($db, $query);
          return ['mkslist' => pg_fetch_all($MKSList), 'total' => pg_fetch_row($count)[0] / $take];
      }

      public static function getMKSWithSiapSidang($db) {
          $query = "SELECT MKS.idmks, M.nama
          FROM SISIDANG.MATA_KULIAH_SPESIAL AS MKS, SISIDANG.MAHASISWA AS M
          WHERE MKS.npm = M.npm AND MKS.ijinmajusidang = true AND
          NOT EXISTS (SELECT * FROM SISIDANG.JADWAL_SIDANG AS JS WHERE JS.idmks = MKS.idmks)";
          $mksList = pg_query($db, $query);
          return pg_fetch_all($mksList);
      }
  }

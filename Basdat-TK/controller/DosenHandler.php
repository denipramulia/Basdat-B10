<?php

  class DosenHandler
  {
      private $conn;
      public function __construct($connection)
      {
          $this->conn = $connection;
      }

      public static function getAlldosen($db)
      {
          $query = 'SELECT * FROM SISIDANG.DOSEN';
          $dosenList = pg_query($db, $query);

          return $dosenList;
      }

      public static function addPembimbingMKS($db, $idmks, $nip)
      {
          $query = "INSERT INTO SISIDANG.DOSEN_PEMBIMBING (idmks, nipdosenpembimbing) VALUES ($idmks, '$nip')";
          $result = pg_query($db, $query);

          return $result;
      }

      public static function addPengujiMKS($db, $idmks, $nip)
      {
          $query = "INSERT INTO SISIDANG.DOSEN_PENGUJI (idmks, nipdosenpenguji) VALUES ($idmks, '$nip')";
          $result = pg_query($db, $query);

          return $result;
      }
  }

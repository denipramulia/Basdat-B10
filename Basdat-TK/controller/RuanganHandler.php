<?php

  class RuanganHandler
  {
      private $conn;
      public function __construct($connection)
      {
          $this->conn = $connection;
      }

      public function createRuangan($idRuangan, $namaRuangan)
      {
      }

      public static function getAllRuangan($db)
      {
          $query = 'SELECT * FROM SISIDANG.RUANGAN';
          $termList = pg_query($db, $query);

          return $termList;
      }
  }

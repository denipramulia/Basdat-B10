<?php

  class TermHandler
  {
      private $conn;
      public function __construct($connection)
      {
          $this->conn = $connection;
      }

      public function createTerm($tahun, $semester)
      {
      }

      public static function getAllTerm($db)
      {
          $query = 'SELECT * FROM SISIDANG.TERM';
          $termList = pg_query($db, $query);

          return $termList;
      }
  }

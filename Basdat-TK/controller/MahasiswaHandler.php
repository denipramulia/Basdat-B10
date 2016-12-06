<?php

class MahasiswaHandler
{
    private $conn;
    public function __construct($connection)
    {
        $this->conn = $connection;
    }

    public static function getAllMahasiswa($connection)
    {
        $query = 'SELECT * FROM SISIDANG.MAHASISWA';
        $mahasiswaList = pg_query($connection, $query);

        return $mahasiswaList;
    }

    public function getMahasiswa($connection, $npm)
    {
        $query = "SELECT * FROM SISIDANG.MAHASISWA WHERE npm='$npm'";
        $mahasiswa = pg_query($this->conn, $query);

        return $mahasiswa;
    }

    public function getMahasiswaWithStatus($connection, $status)
    {
        $query = "SELECT * FROM SISIDANG.MAHASISWA JOIN SISIDANG.MATA_KULIAH_SPESIAL MKS WHERE MKS.status = $status";
    }

    public function getMahasiswaWithoutMKS($db, $term) {
        $term = $term;
        $query = "SELECT M.npm, M.nama
        FROM SISIDANG.MAHASISWA AS M
        WHERE NOT EXISTS (SELECT *
            FROM SISIDANG.MATA_KULIAH_SPESIAL AS MKS
            WHERE MKS.npm = M.npm AND MKS.tahun = $term[0] AND MKS.semester = $term[1])";
        $result = pg_query($db, $query);
        return pg_fetch_all($result);
    }
}


<?php

//$db = pg_connect('host=dbpg.cs.ui.ac.id port=5432 dbname=b10 user=b10 password=VjX7Nb');
//$set_search_path = 'set search_path to sisidang';
//$set_scheme = pg_query($conn, $set_search_path);
$db_string = 'host=localhost port= 5432 dbname=postgres user=postgres password=denipramulia';
$db = pg_connect($db_string);
$set_search_path = 'set search_path to sisidang';

if (!$db) {
    echo "Error : unable to open database \n";
    die();
}
$set_scheme = pg_query($db, $set_search_path);
?>
<?php
function get_db_connection() {
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $dbname = 'my_guitar_shop1';

    $conn = mysqli_connect($host, $user, $pass, $dbname);

    if (!$conn) {
        die('Database connection failed: ' . mysqli_connect_error());
    }

    mysqli_set_charset($conn, 'utf8');
    return $conn;
}
?>

<?php
// PDO database connection
function get_db() {
    $dsn = 'mysql:host=localhost;dbname=my_guitar_shop1';
    $username = 'root';
    $password = '';
    try {
        $db = new PDO($dsn, $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        echo "<p>An error occurred while connecting to the database: $error_message</p>";
        exit();
    }
}
?>


<?php
// Kết nối database cho Bài 3
function get_db() {
    $dsn = 'mysql:host=localhost;dbname=lab8_email';
    $username = 'root';
    $password = '';
    try {
        $db = new PDO($dsn, $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $e) {
        echo "<p>Lỗi kết nối database: " . $e->getMessage() . "</p>";
        exit();
    }
}

// Lấy tất cả contacts
function get_all_contacts() {
    $db = get_db();
    $query = 'SELECT contactID, name, email FROM contacts ORDER BY name';
    $statement = $db->prepare($query);
    $statement->execute();
    $contacts = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return $contacts;
}

// Lấy contacts theo danh sách ID
function get_contacts_by_ids($ids) {
    if (empty($ids)) return [];
    $db = get_db();
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $query = "SELECT contactID, name, email FROM contacts WHERE contactID IN ($placeholders)";
    $statement = $db->prepare($query);
    $statement->execute($ids);
    $contacts = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return $contacts;
}
?>


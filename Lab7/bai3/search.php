<?php
declare(strict_types=1);

require __DIR__ . '/../config/database.php';

header('Content-Type: application/json; charset=utf-8');

$term = trim($_GET['term'] ?? '');
if ($term === '') {
    echo json_encode([], JSON_UNESCAPED_UNICODE);
    exit;
}

$statement = $pdo->prepare(
    'SELECT tenhp FROM hocphan WHERE tenhp LIKE :term ORDER BY tenhp LIMIT 10'
);
$statement->execute(['term' => $term . '%']);

echo json_encode(
    $statement->fetchAll(PDO::FETCH_COLUMN),
    JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR
);

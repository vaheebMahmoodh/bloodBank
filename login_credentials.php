<?php
header('Content-Type: application/json');
require_once 'dvConnection.php';

try {
    $stmt = $pdo->query("SELECT email, password FROM login_credentials LIMIT 1");
    $row = $stmt->fetch();
    if ($row) {
        echo json_encode([
            'email' => $row['email'],
            'password' => $row['password']
        ]);
    } else {
        echo json_encode(['error' => 'No credentials found']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error']);
}
?>
<?php
require_once 'dvConnection.php';
require_once 'cacheHelpers.php';

$stmt = $pdo->query("SELECT id, full_name, email, age, blood_type, phone_number, last_donation_date FROM blood_donors");
$donors = $stmt->fetchAll(PDO::FETCH_ASSOC);

saveDonorCache($donors);

echo "Imported " . count($donors) . " donors from DB to cache.";
?>
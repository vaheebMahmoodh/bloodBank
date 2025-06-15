<?php
require_once 'cacheHelpers.php';

$data = $_POST;
if (empty($data) && isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] === 'application/json') {
    $data = json_decode(file_get_contents('php://input'), true);
}
if (empty($data['email'])) {
    echo "error: email required";
    exit;
}
if (empty($data['phone_number'])) {
    echo "error: phone number required";
    exit;
}

$donors = getDonorCache();

// Check for duplicate phone number
foreach ($donors as $donor) {
    if (
        isset($donor['phone_number']) &&
        preg_replace('/\D/', '', $donor['phone_number']) === preg_replace('/\D/', '', $data['phone_number'])
    ) {
        echo "error: phone number already exists";
        exit;
    }
}

$newId = count($donors) ? max(array_column($donors, 'id')) + 1 : 1;
$data['id'] = $newId;
$donors[] = $data;
saveDonorCache($donors);

echo "success";
?>

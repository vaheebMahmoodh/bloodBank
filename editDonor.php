<?php
// editDonor.php

require_once 'cacheHelpers.php';
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

$donors = getDonorCache();
foreach ($donors as &$donor) {
    if ($donor['id'] == $data['id']) {
        $donor = array_merge($donor, $data);
        break;
    }
}
saveDonorCache($donors);
echo json_encode(['success' => true]);
?>
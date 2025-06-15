<?php
require_once 'cacheHelpers.php';
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

$donors = getDonorCache();
if (isset($data['delete_all']) && $data['delete_all'] === true) {
    $donors = [];
} elseif (isset($data['ids']) && is_array($data['ids'])) {
    $donors = array_filter($donors, fn($d) => !in_array($d['id'], $data['ids']));
}
saveDonorCache(array_values($donors));
echo json_encode(['success' => true]);
?>
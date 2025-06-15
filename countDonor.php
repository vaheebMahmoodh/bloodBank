<?php
require_once 'cacheHelpers.php';
header('Content-Type: application/json');
$donors = getDonorCache();
echo json_encode(['count' => count($donors)]);
?>
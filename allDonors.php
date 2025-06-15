<?php
require_once 'cacheHelpers.php';
header('Content-Type: application/json');
echo json_encode(getDonorCache());
?>
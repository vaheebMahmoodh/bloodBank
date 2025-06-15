<?php
require_once 'cacheHelpers.php';
header('Content-Type: application/json');

$bloodType = isset($_GET['blood_type']) ? trim($_GET['blood_type']) : '';
$donors = getDonorCache();

if ($bloodType !== '') {
    $donors = array_filter($donors, function($d) use ($bloodType) {
        return isset($d['blood_type']) && $d['blood_type'] === $bloodType;
    });
}

// Map fields for frontend compatibility
$donors = array_map(function($d) {
    return [
        'name'      => $d['full_name'] ?? '',
        'bloodType' => $d['blood_type'] ?? '',
        'contact'   => $d['phone_number'] ?? '',
        'date'      => $d['last_donation_date'] ?? ''
    ];
}, array_values($donors));

echo json_encode($donors);
?>
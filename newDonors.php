<?php
// newDonors.php

require_once 'cacheHelpers.php';
header('Content-Type: application/json');
$donors = getDonorCache();
usort($donors, fn($a, $b) => $b['id'] <=> $a['id']);
$recent = array_slice($donors, 0, 6);
$mapped = array_map(function($d) {
    return [
        'name'      => $d['full_name'] ?? '',
        'bloodType' => $d['blood_type'] ?? '',
        'contact'   => $d['phone_number'] ?? '',
        'date'      => $d['last_donation_date'] ?? ''
    ];
}, $recent);
echo json_encode($mapped);
?>
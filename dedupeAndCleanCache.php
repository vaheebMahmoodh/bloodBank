<?php
require_once 'cacheHelpers.php';
$donors = getDonorCache();
$cleaned = array_values(array_filter($donors, function($d) {
    return !empty($d['full_name']) && !empty($d['email']);
}));
saveDonorCache($cleaned);
echo "Cleaned! New count: " . count($cleaned);
?>
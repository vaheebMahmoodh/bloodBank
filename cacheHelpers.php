<?php
// cacheHelpers.php
function getDonorCache() {
    $file = __DIR__ . '/donors_cache.json';
    if (!file_exists($file)) return [];
    return json_decode(file_get_contents($file), true) ?: [];
}

function saveDonorCache($donors) {
    $file = __DIR__ . '/donors_cache.json';
    file_put_contents($file, json_encode($donors, JSON_PRETTY_PRINT));
}
?>
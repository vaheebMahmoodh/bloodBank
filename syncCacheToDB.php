<?php
require_once 'dvConnection.php';
require_once 'cacheHelpers.php';

try {
    $donors = getDonorCache();

    // Remove duplicate emails (keep the first occurrence)
    $uniqueDonors = [];
    $seenEmails = [];
    foreach ($donors as $donor) {
        $email = strtolower(trim($donor['email'] ?? ''));
        if ($email && !in_array($email, $seenEmails)) {
            $uniqueDonors[] = $donor;
            $seenEmails[] = $email;
        }
    }

    // Clear DB and re-insert all donors from cache
    $pdo->exec("DELETE FROM blood_donors");
    $stmt = $pdo->prepare("INSERT INTO blood_donors (id, full_name, email, age, blood_type, phone_number, last_donation_date) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    // Use $uniqueDonors instead of $donors in the insert loop
    foreach ($uniqueDonors as $d) {
        $stmt->execute([
            $d['id'],
            $d['full_name'] ?? '',
            $d['email'] ?? '',
            $d['age'] ?? null,
            $d['blood_type'] ?? '',
            $d['phone_number'] ?? '',
            $d['last_donation_date'] ?? null
        ]);
    }

    $message = date("Y-m-d H:i:s") . " - Synced successfully\n";
    echo $message;
    file_put_contents(__DIR__ . "/cron_log.txt", $message, FILE_APPEND);

} catch (Exception $e) {
    $error = date("Y-m-d H:i:s") . " - Error: " . $e->getMessage() . "\n";
    echo $error;
    file_put_contents(__DIR__ . "/cron_log.txt", $error, FILE_APPEND);
}
?>

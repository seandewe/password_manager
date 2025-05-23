<?php
session_start();
require_once '../classes/PasswordStorage.php';

$userId = $_SESSION['user_id'] ?? 1; // Replace with login
$aesKey = $_SESSION['aes_key'] ?? 'your_decrypted_aes_key'; // Replace with actual key

$store = new PasswordStorage();
$passwords = $store->getPasswords($userId, $aesKey);
?>

<h2>Stored Passwords</h2>
<?php foreach ($passwords as $p): ?>
    <strong><?= htmlspecialchars($p['service_name']) ?></strong><br>
    Password: <?= htmlspecialchars($p['decrypted_password']) ?><br>
    Saved at: <?= $p['created_at'] ?><hr>
<?php endforeach; ?>

<?php
session_start();
require_once '../classes/PasswordStorage.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'] ?? 1; // Replace with real login
    $aesKey = $_SESSION['aes_key'] ?? 'your_decrypted_aes_key'; // Replace with actual key
    $service = $_POST['service'];
    $password = $_POST['password'];

    $store = new PasswordStorage();
    $store->savePassword($userId, $service, $password, $aesKey);
    echo "Password saved!";
}
?>

<form method="post">
    <label>Service Name: <input name="service" required></label><br>
    <label>Password: <input name="password" required></label><br>
    <button type="submit">Save Password</button>
</form>

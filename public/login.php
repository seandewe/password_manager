<?php
session_start();
require_once '../classes/User.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User();
    $userData = $user->getUserByUsername($_POST['username']);

    if ($userData && password_verify($_POST['password'], $userData['password_hash'])) {
        // Derive AES key using user's plain password
        require_once '../classes/EncryptionUtil.php';
        $aesKey = EncryptionUtil::decryptAES($userData['encrypted_key'], $_POST['password']);

        $_SESSION['user_id'] = $userData['id'];
        $_SESSION['aes_key'] = $aesKey;
        header('Location: generate.php');
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<form method="post">
    <h2>Login</h2>
    <?php if ($error): ?><p style="color: red;"><?= htmlspecialchars($error) ?></p><?php endif; ?>
    <label>Username: <input name="username" required></label><br>
    <label>Password: <input type="password" name="password" required></label><br>
    <button type="submit">Login</button>
</form>

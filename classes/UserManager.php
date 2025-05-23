<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/EncryptionUtil.php';

class UserManager {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function register($username, $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $aesKey = bin2hex(random_bytes(16)); // 128-bit key
        $encryptedKey = EncryptionUtil::encryptAES($aesKey, $password);

        $stmt = $this->conn->prepare("INSERT INTO users (username, password_hash, encryption_key) VALUES (?, ?, ?)");
        return $stmt->execute([$username, $hash, $encryptedKey]);
    }

    public function login($username, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            return false;
        }

        $aesKey = EncryptionUtil::decryptAES($user['encryption_key'], $password);
        if (!$aesKey) return false;

        // Store decrypted key in session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['aes_key'] = $aesKey;
        return true;
    }
}

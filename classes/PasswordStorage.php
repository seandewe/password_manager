<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/EncryptionUtil.php';

class PasswordStorage {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function savePassword($userId, $serviceName, $password, $aesKey) {
        $encrypted = EncryptionUtil::encryptAES($password, $aesKey);

        $stmt = $this->conn->prepare(
            "INSERT INTO passwords (user_id, service_name, encrypted_password) VALUES (?, ?, ?)"
        );

        return $stmt->execute([$userId, $serviceName, $encrypted]);
    }

    public function getPasswords($userId, $aesKey) {
        $stmt = $this->conn->prepare("SELECT * FROM passwords WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as &$row) {
            $row['decrypted_password'] = EncryptionUtil::decryptAES($row['encrypted_password'], $aesKey);
        }

        return $results;
    }
}
?>
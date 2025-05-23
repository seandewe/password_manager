<?php
require_once '../classes/PasswordGenerator.php';

$password = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $length = $_POST['length'] ?? 12;
    $lower = $_POST['lower'] ?? 2;
    $upper = $_POST['upper'] ?? 2;
    $digits = $_POST['digits'] ?? 2;
    $special = $_POST['special'] ?? 2;

    $generator = new PasswordGenerator($length, $lower, $upper, $digits, $special);
    $password = $generator->generate();
}
?>

<form method="post">
    <label>Password Length: <input name="length" type="number" value="12"></label><br>
    <label>Lowercase: <input name="lower" type="number" value="2"></label><br>
    <label>Uppercase: <input name="upper" type="number" value="2"></label><br>
    <label>Digits: <input name="digits" type="number" value="2"></label><br>
    <label>Special: <input name="special" type="number" value="2"></label><br>
    <button type="submit">Generate</button>
</form>

<?php if ($password): ?>
    <h3>Generated Password:</h3>
    <input type="text" value="<?= htmlspecialchars($password) ?>" readonly>
<?php endif; ?>

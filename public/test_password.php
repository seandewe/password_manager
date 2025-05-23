<?php
require_once 'classes/PasswordGenerator.php';

// Example: Generate a 10-character password with:
// 2 lowercase, 3 uppercase, 2 numbers, 3 special characters
$length = 10;
$numLowercase = 2;
$numUppercase = 3;
$numDigits = 2;
$numSpecial = 3;

$generator = new PasswordGenerator($length, $numLowercase, $numUppercase, $numDigits, $numSpecial);
$password = $generator->generate();

echo "Generated Password: " . $password . PHP_EOL;

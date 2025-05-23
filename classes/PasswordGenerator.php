<?php
class PasswordGenerator {
    private $length;
    private $numLowercase;
    private $numUppercase;
    private $numDigits;
    private $numSpecial;

    private $lowercase = 'abcdefghijklmnopqrstuvwxyz';
    private $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    private $digits = '0123456789';
    private $special = '!@#$%^&*()-_+=<>?';

    public function __construct($length, $numLowercase, $numUppercase, $numDigits, $numSpecial) {
        $this->length = $length;
        $this->numLowercase = $numLowercase;
        $this->numUppercase = $numUppercase;
        $this->numDigits = $numDigits;
        $this->numSpecial = $numSpecial;
    }

    public function generate() {
        $password = [];

        $password = array_merge(
            $password,
            $this->getRandomChars($this->lowercase, $this->numLowercase),
            $this->getRandomChars($this->uppercase, $this->numUppercase),
            $this->getRandomChars($this->digits, $this->numDigits),
            $this->getRandomChars($this->special, $this->numSpecial)
        );

        // Ensure the password length is met
        $remaining = $this->length - count($password);
        $allChars = $this->lowercase . $this->uppercase . $this->digits . $this->special;
        $password = array_merge($password, $this->getRandomChars($allChars, $remaining));

        shuffle($password);
        return implode('', $password);
    }

    private function getRandomChars($chars, $count) {
        $result = [];
        $length = strlen($chars);
        for ($i = 0; $i < $count; $i++) {
            $result[] = $chars[random_int(0, $length - 1)];
        }
        return $result;
    }
}

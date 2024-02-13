<?php

    include __DIR__ . '/../../resource/crypto.php';

    class SignupController
    {
        public static function renderPageSignup()
        {
            include __DIR__ . '/../view/signup.php';
        }

        public static function processSignup()
        {
            return crypto::word();
        }
    }

?>
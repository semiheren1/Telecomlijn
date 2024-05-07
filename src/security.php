<?php


namespace Parkeren;

class Security
{

    public function generateCSRFToken()
    {
        // Generate a random CSRF token
        $csrfToken = bin2hex(random_bytes(32));

        // Store the token in the session for later verification
        $_SESSION['csrf_token'] = $csrfToken;

        return $csrfToken;
    }

    public function expireCSRFToken()
    {
        $timeSet = $_SESSION['csrf_token_expire'] = time() + 3600;// 3600 is set to 1HR
        unset($timeSet);
    }


    public static function verifyCSRFToken($csrf_token)
    {
        // Verify that a CSRF token was submitted
        if (isset($_SESSION['csrf_token']) && $_SESSION['csrf_token'] === $csrf_token) {
            return true; // CSRF token is valid
        } else {
            return false; // CSRF token is invalid
        }
    }
}
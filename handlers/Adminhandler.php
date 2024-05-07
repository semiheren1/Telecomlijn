<?php
namespace Handlers;

use Parkeren\Db;

class AdminHandler
{
    public function login()
    {
        if (!empty($_POST['email']) && !empty($_POST['pass'])) {
            $email = $_POST['email'];
            $password = $_POST['pass'];

            // Retrieve admin record from the database based on email
            $where = ['email' => $email];
            $admin = Db::$db->select('admin', ['*'], $where);

            if (!empty($admin) && $admin[0]['password'] === $password) {
                 if ($this->endsWith($email, "@urbanindustries.nl")) {
                     // Authentication successful
                     $_SESSION['admin'] = $admin[0];
                     header("Location: index.php?action=admin-dashboard");
                     exit();
                 }
            } else {
                // Authentication failed
                echo "<p>Incorrect email or password. Please try again.</p>";
                header("Refresh:3; url=index.php?action=admin-login");
                exit();
            }
        } else {
            // Invalid input
            echo "<p>Email and password are required.</p>";
            header("Refresh:3; url=index.php?action=admin-login");
            exit();
        }
    }

    function endsWith($haystack, $needle) {
        return str_ends_with($haystack, $needle);
    }
}
?>

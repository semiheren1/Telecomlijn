<?php
declare(strict_types=1);

require_once "vendor/autoload.php";

use Handlers\AdminHandler;
use Parkeren\Db;
use Parkeren\Security;

session_start();

$template = new Smarty();
$template->clearCompiledTemplate();
$template->clearAllCache();

$database = new Db();

$action = $_GET['action'] ?? null;
$admin = Db::$db->select('admin');
switch ($action) {
    case "admin-login":
        $template->display("template/admin-login.tpl");
        break;

    case "login-adm":
        $adminHandler = new AdminHandler();
        $adminHandler->login();
        break;

    case "admin-dashboard":
        // Authenticate admin session or redirect to login if not authenticated
        if (isset($_SESSION['admin'])) {
            $template->display("template/admin-dashboard.tpl");
        } else {
            header("Location: index.php?action=admin-login");
            exit();
        }
        break;

    default:
        $template->display("template/homePage.tpl");
        break;
}

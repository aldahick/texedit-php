<?php
require_once(__DIR__ . "/utils.php");
require_once(__DIR__ . "/../lib/Database.php");
require_once(__DIR__ . "/../lib/User.php");
session_start();
$config = load_config();
$config["pages"] = array(
    "index.php" => "List",
    "create.php" => "Create"
);
$db = new Database($config["db"]);
$db->connect();
if ($db->conn->connect_error) {
    die("Couldn't connect to the MySQL database: " . $db->connect_error);
}
$_VIEW = array(
    "css" => array()
);
?>

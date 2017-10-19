<?php
require_once(__DIR__ . "/inc/global.php");

if (!check_params(array("id"))) {
    http_error(400);
}
if (!isset($_SESSION["user"]) || !Note::can_edit($_POST["id"])) {
    http_error(403);
}

$db->query("DELETE FROM `note` WHERE `id` = :id", array("id" => $_POST["id"]));
?>

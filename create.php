<?php
require_once(__DIR__ . "/inc/layout.php");
$_VIEW["requires_auth"] = true;

function handle_create() {
    global $db;
    if (!check_params(array("title"))) {
        return "You must provide a title to create a note.";
    }
    $sql = "INSERT INTO `note` (`author_id`, `title`, `body`)
        VALUES (:author_id, :title, '')
        ON DUPLICATE KEY UPDATE `title` = VALUES(`title`)";
    $db->query($sql, array(
        "author_id" => $_SESSION["user"]->id,
        "title" => $_POST["title"]));
    $sql = "SELECT `id` FROM `note` WHERE `author_id` = :author_id AND `title` = :title";
    $note = $db->query_single($sql, array(
        "author_id" => $_SESSION["user"]->id,
        "title" => $_POST["title"]));
    return $note["id"];
}

$error_message = "";
if (get_http_method() == "POST") {
    $error_message = handle_create();
    if (is_numeric($error_message)) {
        redirect("edit.php?id=" . $error_message);
    }
}

layout_header();
?>
<h4>Create Note</h4>
<span id="error" style="color: red;"><?=$error_message?></span>
<form class="row" action="" method="POST">
    <div class="col-xs-4">
        <input class="form-control" type="text" name="title" placeholder="Title" required />
    </div>
    <div class="col-xs-2">
        <button class="btn btn-success">Create</button>
    </div>
</form>
<?php
layout_footer();
?>

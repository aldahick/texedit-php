<?php
require_once(__DIR__ . "/inc/layout.php");
$_VIEW["requires_auth"] = true;

function handle_edit() {
    global $db;
    if (!check_params(array("body", "title", "id", "is_shared"))) http_error(400);
    if (!Note::can_edit($_POST["id"])) http_error(403);
    $sql = "UPDATE `note` SET `body` = :body, `title` = :title, `is_shared` = :is_shared WHERE `id` = :id";
    $result = $db->query($sql, array(
        "body" => $_POST["body"],
        "title" => $_POST["title"],
        "is_shared" => $_POST["is_shared"],
        "id" => $_POST["id"]));
    return "";
}

$error_message = "";
if (get_http_method() == "POST") {
    echo(handle_edit());
    exit;
}

$note = $db->query_single("SELECT * FROM `note` WHERE `id` = :id", array("id" => $_GET["id"]));
if (!$note) http_error(404);
if ($note["is_shared"] == 0 && $note["author_id"] != $_SESSION["user"]->id) {
    http_error(403);
}
$_VIEW["css"] = array("https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.7.1/katex.min.css");
$_VIEW["js"] = array("https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.8/ace.js");
layout_header();
?>
<h4 style="display: inline;">Title</h4>
<input id="title" type="text" value="<?=$note["title"]?>" />
<input id="note-id" type="hidden" value="<?=$note["id"]?>" />
<div class="btn-group" data-toggle="buttons">
    <label class="btn btn-primary">
        <input id="shared" type="checkbox" autocomplete="off" <?=$note["is_shared"] == 1 ? "checked" : ""?>/>
        Shared
    </label>
</div>
<span id="error" style="color: red;"><?=$error_message?></span>
<div class="row">
    <div class="col-xs-8">
        <div id="editor"><?=htmlentities($note["body"])?></div>
    </div>
    <div class="col-xs-4">
        <div id="output"></div>
    </div>
</div>
<?php
layout_footer();
?>

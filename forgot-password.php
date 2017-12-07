<?php
require_once(__DIR__ . "/inc/layout.php");

function handle_forgot_password() {
    global $config, $db;
    if (!check_params(array("email"))) {
        return "You must provide an email to reset the password for.";
    }
    $sql = "SELECT `reset_token` as token FROM `user` WHERE `email` = :email";
    $result = $db->query_single($sql, array(
        "email" => $_POST["email"]));
    if (!$result) return "The email provided was not found.";
    $msg = "To reset your TexEdit account, please click <a href='{$config["web"]->baseUrl}{$config["web"]->path}/reset-password.php?token={$result["token"]}'>here</a>.";
    send_email($_POST["email"], "Resetting your TexEdit account", $msg);
    return "";
}

$error_message = "";
if (get_http_method() == "POST") {
    $error_message = handle_forgot_password();
}

layout_header();
?>
<h4>Forgot Password</h4>
<span id="error" style="color: red;"><?=$error_message?></span>
<?php if ($error_message == "" && get_http_method() == "POST"): ?>
    <span id="success" style="color: green;">Sent reset email to <?=$_POST["email"]?>.</span>
<?php endif; ?>
<form class="row" action="" method="POST">
    <div class="col-xs-4">
        <input class="form-control" type="email" name="email" placeholder="Email" required />
    </div>
    <div class="col-xs-2">
        <button class="btn btn-success">Submit</button>
    </div>
</form>
<?php
layout_footer();
?>

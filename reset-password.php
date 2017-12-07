<?php
require_once(__DIR__ . "/inc/layout.php");

function handle_reset_password() {
    global $config, $db;
    if (!check_params(array("token", "password"))) {
        return "You must provide a new password.";
    }
    $password_salt = generate_random_string(32);
    $password_hash = User::hash_password($_POST["password"], $password_salt);
    $sql = "UPDATE `user` SET `password_hash` = :password_hash, `password_salt` = :password_salt WHERE `reset_token` = :token";
    $db->query($sql, array(
        "password_salt" => $password_salt,
        "password_hash" => $password_hash,
        "token" => $_POST["token"]));
    redirect("login.php");
    return "";
}

$error_message = "";
if (get_http_method() == "POST") {
    $error_message = handle_reset_password();
}

layout_header();
?>
<h4>Reset Password</h4>
<span id="error" style="color: red;"><?=$error_message?></span>
<form class="row" action="" method="POST">
    <input type="hidden" name="token" value="<?=$_GET["token"]?>" />
    <div class="col-xs-4">
        <input class="form-control" type="password" name="password" placeholder="New Password" required />
    </div>
    <div class="col-xs-2">
        <button class="btn btn-success">Submit</button>
    </div>
</form>
<?php
layout_footer();
?>

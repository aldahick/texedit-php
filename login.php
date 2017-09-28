<!--
div.col-xs-12.col-md-6.col-md-offset-3
    div.text-center
        h2 Login
        span#error #{error}
        span#success #{success}
    form.form-horizontal(action="/api/auth/local/login", method="POST")
        input(type="hidden", name="from", value=from)
        div.form-group
            label.col-md-2.col-md-offset-1.control-label(for="input-username") Username
            div.col-md-6
                input.form-control(id="input-username", name="username", type="text", required)
        div.form-group
            label.col-md-2.col-md-offset-1.control-label(for="input-password") Password
            div.col-md-6
                input.form-control(id="input-password", name="password", type="password", required)
        div.form-group.text-center
            div
                button.btn.btn-success.btn-submit Submit
                | &nbsp;
                button.btn.btn-info.btn-register Register
-->
<?php
require_once(__DIR__ . "/inc/layout.php");

function handle_login() {
    global $db;
    if (!isset($_POST["username"]) || !isset($_POST["password"])) {
        return "You must provide both an username and a password in order to log in.";
    }
    $user = $db->query_single("SELECT * FROM `user` WHERE `username` = :username", array("username" => $_POST["username"]));
    if (!$user) {
        return "Invalid username or password.";
    }
    if (auth_hash_password($_POST["password"], $user["password_salt"]) != $user["password_hash"]) {
        return "Invalid username or password.";
    }
    $_SESSION["user"] = $user;
    return "";
}

$error_message = "";
if (isset($_SESSION["user"])) {
    $error_message = "You are already logged in as " . $_SESSION["user"]["username"] . ".";
} else if (get_http_method() == "POST") {
    $error_message = handle_login();
    if ($error_message == "") {
        header("Location: " . $_SESSION["last_page"]);
    }
}
?>

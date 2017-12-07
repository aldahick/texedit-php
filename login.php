<?php
require_once(__DIR__ . "/inc/layout.php");

function handle_login() {
    if (!check_params(array("email", "password"))) {
        return "You must provide both an email and a password in order to log in.";
    }
    $user = User::login($_POST["email"], $_POST["password"]);
    if (!$user) {
        return "The email or password you provided was invalid.";
    }
    $_SESSION["user"] = $user;
    return "";
}

$error_message = "";
if (isset($_SESSION["user"])) {
    $error_message = "You are already logged in as " . $_SESSION["user"]->email . ".";
} else if (get_http_method() == "POST") {
    $error_message = handle_login();
    if ($error_message == "") {
        redirect($_SESSION["last_page"]);
    }
}
layout_header();
?>
<div class="col-xs-12 col-md-6 col-md-offset-3">
    <div class="text-center">
        <h2>Log In</h2>
        <span id="status-error"><?=$error_message?></span>
    </div>
    <form class="form-horizontal" action="" method="POST">
        <div class="form-group">
            <label class="col-md-2 col-md-offset-1 control-label" for="input-email">Email</label>
            <div class="col-md-6">
                <input class="form-control" id="input-email" name="email" type="email" required autofocus />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 col-md-offset-1 control-label" for="input-password">Password</label>
            <div class="col-md-6">
                <input class="form-control" id="input-password" name="password" type="password" required />
            </div>
        </div>
        <div class="form-group text-center">
            <div>
                <button class="btn btn-success btn-submit">Submit</button>
                &nbsp;
                <a href="register.php">
                    <button class="btn btn-info btn-register" type="button">Register</button>
                </a>
                &nbsp;
                <a href="forgot-password.php">
                    <button class="btn btn-warning" type="button">Forgot Password</button>
                </a>
            </div>
        </div>
    </form>
</div>
<?php
layout_footer();
?>

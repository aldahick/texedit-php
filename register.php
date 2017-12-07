<?php
/*
Author: Alex Hicks
Date Created: September 7, 2017
Filename: final/register.php
*/
require_once(__DIR__ . "/inc/layout.php");

$user = array();
/**
 * Returns any error as a string
 */
function handle_registration() {
    if (!check_params(array("email", "password", "password2"))) {
        return "You are missing one or more required fields.";
    }
    if ($_POST["password"] != $_POST["password2"]) { // password matches confirm password
        return "The passwords you entered do not match.";
    }
    $user = User::register($_POST["email"], $_POST["password"]);
    if (!$user) {
        return "An internal error occurred. Please try again later.";
    }
    $_SESSION["user"] = $user;
    return "";
}

function get_user_value($name) {
    global $user;
    if (isset($user[$name])) return $user[$name];
    else return "";
}
$error_message = "";
if (get_http_method() == "POST") {
    $error_message = handle_registration();
    if ($error_message == "") {
        redirect($_SESSION["last_page"]);
    }
}
layout_header();

function form_group($name, $input_type, $code_name = "") {
    if ($code_name == "") $code_name = strtolower($name); ?>
<div class="form-group">
    <label class="col-md-3 control-label" for="input-<?=$code_name?>"><?=$name?></label>
    <div class="col-md-6">
        <input class="form-control" id="input-<?=$code_name?>" name="<?=$code_name?>" type="<?=$input_type?>" required />
    </div>
    <div class="col-md-3"></div>
</div>
<?php
}
?>
<div class="col-xs-12 col-md-6 col-md-offset-3">
    <div class="text-center">
        <h2>Register</h2>
        <h4>Create a new account</h4>
        <span id="status-error"><?=$error_message?></span>
    </div>
    <hr />
    <form class="form-horizontal" id="form-register" action="" method="POST">
        <?php
        form_group("Email", "email");
        form_group("Password", "password");
        form_group("Confirm Password", "password", "password2");
        ?>
        <div class="form-group text-center">
            <div>
                <input class="btn btn-success btn-submit" type="submit" value="Submit" />
            </div>
        </div>
    </form>
</div>
<?php
layout_footer();
?>

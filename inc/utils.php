<?php
// Borrowed from http://stackoverflow.com/a/10473026/5850070
function str_startswith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
}

// Borrowed from http://stackoverflow.com/a/10473026/5850070
function str_endswith($haystack, $needle) {
    // search forward starting from end minus needle length characters
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
}

/**
 * Wrapper around magic literal "REQUEST_METHOD".
 */
function get_http_method() {
    return $_SERVER["REQUEST_METHOD"];
}

function load_config() {
    $config = array();
    $files = scandir(__DIR__ . "/../config/");
    foreach ($files as $k => $filename) {
        if (str_endswith($filename, ".sample.json") || $filename == "." || $filename == "..") {
            continue;
        }
        $filename_tokens = explode("/", $filename);
        $key_tokens = explode(".", $filename_tokens[count($filename_tokens) - 1]);
        $config_key = $key_tokens[0];
        $config[$config_key] = json_decode(file_get_contents(__DIR__ . "/../config/$filename"));
    }
    return $config;
}

function get_page_name() {
    global $config;
    $path_tokens = explode(".", $_SERVER["PHP_SELF"]);
    $path = $path_tokens[0];
    return substr($path, strlen($config["web"]->path));
}

function check_params($params, $body = false) {
    global $_POST;
    if ($body === false) {
        $body = $_POST;
    }
    foreach ($params as $param) {
        if (!isset($body[$param])) {
            return false;
        }
    }
    return true;
}

function redirect($url) {
    global $config;
    $path = $config["web"]->path . "/" . $url;
    header("Location: $path");
    exit;
}

function http_error($code) {
    global $db;
    $messages = array(
        "400" => "Invalid or missing parameters",
        "401" => "Unauthorized",
        "403" => "Access denied",
        "404" => "Not found",
        "500" => "Internal server error"
    );
    $msg = isset($messages[strval($code)]) ? $messages[strval($code)] : "Unspecified error.";
    header($_SERVER["SERVER_PROTOCOL"] . " $code $msg");
    $db->close();
    die($msg);
}
?>

<?php
require_once(__DIR__ . "/global.php");
function layout_header() {
    global $_VIEW, $config;
    $page_name = get_page_name();
    $main_css = "css$page_name.css";
    $title = "TexEdit";
    if (isset($_VIEW["title"])) {
        $title = $_VIEW["title"] . " - " . $title;
    }
    if ($page_name != "/register" && $page_name != "/login") {
        $_SESSION["last_page"] = substr($page_name, 1) . ".php";
        if (strlen($_SERVER['QUERY_STRING']) > 0) {
            $_SESSION["last_page"] .= "?" . $_SERVER['QUERY_STRING'];
        }
    }
    if (isset($_VIEW["requires_auth"]) && $_VIEW["requires_auth"] && !isset($_SESSION["user"])) {
        redirect("login.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?=$title?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600" />
    <!-- Bootstrap 3 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <!-- Bootstrap 3 Theme -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.3.7/cosmo/bootstrap.min.css" /> -->
    <!-- Bootstrap 4 -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css" /> -->
    <!-- Bootstrap Side Navbar -->
    <link rel="stylesheet" href="css/lib/bootstrap-side-navbar.min.css" />
    <?php foreach ($_VIEW["css"] as $href): ?>
        <link rel="stylesheet" href="<?=$href?>" />
    <?php endforeach; ?>
    <link rel="stylesheet" href="css/global.css" />
    <?php
    if (file_exists(__DIR__ . "/../" . $main_css)):
    ?>
        <link rel="stylesheet" href="<?=$main_css?>" />
    <?php endif; ?>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3 col-lg-2">
                <nav id="navbar-parent" class="navbar navbar-default navbar-fixed-side">
                    <div class="container">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="index.php">TexEdit</a>
                        </div>
                        <div id="navbar" class="navbar-collapse collapse">
                            <ul class="nav navbar-nav">
                                <?php foreach ($config["pages"] as $page => $name): ?>
                                    <li<?=$page == $page_name ? ' class="active"' : "" ?>>
                                        <a href="<?=$page?>"><?=$name?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="col-sm-9 col-lg-10">
                <div class="row parent-row">
                    <div id="body-content" class="col-xs-12">
<?php
}

function layout_footer() {
    global $db, $_VIEW;
    $page_name = get_page_name();
    $db->close();
?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/es6-shim/0.35.3/es6-shim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/js/bootstrap.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/systemjs/0.20.18/system.js"></script>
    <?php foreach ($_VIEW["js"] as $k => $url): ?>
        <script src="<?=$url?>"></script>
    <?php endforeach; ?>
    <script src="js/common.js"></script>
    <script>
        SystemJS.import("<?=$page_name?>".substring(1) + ".js");
    </script>
</body>
</html>
<?php
}
?>

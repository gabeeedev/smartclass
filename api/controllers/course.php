<?php
require_once "../util/auth.php";
require_once "../util/util.php";

loginRedirect();

if(!isset($_GET["course"])) {
    include "../pages/not_found.html";
    exit();
}

$cid = $_GET["course"];

if (isTeacher($cid)) {
    echo "As teacher!";
} else if(isStudent($cid)) {
    echo "As student!";
} else {
    include "../pages/not_found.html";
    exit();
}

?>
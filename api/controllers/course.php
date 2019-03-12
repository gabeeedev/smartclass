<?php
require_once "../util/auth.php";
require_once "../util/util.php";

loginRedirect();

if(!isset($_GET['course'])) {
    include "../pages/not_found.html";
    exit();
}

if (isTeacher()) {
    # code...
}

?>
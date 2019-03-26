<?php
require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();

if(!isset($_GET["course"])) {
    include "../pages/not_found.html";
    exit();
}

$cid = $_GET["course"];
setCurrentCourse($cid);

if (isset($_SESSION["course"]["as"])) {

?>
<link rel="stylesheet" href="css/themes/light.css">
<div id="menu" class="side-bar">
    <div class="side-bar-item menu-control">
        <div class="side-bar-icon"><i class="material-icons">menu</i></div>
        <div class="side-bar-text">Menu</div>
    </div>
    <div class="side-bar-item" redirect="index" target="#page">
        <div class="side-bar-icon"><i class="material-icons">arrow_back</i></div>
        <div class="side-bar-text">Back</div>
    </div>
    <div class="side-bar-item mt-4" redirect="debug" target="#content">
        <div class="side-bar-icon"><i class="material-icons">home</i></div>
        <div class="side-bar-text">Home</div>
    </div>
    <div class="side-bar-item" redirect="course_materials" target="#content">
        <div class="side-bar-icon"><i class="material-icons">folder</i></div>
        <div class="side-bar-text">Materials</div>
    </div>
    <div class="side-bar-item" redirect="debug" target="#content">
        <div class="side-bar-icon"><i class="material-icons">assignment</i></div>
        <div class="side-bar-text">Assigments</div>
    </div>
    <div class="side-bar-item" redirect="debug" target="#content">
        <div class="side-bar-icon"><i class="material-icons">bar_chart</i></div>
        <div class="side-bar-text">Grades</div>
    </div>
    <div class="side-bar-item" redirect="debug" target="#content">
        <div class="side-bar-icon"><i class="material-icons">how_to_vote</i></div>
        <div class="side-bar-text">Votes</div>
    </div>

    <?php
    if (asTeacher()) {
        ?>
        <div class="side-bar-item" redirect="debug" target="#content">
            <div class="side-bar-icon"><i class="material-icons">settings</i></div>
            <div class="side-bar-text">Settings</div>
        </div>
        <?php
    }
    ?>

    <div class="side-bar-item exit-control" request="logout">
        <div class="side-bar-icon"><i class="material-icons">exit_to_app</i></div>
        <div class="side-bar-text">Logout</div>
    </div>
</div>
<div id="content" class="content">

</div>
<?php

} else {
    include "../pages/not_found.html";
    exit();
}

?>
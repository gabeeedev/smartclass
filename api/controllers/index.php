<?php

    if (!file_exists("../util/config.php") || !filesize("../util/config.php")) {
        require_once("../install.php");
        exit();
    }

require_once "../util/auth.php";

loginRedirect();

?>

<link rel="stylesheet" href="css/themes/light.css">
<div id="menu" class="side-bar">
    <div class="side-bar-item menu-control">
        <div class="side-bar-icon"><i class="material-icons">menu</i></div>
        <div class="side-bar-text">Menu</div>
    </div>
    <div class="side-bar-item" redirect="debug" target="#content">
        <div class="side-bar-icon"><i class="material-icons">account_circle</i></div>
        <div class="side-bar-text">Profile</div>
    </div>
    <div class="side-bar-item mb-4" redirect="debug" target="#content">
        <div class="side-bar-icon"><i class="material-icons">home</i></div>
        <div class="side-bar-text">Home</div>
    </div>
    <div class="side-bar-item" redirect="course_list" target="#content">
        <div class="side-bar-icon"><i class="material-icons">school</i></div>
        <div class="side-bar-text">Courses</div>
    </div>
    <div class="side-bar-item" redirect="material_list" target="#content">
        <div class="side-bar-icon"><i class="material-icons">folder</i></div>
        <div class="side-bar-text">Materials</div>
    </div>
    <div class="side-bar-item exit-control" request="logout">
        <div class="side-bar-icon"><i class="material-icons">exit_to_app</i></div>
        <div class="side-bar-text">Logout</div>
    </div>
</div>
<div id="content" class="content">

</div>
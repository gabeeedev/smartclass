<?php
require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();

if(!hasRole(1)) {
    exit();
}

?>
<link rel="stylesheet" href="css/themes/light.css">
<div id="menu" class="side-bar">
    <div class="side-bar-item menu-control">
        <div class="side-bar-icon"><i class="material-icons">menu</i></div>
        <div class="side-bar-text">Menu</div>
    </div>
    <div class="side-bar-item mb-4" page="index" sub="main_home">
        <div class="side-bar-icon"><i class="material-icons">arrow_back</i></div>
        <div class="side-bar-text">Back</div>
    </div>
    <div class="side-bar-item" content="developer_testing">
        <div class="side-bar-icon"><i class="material-icons">check_box</i></div>
        <div class="side-bar-text">Testing</div>
    </div>
    <div class="side-bar-item" content="debug">
        <div class="side-bar-icon"><i class="material-icons">bug_report</i></div>
        <div class="side-bar-text">Debug</div>
    </div>

    <div class="side-bar-item exit-control" request="logout">
        <div class="side-bar-icon"><i class="material-icons">exit_to_app</i></div>
        <div class="side-bar-text">Logout</div>
    </div>
</div>
<div id="content" class="content">

</div>
<?php

?>
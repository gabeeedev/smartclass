<?php

    if (!file_exists("../util/config.php") || !filesize("../util/config.php")) {
        require_once("../install.php");
        exit();
    }

require_once "../util/auth.php";

loginRedirect();

?>

<div id="menu" class="side-bar">
    <div class="side-bar-item menu-control">
        <div class="side-bar-icon"><i class="material-icons">menu</i></div>
        <div class="side-bar-text">Menu</div>
    </div>
    <div class="side-bar-item" target="#content" content="user_settings">
        <div class="side-bar-icon"><i class="material-icons">account_circle</i></div>
        <div class="side-bar-text">Profile</div>
    </div>
    <div class="side-bar-item mb-4" target="#content" content="main_home">
        <div class="side-bar-icon"><i class="material-icons">home</i></div>
        <div class="side-bar-text">Home</div>
    </div>
    <div class="side-bar-item" target="#content" content="course_list">
        <div class="side-bar-icon"><i class="material-icons">school</i></div>
        <div class="side-bar-text">Courses</div>
    </div>
    <div class="side-bar-item" target="#content" content="material_list">
        <div class="side-bar-icon"><i class="material-icons">folder</i></div>
        <div class="side-bar-text">Materials</div>
    </div>
    <div class="side-bar-item mb-4" target="#content" content="quiz_bank_list">
        <div class="side-bar-icon"><i class="material-icons">list_alt</i></div>
        <div class="side-bar-text">Question Banks</div>
    </div>
    <?php
        if(hasRole(1)) {
            ?>
                <div class="side-bar-item" target="#page" page="developer" sub="developer_testing">
                    <div class="side-bar-icon"><i class="material-icons">build</i></div>
                    <div class="side-bar-text">Developer</div>
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

<script>
    // loadController("main_home","#content");
</script>
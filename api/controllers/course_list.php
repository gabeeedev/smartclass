<?php
require_once "../util/auth.php";
require_once "../util/util.php";

loginRedirect();
?>
<div class="d-flex flex-col">
    <div class="column">
        <h1>Attending</h1>
        <form id="joinCourse">
        <small id="courseTokenError" class="form-text text-danger"></small>
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="courseToken" placeholder="Token">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Join</button>
                </div>
            </div>        
        </form>

        <div class="course-list">        
            <?php
                $data = sql_select("SELECT * FROM attends JOIN courses ON course=courseid WHERE user = ?",[$_SESSION["user"]["userid"]]);
                foreach ($data as $k => $v) {
                    ?>
                        <div class="course-box course-active" <?="redirect='course' target='#page' options='course:" . $v["course"] . "'"?>>
                            <h2><?=$v["title"]?></h2>
                            <span><?=$v["token"]?></span>
                        </div>
                    <?php
                }
            ?>
        </div>
    </div>
    <div class="column">
        <h1>Teaching</h1>
        <form id="createCourse">
            <small id="courseNameError" class="form-text text-danger"></small>
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="courseName" placeholder="Course name">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Create</button>
                </div>
            </div>        
        </form>

        <div class="course-list">        
            <?php
                $data = sql_select("SELECT * FROM teaches JOIN courses ON course=courseid WHERE user = ?",[$_SESSION["user"]["userid"]]);
                foreach ($data as $k => $v) {
                    ?>
                        <div class="course-box course-active" <?="redirect='course' target='#page' options='course:" . $v["course"] . "'"?>>
                            <h2><?=$v["title"]?></h2>
                            <span><?=$v["token"]?></span>
                        </div>
                    <?php
                }
            ?>
        </div>
    </div>
</div>

<?php
require_once "../util/auth.php";
require_once "../util/util.php";

loginRedirect();
?>
<div class="d-flex flex-row">
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
                $data = sql_select("SELECT * FROM attends JOIN courses ON course=courseId WHERE user = ? AND status < 2 ORDER BY status",[$_SESSION["user"]["userId"]]);
                foreach ($data as $row) {

                    $block_class = "block p-3";
                    if($row["status"] == E_ARCHIVED)
                        $block_class .= " archived";

                    ?>
                    <div class="f-row p-2">
                        <div class="<?=$block_class?>">
                            <h2 class="clickable" <?="page='course' pageOptions='course:" . $row["course"] . "' sub='course_home'"?>><?=$row["title"]?></h2>
                            <span><?=$row["token"]?></span>
                        </div>
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

        <div class="d-flex flex-wrap">        
            <?php
                $data = sql_select("SELECT * FROM teaches JOIN courses ON course=courseId WHERE user = ? ORDER BY status, courseId",[$_SESSION["user"]["userId"]]);
                    
                foreach ($data as $row) {

                    $block_class = "block p-3";
                    if($row["status"] == E_ARCHIVED)
                        $block_class .= " archived";
                    if($row["status"] == E_CLOSED)
                        $block_class .= " closed";
                        
                    ?>
                    <div class="f-row p-2">
                        <div class="<?=$block_class?>">
                            <h2 class="clickable" <?="page='course' pageOptions='course:" . $row["course"] . "' sub='course_home'"?>><?=$row["title"]?></h2>
                            <span><?=$row["token"]?></span>
                        </div>
                    </div>
                        
                    <?php
                }
            ?>
        </div>
    </div>
</div>

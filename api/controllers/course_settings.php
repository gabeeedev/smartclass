<?php

require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();

$id = $_SESSION["course"]["id"];

$course = sql_select_unique("SELECT * FROM courses WHERE courseId = ?",[$id]);

if (asTeacher()) {  
    ?>

    <h2>Settings</h2>
    <!-- <div class="row"> -->
        <form id="courseSettings">
            <div class="form-group">
                <label for="courseTitle">Title</label>
                <input type="text" class="form-control" id="courseTitle" placeholder="Title" value=<?="'" . $course["title"] . "'"?>>
            </div>
            <div class="form-group mb-4">
                <label for="courseStatus">State</label>
                <select id="courseStatus" class="form-control">
                    <option <?=$course["status"] == 0 ? "selected" : ""?> value="0">Active</option>
                    <option <?=$course["status"] == 1 ? "selected" : ""?> value="1">Archived</option>
                    <option <?=$course["status"] == 2 ? "selected" : ""?> value="2">Closed</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
        <hr>
        <div class="mt-4">
        <h2>Delete Course</h2>
            <button type="button" class="btn btn-danger" delete_popup="<?=$course["title"]?>" delete_service="course_delete" delete_id="<?=$id?>">Delete Course</button>
        </div>
    <!-- </div> -->

    <?php
}
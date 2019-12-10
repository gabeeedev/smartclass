<?php

require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();

$id = $_SESSION["course"]["id"];

$course = sql_select_unique("SELECT * FROM courses WHERE courseid = ?",[$id]);

if (asTeacher()) {  
    ?>

    <h2>Settings</h2>
    <form id="courseSettings">
    <div class="row">
        <div class="form-group col-12">
            <label for="courseTitle">Title</label>
            <input type="text" class="form-control" id="courseTitle" placeholder="Title" value=<?="'" . $course["title"] . "'"?>>
        </div>
        <div class="form-group col-12 mb-4">
            <label for="courseStatus">State</label>
            <select id="courseStatus" class="form-control">
                <option <?=$course["status"] == 0 ? "selected" : ""?> value="0">Active</option>
                <option <?=$course["status"] == 1 ? "selected" : ""?> value="1">Archived</option>
                <option <?=$course["status"] == 2 ? "selected" : ""?> value="2">Closed</option>
            </select>
        </div>
        <div class="form-check col-12 mb-4">
            <input type="checkbox" <?=$course["isPublic"] !== "0" ? "checked" : ""?> id="publicCourse">
            <label class="form-check-label" for="publicCourse">
                Public course
            </label>
        </div>
        <div class="form-group col-12">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </div>
    </form>

    <?php
}
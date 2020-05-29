<?php

/**
 * New post
 * postContent - Post content
 */


require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();

if (checkPostData(["postContent"])) {
    $post = $_POST["postContent"];

    $t = sql_insert("posts",["content" => $post, "course" => $_SESSION["course"]["id"],"user" => $_SESSION["user"]["userId"]]);
    echo "1";
}
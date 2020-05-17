<?php
require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();

if (checkPostData(["commentContent","postId"])) {
    $content = $_POST["commentContent"];
    $post = $_POST["postId"];
    $user = $_SESSION["user"]["userId"];

    $t = sql_insert("comments",["content" => $content, "post" => $post,"user" => $user]);
    echo "1";
}
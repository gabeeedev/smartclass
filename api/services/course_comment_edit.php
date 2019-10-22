<?php
require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();

if (isset($_POST["commentContent"])) {
    $content = $_POST["commentContent"];
    $post = $_POST["postId"];
    $user = $_SESSION["user"]["userid"];

    $t = sql_insert("comments",["content" => $content, "post" => $post,"user" => $user]);
}
<?php
require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();

if (isset($_POST["postContent"])) {
    $post = $_POST["postContent"];

    $t = sql_insert("posts",["content" => $post, "course" => $_SESSION["course"]["id"],"user" => $_SESSION["user"]["userid"]]);
    echo $t;
}

echo $_SESSION["course"]["id"];
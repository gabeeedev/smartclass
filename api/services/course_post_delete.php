<?php

/**
 * Delete post
 * id - Post ID
 */

require_once "../util/course.php";
require_once "../util/util.php";

loginDie();

$id = $_POST["id"];
    
$count = sql_delete("DELETE FROM posts WHERE postId = ? AND user = ?",[$id,$_SESSION["user"]["userId"]]);

if ($count > 0) {
    sql_delete("DELETE FROM comments WHERE post = ?",[$id]);
}

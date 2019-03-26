<?php
require_once "../util/auth.php";
require_once "../util/util.php";

loginRedirect();

if (isset($_GET["id"])) {

    $show = false;

    $row = sql_select_unique("SELECT * FROM materials WHERE materialid = ?",[$_GET["id"]]);

    if($row === false) exit();

    if ($row["author"] != $_SESSION["user"]["userid"]) {
        
    }

    ?>
        <div class="p-4">
            <h2><?=$row["title"]?></h2>
            <div class="mt-4"><?=$row["content"]?></div>
        </div>        
    <?php
}
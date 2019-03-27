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

    $files = sql_select("SELECT * FROM material_files WHERE material = ?",[$row["materialid"]]);

    ?>
        <div class="p-4">
            <h2><?=$row["title"]?></h2>
            <div class="my-4"><?=$row["content"]?></div>
            <h3>Files</h3>
            <div class="d-flex flex-col">
                <?php
                    foreach($files as $file) {
                        ?>
                            <div class="py-2">
                                <div class="block p-3 rounded">
                                    <?=$file["title"]?>
                                </div>
                            </div>
                        <?php
                    }
                ?>
            </div>
        </div>        
    <?php
}
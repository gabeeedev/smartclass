<?php

require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();


if (isset($_GET["id"])) {
    
    $id = $_GET["id"];
    $course = $_SESSION["course"]["id"];
    $show = true;

    //Owner check
    $material = sql_select_unique("SELECT * FROM materials WHERE materialId = ? AND author = ?",[$_GET["id"],$_SESSION["user"]["userId"]]);

    if ($material === false) {

        $material = sql_select_unique("SELECT * FROM materials m, material_shared ms WHERE m.materialId = ? AND m.materialId = ms.material AND availableFrom < CURRENT_TIMESTAMP AND availableTo > CURRENT_TIMESTAMP AND ms.course = ?",[$_GET["id"],$_SESSION["course"]["id"]]);

        if($material === false) {
            $show = false;
        }

        $attend = sql_select_unique("SELECT * FROM attends WHERE user = ? AND course = ?",[$_SESSION["user"]["userId"],$material["course"]]);

        if ($attend === false) {
            $show = false;
        }
    }

    if (!$show) {
        include("../pages/not_found.html");
        exit();
    }

    $files = sql_select("SELECT * FROM material_files WHERE material = ?",[$material["materialId"]]);

    ?>
        <div class="p-4">
            <h2><?=$material["title"]?></h2>
            <div class="my-4"><?=$material["content"]?></div>
            <h3>Files</h3>
            <div class="d-flex flex-column w-resp">
                <?php
                    foreach($files as $file) {
                        ?>
                            <div class="py-2">
                                <div class="block p-3 rounded clickable" downloader="course_material_download" id=<?=$file["materialFileId"]?>>
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

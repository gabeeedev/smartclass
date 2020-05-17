<?php

require_once "../util/auth.php";
require_once "../util/util.php";

loginRedirect();

if (isset($_GET["id"])) {
    
    $id = $_GET["id"];
    $course = $_SESSION["course"]["id"];

    $mat = sql_select_unique("SELECT mf.filePath, mf.title, m.materialId, m.author FROM material_files mf, materials m WHERE mf.materialFileId = ? AND mf.material = m.materialId",[$id]);

    if ($mat === false) {
        exit();
    }

    if ($mat["author"] != $_SESSION["user"]["userId"]) {

        $share = sql_select_unique("SELECT * FROM material_shared ms, attends a WHERE ms.material = ? AND ms.course = ? AND ms.course = a.course AND a.user = ? AND ms.availableFrom < CURRENT_TIMESTAMP AND ms.availableTo > CURRENT_TIMESTAMP",[$mat["materialId"],$course,$_SESSION["user"]["userId"]]);

        if($share === false) {
            echo "Material problem.";
            exit();
        }
    }

    downloadFile("materials/" . $mat["filePath"],$mat["title"]);
}
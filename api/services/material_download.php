<?php

require_once "../util/auth.php";
require_once "../util/util.php";

loginRedirect();

$id = $_GET["id"];

$data = sql_select_unique("SELECT author, filePath, mf.title FROM material_files mf, materials m WHERE mf.material = m.materialId AND mf.materialFileId = ?",[$id]);
if ($data["author"] == $_SESSION["user"]["userId"]) {
    downloadFile("materials/" . $data["filePath"],$data["title"]);
}
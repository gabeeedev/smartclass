<?php

/**
 * Share material with course
 * materialShare - Material ID
 */

require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();

if (isset($_POST["materialShare"]) && asTeacher()) {
    $from = checkPostData(["fromPicker"]) ? $_POST["fromPicker"] : NULL;
    $to = checkPostData(["toPicker"]) ? $_POST["toPicker"] : NULL;
    $material = $_POST["materialShare"];

    sql_insert("material_shared",["material" => $material, "course" => $_SESSION["course"]["id"],"availableFrom" => $from, "availableTo" => $to]);
}

echo $_SESSION["course"]["id"];
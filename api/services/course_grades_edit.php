<?php

require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();

if (asTeacher() && isset($_POST["grading"]) && isset($_POST["grades"])) {
    $grading = $_POST["grading"];
    $grades = $_POST["grades"];
    $filter = [];
    $empty = [];
    foreach($grades as $grade) {
        if (strlen($grade["grade"]) > 0 || strlen($grade["comment"]) > 0) {
            array_push($filter,$grade);
        } else {
            array_push($empty,$grade);
        }
    }

    $existing = sql_select("SELECT * FROM grades WHERE grading = ?",[$grading]);

    $updates = [];
    $removes = [];
    foreach($existing as $grade) {
        foreach($filter as $k => $t) {
            if ($t["id"] == $grade["user"]) {

                if ($t["grade"] != $grade["grade"] || $t["comment"] != $grade["comment"]) {
                    $t["gradeid"] = $grade["gradeid"];
                    array_push($updates,$t);
                }
                
                unset($filter[$k]);
                break;
            }
        }

        foreach($empty as $k => $t) {
            if ($t["id"] == $grade["user"]) {
                array_push($removes,$grade["gradeid"]);
                unset($empty[$k]);
                break;
            }
        }
    }

    $insert = [];
    $cols = ["grade","comment","grading","user"];

    foreach($filter as $v) {
        array_push($insert,[$v["grade"],$v["comment"],$grading,$v["id"]]);
    }
    sql_multiple_insert("grades",$cols,$insert);

    sql_multiple_delete_by_id("grades","gradeid",$removes);

    $insert = [];
    $cols = ["grade","comment"];
    
    foreach($updates as $v) {
        array_push($insert,[$v["grade"],$v["comment"],$v["gradeid"]]);
    }
    sql_multiple_update_by_id("grades","gradeid",$cols,$insert);
}
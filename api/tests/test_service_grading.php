<?php

require_once "tester_service.php";

TEST_CATEGORY_START("Grading Services Test");
    addMockUser();
    $session = ["user" => $mockUser];
    addMockCourse();
    $session["course"] = [];
    $session["course"]["id"] = $mockCourse["courseId"];
    $session["course"]["as"] = "teacher";


    TEST_START("Grading - New");
        $post = [
            "gradingTitle" => "Test Grading",
            "gradingDescription" => "Test grading description",
            "gradingMin" => "0",
            "gradingMax" => "100"
        ];
        $temp = runService("../services/course_grading_edit.php",$session,$post,array());
        $c = sql_delete("DELETE FROM gradings WHERE course = ?",[$mockCourse["courseId"]]);
    TEST_END($c > 0);

    TEST_START("Grading - New Missing");
        $post = [
            "gradingTitle" => "Test Grading",
            "gradingMin" => "0"
        ];
        $temp = runService("../services/course_grading_edit.php",$session,$post,array());
        $c = sql_delete("DELETE FROM gradings WHERE course = ?",[$mockCourse["courseId"]]);
    TEST_END($c == 0);
    
    TEST_START("Grading - New Empty");
        $post = [
            "gradingTitle" => "Test Grading",
            "gradingDescription" => "",
            "gradingMin" => "",
            "gradingMax" => "100"
        ];
        $temp = runService("../services/course_grading_edit.php",$session,$post,array());
        $c = sql_delete("DELETE FROM gradings WHERE course = ?",[$mockCourse["courseId"]]);
    TEST_END($c == 0);

    $mockGradingId = sql_insert("gradings",[
        "title" => "Test grading",
        "description" => "Test grading description",
        "minPoints" => "0",
        "maxPoints" => "100",
        "publicScores" => 1,
        "course" => $mockCourse["courseId"]
    ]);

    TEST_START("Grading - Edit");
        $post = [
            "gradingTitle" => "Edited Grading",
            "gradingDescription" => "Edited grading description",
            "gradingMin" => "0",
            "gradingMax" => "100",
            "gradingEdit" => $mockGradingId
        ];
        $temp = runService("../services/course_grading_edit.php",$session,$post,array());
        $grading = sql_select_unique("SELECT * FROM gradings WHERE gradingId = ?",[$mockGradingId]);
    TEST_END($grading["title"] == $post["gradingTitle"]);

    TEST_START("Grading - Delete");
        $post = ["id" => $mockGradingId];
        $temp = runService("../services/course_grading_delete.php",$session,$post,array());
        $mat = sql_select_unique("SELECT * FROM materials WHERE materialId = ?",[$mockGradingId]);
    TEST_END($mat === false);
    
    sql_delete("DELETE FROM gradings WHERE course = ?",[$mockCourse["courseId"]]);

    removeMockCourse();
    removeMockUser();

TEST_CATEGORY_END();
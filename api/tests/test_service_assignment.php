<?php

require_once "tester_service.php";

TEST_CATEGORY_START("Assignment Services Test");
    addMockUser();
    $session = ["user" => $mockUser];
    addMockCourse();
    $session["course"] = [];
    $session["course"]["id"] = $mockCourse["courseId"];
    $session["course"]["as"] = "teacher";


    TEST_START("Assignment - New");
        $post = [
            "assignmentTitle" => "Test Assignment",
            "assignmentContent" => "Test assignment content",
            "assignmentFrom" => "2020-01-01 00:00:00",
            "assignmentTo" => "2020-12-31 23:59:59",
            "assignmentExt" => ["pdf","zip"]
        ];
        $temp = runService("../services/course_assignment_edit.php",$session,$post,array());
        $c = sql_delete("DELETE FROM assignments WHERE course = ?",[$mockCourse["courseId"]]);
    TEST_END($c > 0);

    TEST_START("Assignment - New Missing");
        $post = [
            "assignmentTitle" => "Test Assignment",
            "assignmentExt" => ["pdf","zip"]
        ];
        $temp = runService("../services/course_assignment_edit.php",$session,$post,array());
        $c = sql_delete("DELETE FROM assignments WHERE course = ?",[$mockCourse["courseId"]]);
    TEST_END($c == 0);
    
    TEST_START("Assignment - New Empty");
        $post = [
            "assignmentTitle" => "",
            "assignmentContent" => "",
            "assignmentFrom" => "2020-01-01 00:00:00",
            "assignmentTo" => "2020-12-31 23:59:59",
            "assignmentExt" => ["pdf","zip"]
        ];
        $temp = runService("../services/course_assignment_edit.php",$session,$post,array());
        $c = sql_delete("DELETE FROM assignments WHERE course = ?",[$mockCourse["courseId"]]);
    TEST_END($c == 0);

    $mockAssignmentId = sql_insert("assignments",[
        "title" => "Test Assignment",
        "content" => "Test assignment content",
        "availableFrom" => "2020-01-01 00:00:00",
        "availableTo" => "2020-12-31 23:59:59",
        "extensions" => "pdf,zip",
        "course" => $mockCourse["courseId"]
    ]);

    TEST_START("Assignment - Edit");
        $post = [
            "assignmentTitle" => "Edited Assignment",
            "assignmentContent" => "Test assignment content",
            "assignmentFrom" => "2020-01-01 00:00:00",
            "assignmentTo" => "2020-12-31 23:59:59",
            "assignmentExt" => ["pdf","zip"],
            "assignmentEdit" => $mockAssignmentId
        ];
        $temp = runService("../services/course_assignment_edit.php",$session,$post,array());
        $assignment = sql_select_unique("SELECT * FROM assignments WHERE assignmentId = ?",[$mockAssignmentId]);
    TEST_END($assignment["title"] == $post["assignmentTitle"]);

    TEST_START("Assignment - Delete");
        $post = ["id" => $mockAssignmentId];
        $temp = runService("../services/course_assignment_delete.php",$session,$post,array());
        $assignment = sql_select_unique("SELECT * FROM assignments WHERE assignmentId = ?",[$mockAssignmentId]);
    TEST_END($assignment === false);
    
    sql_delete("DELETE FROM assignments WHERE course = ?",[$mockCourse["courseId"]]);

    removeMockCourse();
    removeMockUser();

TEST_CATEGORY_END();
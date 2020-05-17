<?php

require_once "tester_service.php";

TEST_CATEGORY_START("Material Services Test");

    addMockUser();
    $session = ["user" => $mockUser];
    $session["materialFiles"] = [];

    TEST_START("Material - New");
        $post = [
            "materialTitle" => "Test material",
            "materialContent" => "Testing content"
        ];
        $temp = runService("../services/material_edit.php",$session,$post,array());        
        $c = sql_delete("DELETE FROM materials WHERE author = ?",[$mockUser["userId"]]);
    TEST_END($c > 0);

    TEST_START("Material - New Missing");
        $post = [
            "materialTitle" => "Test material",
        ];
        $temp = runService("../services/material_edit.php",$session,$post,array());        
        $c = sql_delete("DELETE FROM materials WHERE author = ?",[$mockUser["userId"]]);
    TEST_END($c == 0);

    TEST_START("Material - New Empty");
        $post = [
            "materialTitle" => "Test material",
            "materialContent" => ""
        ];
        $temp = runService("../services/material_edit.php",$session,$post,array());        
        $c = sql_delete("DELETE FROM materials WHERE author = ?",[$mockUser["userId"]]);
    TEST_END($c == 0);

    $mockMaterialId = sql_insert("materials",["title" => "Test material", "content" => "Testing content", "author" => $mockUser["userId"]]);
    TEST_START("Material - Edit");
        $post = [
            "materialTitle" => "Edited material",
            "materialContent" => "Edited content",
            "edit" => $mockMaterialId
        ];
        $temp = runService("../services/material_edit.php",$session,$post,array());        
        $mat = sql_select_unique("SELECT * FROM materials WHERE materialId = ?",[$mockMaterialId]);
    TEST_END($mat["title"] == $post["materialTitle"]);
    
    TEST_START("Material - Archive");
        $post = ["id" => $mockMaterialId];
        $temp = runService("../services/material_archive.php",$session,$post,array());
        $mat = sql_select_unique("SELECT * FROM materials WHERE materialId = ?",[$mockMaterialId]);
    TEST_END($mat["status"] == E_ARCHIVED);

    TEST_START("Material - Delete");
        $post = ["id" => $mockMaterialId];
        $temp = runService("../services/material_delete.php",$session,$post,array());
        $mat = sql_select_unique("SELECT * FROM materials WHERE materialId = ?",[$mockMaterialId]);
    TEST_END($mat === false);

    // TEST_START("Register - Missing");
    //     $post = [
    //         "registerUsername" => "reg_test", 
    //         "registerName" => "Register tester", 
    //         "registerPassword" => "1234", 
    //     ];
    //     $temp = runService("../services/register.php",array(),$post,array());
    // TEST_END(!isset($temp["session"]["user"]));
    addMockCourse();
    $session["course"] = [];
    $session["course"]["id"] = $mockCourse["courseId"];
    $session["course"]["as"] = "teacher";
    $mockMaterialId = sql_insert("materials",["title" => "Test material", "content" => "Testing content", "author" => $mockUser["userId"]]);

    TEST_START("Material - Share");
        $post = [
            "materialShare" => $mockMaterialId,
            "fromPicker" => "2020-01-01 00:00:00",
            "toPicker" => "2020-12-31 23:59:59"
        ];
        $temp = runService("../services/course_material_share.php",$session,$post,array());
        $c = sql_delete("DELETE FROM material_shared WHERE course = ?",[$mockCourse["courseId"]]);
    TEST_END($c > 0);

    sql_delete("DELETE FROM materials WHERE author = ?",[$mockUser["userId"]]);
    removeMockCourse();
    removeMockUser();

TEST_CATEGORY_END();
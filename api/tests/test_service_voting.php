<?php

require_once "tester_service.php";

TEST_CATEGORY_START("Voting Services Test");
    addMockUser();
    $session = ["user" => $mockUser];
    addMockCourse();
    $session["course"] = [];
    $session["course"]["id"] = $mockCourse["courseId"];
    $session["course"]["as"] = "teacher";


    TEST_START("Voting - New");
        $post = [
            "votingTitle" => "Test Voting",
            "votingDescription" => "Test voting content",
            "votingFrom" => "2020-01-01 00:00:00",
            "votingTo" => "2020-12-31 23:59:59",
            "votingAnswers" => ["A","B"]
        ];
        $temp = runService("../services/course_voting_edit.php",$session,$post,array());

        $voc = sql_delete("DELETE FROM voting_options WHERE voting IN (SELECT votingId FROM votings WHERE course = ?)",[$mockCourse["courseId"]]);
        $vc = sql_delete("DELETE FROM votings WHERE course = ?",[$mockCourse["courseId"]]);
    TEST_END($voc == count($post["votingAnswers"]) && $vc > 0);

    TEST_START("Voting - New Missing");
        $post = [
            "votingTitle" => "Test Voting",
            "votingAnswers" => ["A","B"]
        ];
        $temp = runService("../services/course_voting_edit.php",$session,$post,array());
        $c = sql_delete("DELETE FROM votings WHERE course = ?",[$mockCourse["courseId"]]);
    TEST_END($c == 0);
    
    TEST_START("Voting - New Empty");
        $post = [
            "votingTitle" => "",
            "votingDescription" => "",
            "votingFrom" => "2020-01-01 00:00:00",
            "votingTo" => "2020-12-31 23:59:59",
            "votingAnswers" => ["A","B"]
        ];
        $temp = runService("../services/course_voting_edit.php",$session,$post,array());
        $c = sql_delete("DELETE FROM votings WHERE course = ?",[$mockCourse["courseId"]]);
    TEST_END($c == 0);

    $mockVotingId = sql_insert("votings",[
        "title" => "Test Voting",
        "description" => "Test voting content",
        "availableFrom" => "2020-01-01 00:00:00",
        "availableTo" => "2020-12-31 23:59:59",
        "course" => $mockCourse["courseId"],
        "multiple" => 0,
        "anonymous" => 0,
        "result" => 0
    ]);

    sql_insert("voting_options",["title" => "Adsfsf","voting" => $mockVotingId]);
    sql_insert("voting_options",["title" => "Bdsfds","voting" => $mockVotingId]);

    TEST_START("Voting - Delete");
        $post = ["id" => $mockVotingId];
        $temp = runService("../services/course_voting_delete.php",$session,$post,array());
        $voting = sql_select_unique("SELECT * FROM votings WHERE votingId = ?",[$mockVotingId]);
        $votingOptions = sql_select("SELECT * FROM voting_options WHERE voting = ?",[$mockVotingId]);

    TEST_END($voting === false && count($votingOptions) == 0);
    
    $voc = sql_delete("DELETE FROM voting_options WHERE voting IN (SELECT votingId FROM votings WHERE course = ?)",[$mockCourse["courseId"]]);
    $vc = sql_delete("DELETE FROM votings WHERE course = ?",[$mockCourse["courseId"]]);

    removeMockCourse();
    removeMockUser();

TEST_CATEGORY_END();
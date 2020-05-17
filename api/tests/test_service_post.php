<?php

require_once "tester_service.php";

TEST_CATEGORY_START("Post & Comment Services Test");
    addMockUser();
    $session = ["user" => $mockUser];
    addMockCourse();
    $session["course"] = [];
    $session["course"]["id"] = $mockCourse["courseId"];
    $session["course"]["as"] = "teacher";

    TEST_CATEGORY_START("Post");

        TEST_START("Post - New");
            $post = [
                "postContent" => "Test post content"
            ];
            $temp = runService("../services/course_post_edit.php",$session,$post,array());
            $c = sql_delete("DELETE FROM posts WHERE course = ?",[$mockCourse["courseId"]]);
        TEST_END($c > 0);

        TEST_START("Post - New Missing");
            $post = [];
            $temp = runService("../services/course_post_edit.php",$session,$post,array());
            $c = sql_delete("DELETE FROM posts WHERE course = ?",[$mockCourse["courseId"]]);
        TEST_END($c == 0);
        
        TEST_START("Post - New Empty");
            $post = [
                "postContent" => ""
            ];
            $temp = runService("../services/course_post_edit.php",$session,$post,array());
            $c = sql_delete("DELETE FROM posts WHERE course = ?",[$mockCourse["courseId"]]);
        TEST_END($c == 0);
        
    TEST_CATEGORY_END();

    TEST_CATEGORY_START("Comment");

        $mockPostId = sql_insert("posts",["content" => "Mock post", "user" => $mockUser["userId"], "course" => $mockCourse["courseId"]]);

        TEST_START("Comment - New");
            $post = [
                "commentContent" => "Test comment content",
                "postId" => $mockPostId
            ];
            $temp = runService("../services/course_comment_edit.php",$session,$post,array());
            $c = sql_delete("DELETE FROM comments WHERE post = ?",[$mockPostId]);
        TEST_END($c > 0);

        TEST_START("Comment - New Missing");
        $post = [
            "postId" => $mockPostId
        ];
        $temp = runService("../services/course_comment_edit.php",$session,$post,array());
        $c = sql_delete("DELETE FROM comments WHERE post = ?",[$mockPostId]);
        TEST_END($c == 0);

        TEST_START("Comment - New Empty");
            $post = [
                "commentContent" => "",
                "postId" => $mockPostId
            ];
            $temp = runService("../services/course_comment_edit.php",$session,$post,array());
            $c = sql_delete("DELETE FROM comments WHERE post = ?",[$mockPostId]);
        TEST_END($c == 0);
        
    TEST_CATEGORY_END();

    removeMockCourse();
    removeMockUser();

TEST_CATEGORY_END();
<?php

require_once "tester_service.php";

TEST_CATEGORY_START("General Services Test");

    TEST_CATEGORY_START("Register");
        TEST_START("Register - Correct");
            $post = [
                "registerUsername" => "reg_test", 
                "registerEmail" => "reg_test@reg_test.reg", 
                "registerName" => "Register tester", 
                "registerPassword" => "1234", 
                "registerRepeatPassword" => "1234"
            ];
            $temp = runService("../services/register.php",array(),$post,array());
            $c = sql_delete("DELETE FROM users WHERE userid = ?",[$temp["session"]["user"]["userId"]]);
        TEST_END($c > 0);

        TEST_START("Register - Empty");
            $post = [];
            $temp = runService("../services/register.php",array(),$post,array());
        TEST_END(!isset($temp["session"]["user"]));

        TEST_START("Register - Missing");
            $post = [
                "registerUsername" => "reg_test", 
                "registerName" => "Register tester", 
                "registerPassword" => "1234", 
            ];
            $temp = runService("../services/register.php",array(),$post,array());
        TEST_END(!isset($temp["session"]["user"]));
        
        TEST_START("Register - Empty Fields");
        $post = [
            "registerUsername" => "reg_test", 
            "registerEmail" => "", 
            "registerName" => "Register tester",
            "registerPassword" => "", 
            "registerRepeatPassword" => ""
        ];
        $temp = runService("../services/register.php",array(),$post,array());
        TEST_END(!isset($temp["session"]["user"]));
    TEST_CATEGORY_END();
        
    TEST_CATEGORY_START("Login");

        addMockUser();

        TEST_START("Login - Correct");
            $temp = runService("../services/login.php",array(),["loginUsername" => $mockUser["username"], "loginPassword" => $mockUser["password"]], array());
        TEST_END(isset($temp["session"]["user"]));

        TEST_START("Login - Empty");
            $temp = runService("../services/login.php",array(),[], array());
        TEST_END(!isset($temp["session"]["user"]));

        TEST_START("Login - Incorrect");
            $temp = runService("../services/login.php",array(),["loginUsername" => "fake", "loginPassword" => "fake"], array());
        TEST_END(!isset($temp["session"]["user"]));

        removeMockUser();

    TEST_CATEGORY_END();
    
    TEST_CATEGORY_START("Logout");

        addMockUser();

        TEST_START("Logout");
            $temp = runService("../services/logout.php",["user" => $mockUser],array(),array());
        TEST_END(!isset($temp["session"]["user"]));

        removeMockUser();

    TEST_CATEGORY_END();

    TEST_CATEGORY_START("User Settings");

        addMockUser();

        TEST_START("Password Change");
            $post = [
                "settingsOldPassword" => "1234",
                "settingsPassword" => "4321",
                "settingsRepeatPassword" => "4321"
            ];
            runService("../services/user_password_edit.php",["user" => $mockUser],$post,array());
            $temp = sql_select_unique("SELECT * FROM users WHERE userId = ?",[$mockUser["userId"]]);
        TEST_END(checkPassword($post["settingsPassword"],$temp));

        removeMockUser();
        addMockUser();

        TEST_START("Wrong old password");
            $post = [
                "settingsOldPassword" => "4321",
                "settingsPassword" => "4321",
                "settingsRepeatPassword" => "4321"
            ];
            runService("../services/user_password_edit.php",["user" => $mockUser],$post,array());
            $temp = sql_select_unique("SELECT * FROM users WHERE userId = ?",[$mockUser["userId"]]);
        TEST_END(checkPassword($mockUser["password"],$temp));

        TEST_START("User Settings Change");
            $post = [
                "settingsName" => "Edited Mock User",
                "settingsEmail" => "mock@editor.user"
            ];
            runService("../services/user_settings_edit.php",["user" => $mockUser],$post,array());
            $temp = sql_select_unique("SELECT * FROM users WHERE userId = ?",[$mockUser["userId"]]);
        TEST_END($post["settingsName"] == $temp["name"] && $post["settingsEmail"] == $temp["email"]);

        removeMockUser();
        
    TEST_CATEGORY_END();

TEST_CATEGORY_END();
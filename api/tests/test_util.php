<?php

require_once "tester.php";

TEST_CATEGORY_START("Utility");

    TEST_START("Password generate and check");

        echo "Password: test<br>";
        $password = makePassword("test");
        echo "Hashed password: $password";
        $fakeUser = ["password" => $password];

    TEST_END(checkPassword("test",$fakeUser));
    
    TEST_START("Generate token");
        $token = generateToken(7);
        echo "Token: $token";
    TEST_END(strlen($token) == 7);

    TEST_START("Get file info");
        $file = "Random_File name 2011.02.23..pdf";
        echo "File name: $file<br>";
        $info = getFile($file);
        echo "File info:<br>";
        printArray($info);
        $success = $info["name"] == "Random_File name 2011.02.23." and $info["ext"] == "pdf";
    TEST_END($success);

TEST_CATEGORY_END();


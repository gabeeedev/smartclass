<?php

require_once "tester.php";

TEST_CATEGORY_START("SQL Core functions");

    TEST_CATEGORY_START("Invalid");
        TEST_START("Invalid sql syntax");
            $sql = "SLCT * FROM users";
            echo "SQL: $sql<br>";
            $success = sql_query($sql);
        TEST_END(!$success);

        TEST_START("Invalid object");
            $sql = "SELECT * FROM thems";
            echo "SQL: $sql<br>";
            $success = sql_query($sql);
        TEST_END(!$success);

        TEST_START("Invalid sql parameters");
            $sql = "SELECT * FROM users WHERE userId = ?";
            echo "SQL: $sql<br>";
            $success = sql_query($sql);
        TEST_END(!$success);
    TEST_CATEGORY_END();

    TEST_CATEGORY_START("Select");
        TEST_START("Basic select - sql_select");
            $sql = "SELECT * FROM themes";
            echo "SQL: $sql<br>";
            $data = sql_select($sql);
            echo "Returned rows: " . count($data);
        TEST_END(count($data) > 0);

        TEST_START("Basic select, return non associative array - sql_select_array");
            $sql = "SELECT COUNT(*) FROM themes";
            echo "SQL: $sql<br>";
            $data = sql_select_array($sql);
            printArray($data);
        TEST_END($data[0][0] > 0);

        TEST_START("Basic select first row - sql_select_unique");
            $sql = "SELECT COUNT(*) c FROM themes";
            echo "SQL: $sql<br>";
            $data = sql_select_unique($sql);
            printArray($data);
        TEST_END($data["c"] > 0);

        TEST_START("Complex select");
            $sql = "SELECT name FROM users u, user_role ur WHERE u.userId = ur.user AND ur.role = 1";
            echo "SQL: $sql<br>";
            $data = sql_select($sql);
            printArray($data);
        TEST_END(count($data) > 0);

    TEST_CATEGORY_END();

TEST_CATEGORY_END();

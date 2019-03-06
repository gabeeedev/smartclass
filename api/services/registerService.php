<?php

require_once "../util/auth.php";

if(isLoggedIn()) {
    exit();
}

include("../pages/register.html");
<?php

require_once "../util/auth.php";

if(isLoggedIn()) {

} else {
    ?>
    <link rel="stylesheet" href="css/themes/light.css">
    <div class="flex-center">
        <div class="login-form">
            <form>
                <div class="login-logo">
                    S
                </div>
                <div class="form-group">
                    <input type="username" class="form-control form-simple" id="username" placeholder="Username / E-mail">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control form-simple" id="password" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-login">Login</button>
            </form>
        </div>
    </div>
    

    <?php
}
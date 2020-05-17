<?php
require_once "../util/auth.php";
require_once "../util/util.php";

loginRedirect();

$user = sql_select_unique("SELECT email, name FROM users WHERE userId = ?",[$_SESSION["user"]["userId"]]);
// $user = sql_select_unique("SELECT email, name, language, theme FROM users, user_settings WHERE userId = ? AND usetid = settings",[$_SESSION["user"]["userId"]]);
?>

<div class="w-resp">
    <h2>Settings</h2>
    <h3 class="mt-4">User</h3>
    <form id="userSettings">
        <div class="form-group">
            <label for="settingsEmail">E-mail</label>
            <input type="email" class="form-control" id="settingsEmail" placeholder="E-mail" value="<?=$user["email"]?>">
        </div>
        <div class="form-group">
            <label for="settingsName">Name</label>
            <input type="text" class="form-control" id="settingsName" placeholder="Name" value="<?=$user["name"]?>">
        </div>
        <!-- <div class="form-group">
            <label for="settingsLanguage">Language</label>
            <select class="form-control" id="settingsLanguage"> -->
                <?php
                    // $languages = sql_select("SELECT * FROM languages");
                    // foreach($languages as $row) {
                    //     if ($row["langid"] == $user["language"]) {
                    //         echo "<option selected value='" . $row["langid"] . "'>" . $row["title"] . "</option>";
                    //     }
                    //     else {
                    //         echo "<option value='" . $row["langid"] . "'>" . $row["title"] . "</option>";                            
                    //     }
                    // }
                ?>
            <!-- </select>
        </div>
        <div class="form-group">
            <label for="settingsTheme">Theme</label>
            <select class="form-control" id="settingsTheme"> -->
                <?php
                    // $languages = sql_select("SELECT * FROM themes");
                    // foreach($languages as $row) {
                    //     if ($row["themeid"] == $user["theme"]) {
                    //         echo "<option selected value='" . $row["themeid"] . "'>" . $row["title"] . "</option>";
                    //     }
                    //     else {
                    //         echo "<option value='" . $row["themeid"] . "'>" . $row["title"] . "</option>";                            
                    //     }
                    // }
                ?>
            <!-- </select>
        </div> -->
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
    <h3 class="mt-4">New password</h3>
    <form id="passwordSettings">
        <div class="form-group">
            <input type="password" class="form-control" id="settingsOldPassword" placeholder="Current password" autocomplete="off">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" id="settingsPassword" placeholder="Password" autocomplete="off">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" id="settingsRepeatPassword" placeholder="Repeat password" autocomplete="off">
        </div>
        <button type="submit" class="btn btn-primary">Change password</button>
        <div id="passwordEditErrors" class="py-2">
            
        </div>
    </form>
</div>
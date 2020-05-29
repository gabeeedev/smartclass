<?php

/**
 * Delete voting
 * id - Voting ID
 */

require_once "../util/auth.php";
require_once "../util/util.php";

loginDie();

$id = $_POST["id"];

$voting = sql_select_unique("SELECT * FROM votings WHERE votingId = ?",[$id]);
$teaches = sql_select("SELECT * FROM teaches WHERE course = ? AND user = ?",[$voting["course"],$_SESSION["user"]["userId"]]);

if ($teaches !== false) {
    
    $count = sql_delete("DELETE FROM votings WHERE votingId = ?",[$id]);

    if ($count > 0) {
        sql_delete("DELETE FROM votes WHERE option IN (SELECT votingOptionId FROM votings_options WHERE voting = ?)",[$id]);
        sql_delete("DELETE FROM voting_options WHERE voting = ?",[$id]);
    }

}
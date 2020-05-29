<?php

/**
 * Voting votes
 * voting - Voting ID
 * votes - Selected voting options
 */


require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();
if (isset($_POST["voting"]) && isset($_POST["votes"])) {
    $id = $_POST["voting"];
    $votes = $_POST["votes"];

    $t = sql_select_unique("SELECT COUNT(*) c FROM votes v, voting_options vo WHERE v.user = ? AND v.option = vo.votingOptionId AND vo.voting = ?",[$_SESSION["user"]["userId"],$id]);

    if ($t["c"] == 0) {
        $data = [];
        foreach ($votes as $v) {
            if ($v["value"] === "true") {
                array_push($data,[$_SESSION["user"]["userId"],$v["id"]]);
            }
        }
        sql_multiple_insert("votes",["user","option"],$data);
    }

}
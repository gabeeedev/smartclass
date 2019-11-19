<?php

require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();

$id = $_GET["id"];

$voting = sql_select_unique("SELECT * FROM voting WHERE voting_id = ?",[$id]);
$list = sql_select("SELECT voting_opt_id, title, COUNT(user) votes FROM voting_options vo, votes v WHERE vo.voting_opt_id = v.option AND voting = ? GROUP BY voting_opt_id, title ORDER BY votes",[$id]);

echo "<h1>" . $voting["title"] . "</h1>";
echo "<p>" . $voting["description"] . "</p>";
echo "<div class='row'>";
foreach($list as $row) {
    ?>
        <div class="form-check col-12 mb-4">
            <?php
            if ($voting["multiple"]) { ?>
                <input type="checkbox" value="" name=<?="votingChoice[" . $row["voting_opt_id"] . "]"?>>
            <?php } else { ?>
                <input type="radio" value="" name=<?="votingChoice[" . $row["voting_opt_id"] . "]"?>>
            <?php }
            ?>
            <label class="form-check-label">
                <?=$row["title"] . $voting["result"] != 0 ?: "(" . $row["votes"] . " votes)"?>
            </label>
        </div>
        <div class="form-group col-12">
            <button type="submit" class="btn btn-primary">Vote</button>
        </div>

    <?php
}
echo "</div>";

?>

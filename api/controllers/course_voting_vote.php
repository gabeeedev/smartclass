<?php

require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();

$id = $_GET["id"];

$voting = sql_select_unique("SELECT * FROM voting WHERE voting_id = ?",[$id]);
$list = sql_select("SELECT * FROM voting_options vo WHERE voting = ?",[$id]);

echo "<h1>" . $voting["title"] . "</h1>";
echo "<p>" . $voting["description"] . "</p>";

foreach($list as $row) {
    ?>

        <div class="form-check col-12 mb-4">
            <input type="checkbox" value="" id="votingMultiple">
            <label class="form-check-label" for="votingMultiple">
                <?=$row["title"]?>
            </label>
        </div>

    <?php
}

?>

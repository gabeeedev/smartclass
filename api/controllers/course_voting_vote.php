<?php

require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();

$id = $_GET["id"];
$voting = sql_select_unique("SELECT * FROM voting WHERE voting_id = ?",[$id]);

echo "<h1>" . $voting["title"] . "</h1>";
echo "<p>" . $voting["description"] . "</p>";

if (asTeacher()) {
    $list = sql_select("SELECT vo.voting_opt_id, vo.title, COUNT(user) votes FROM voting_options vo LEFT JOIN votes v ON vo.voting_opt_id = v.option WHERE voting = ? GROUP BY vo.voting_opt_id, vo.title ORDER BY votes DESC",[$id]);
    echo "<div class='row'>";
    foreach($list as $row) {
        ?>
            <div class="col-12 mb-4">
                <span class="badge badge-secondary p-2 mr-2"><?=$row["votes"]?></span>
                <?=$row["title"]?>
            </div>

        <?php
    }
    echo "</div>";
    
    
    // if ($voting["anonymous"] == 0) {
    //     $list = sql_select("SELECT * FROM voting_options vo, votes v, users u WHERE v.user = u.userid AND vo.voting = ? AND vo.voting_opt_id = v.option",[$id]);

        
        
    // }

} else {
    $t = sql_select_unique("SELECT COUNT(*) c FROM votes v, voting_options vo WHERE v.user = ? AND v.option = vo.voting_opt_id AND vo.voting = ?",[$_SESSION["user"]["userid"],$id]);

    if ($t["c"] == 0) {

        $list = sql_select("SELECT vo.voting_opt_id, vo.title, COUNT(user) votes FROM voting_options vo LEFT JOIN votes v ON vo.voting_opt_id = v.option WHERE voting = ? GROUP BY vo.voting_opt_id, vo.title",[$id]);
        
        echo "<form id='votingVote'><div class='row'>";
        echo "<input type='hidden' id='votingId' value='$id'>";
        foreach($list as $row) {
            ?>
                <div class="form-check col-12 mb-4">
                    <?php
                    if ($voting["multiple"]) { ?>
                        <input type="checkbox" value="" name="votingChoice" vote=<?=$row["voting_opt_id"]?>>
                    <?php } else { ?>
                        <input type="radio" value="" name="votingChoice" vote=<?=$row["voting_opt_id"]?>>
                    <?php }
                    ?>
                    <label class="form-check-label">
                        <?=$row["title"] . " " . ($voting["result"] != 0 ? "(" . $row["votes"] . " votes)" : "")?>
                    </label>
                </div>

            <?php
        }
        echo "</div>";

        ?>
        <div class="form-group col-12">
            <button type="submit" class="btn btn-primary">Vote</button>
        </div>
        </form>

    <?php 
    }
    else {
        
        if ($voting["result"] != 0) {            
            
            $list = sql_select("SELECT vo.voting_opt_id, vo.title, COUNT(user) votes FROM voting_options vo LEFT JOIN votes v ON vo.voting_opt_id = v.option WHERE voting = ? GROUP BY vo.voting_opt_id, vo.title ORDER BY votes DESC",[$id]);
            echo "<div class='row'>";
            foreach($list as $row) {
                ?>
                    <div class="col-12 mb-4">
                        <span class="badge badge-secondary p-2 mr-2"><?=$row["votes"]?></span>
                        <?=$row["title"]?>
                    </div>

                <?php
            }
            echo "</div>";

        }
    }
}
?>
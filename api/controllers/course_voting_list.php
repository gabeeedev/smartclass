<?php

require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();

$list = sql_select("SELECT * FROM votings WHERE course = ? AND availableFrom < CURRENT_TIMESTAMP AND availableTo > CURRENT_TIMESTAMP ORDER BY availableTo, availableFrom",[$_SESSION["course"]["id"]]);

?>

<div class="w-100 p-2 icon-48">
    <i class="material-icons cursor-pointer list-changer" list-to="f-row">
    view_stream
    </i>
    <i class="material-icons cursor-pointer list-changer" list-to="f-box">
    view_module
    </i>
    <i class="material-icons cursor-pointer list-changer" list-to="">
    view_quilt
    </i>
</div>
<div class="w-100 d-flex flex-wrap list-changeable" list-style="f-row">

<?php if (asTeacher()) { ?> 
    <div class="f-row p-2">
        <div class="block clickable p-3 rounded d-flex flex-row" content="course_voting_edit">
            <div class="font-weight-bold flex-max mr-4">New voting</div>
            <i class="material-icons flex-static mx-1">add_circle</i>
        </div>
    </div>
    <?php } ?>

    <?php
        foreach($list as $row) {
            ?>
            <div class="f-row p-2">
                <div class="block p-3 rounded d-flex flex-row">
                    <div class="font-weight-bold clickable flex-max mr-4" content="course_voting" contentOptions=<?="id:" . $row["votingId"]?>>
                        <?=$row["title"]?>
                    </div>
                            <span class="mx-4 font-italic"><?=$row["availableTo"]?></span>
                    <?php if (asTeacher()) { ?> 

                            <i class="material-icons flex-static mx-1 clickable" delete_popup="<?=$row["title"]?>" delete_service="course_voting_delete" delete_id="<?=$row["votingId"]?>">delete</i>
                    <?php } ?>                    
                </div>
            </div>
                
            <?php
        }
    ?>
</div>
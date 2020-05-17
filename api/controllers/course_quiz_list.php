<?php

require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();

$list = sql_select("SELECT *,(availableFrom < CURRENT_TIMESTAMP AND availableTo > CURRENT_TIMESTAMP) available FROM quizes WHERE course = ? ORDER BY availableTo, availableFrom",[$_SESSION["course"]["id"]]);

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
        <div class="block clickable p-3 rounded d-flex flex-row" content="course_quiz_edit">
            <div class="font-weight-bold flex-max mr-4">New Quiz</div>
            <i class="material-icons flex-static mx-1">add_circle</i>
        </div>
    </div>
    <?php } ?>

    <?php
        foreach($list as $row) {

            $blockClass = "block p-3 rounded d-flex flex-row";
            $div = "<div class='flex-max mr-4'>";
            $badge = "";
            $end = false;
            if ($row["available"]) {
                $div = "<div class='font-weight-bold clickable flex-max mr-4' content='course_quiz' contentOptions='id:" .  $row["quizId"] . "'>";
                $badge = "<span class='badge badge-info fw1'>Open</span>";
                $fill = sql_select_unique("SELECT * FROM quiz_fills WHERE user = ? AND quiz = ?",[$_SESSION["user"]["userId"],$row["quizId"]]);
                if ($fill === false || $fill["startTime"] === NULL) {
                    $end = $row["availableTo"];
                } else {
                    $badge = "<span class='badge badge-warning fw1'>Ongoing</span>";
                    if ($fill["finishTime"] === NULL) {
                        if (timeDiff(getCurrentTime(),$fill["startTime"]) < $row["length"]*60) {
                            $end = date("Y-m-d h:i:s",strtotime($fill["startTime"]) + $row["length"]*60);
                        } else {
                            $badge = "<span class='badge badge-danger fw1'>Missed</span>";
                        }
                    } else {
                        $badge = "<span class='badge badge-success fw1'>Finished</span>";
                    }
                }

            } else {
                if (timeDiff(getCurrentTime(),$row["availableFrom"]) < 0) {
                    $end = $row["availableFrom"];
                    $blockClass .= " unavailable";
                    $badge = "<span class='badge badge-secondary fw1'>Upcoming</span>";
                } else {
                    $blockClass .= " unavailable";
                    $badge = "<span class='badge badge-secondary fw1'>Closed</span>";
                }
            }
            
            $timer = "";
            if ($end !== false) {
                $diff = timeDiff($end,getCurrentTime());
                if ($diff < 86400) {
                    $timer = "<span class='ml-auto mr-2' timer='". $diff . "'></span>";
                } else {
                    $timer = "<span class='ml-auto mr-2'>$end</span>";
                }
            }

            ?>
            <div class="f-row p-2">
                <div class='<?=$blockClass?>'>

                    <?=$div?>
                        <?=$row["title"]?>
                        
                    </div>
                    <?=$timer?>
                    <?=$badge?>
                    <?php if (asTeacher()) { ?> 
                            <i class="material-icons flex-static mx-1 clickable" delete_popup="<?=$row["title"]?>" delete_service="course_quiz_delete" delete_id="<?=$row["quizId"]?>">delete</i>
                    <?php } ?>                    
                </div>
            </div>
                
        <?php } ?>
</div>
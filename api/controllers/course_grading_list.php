<?php

require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();

$list = sql_select("SELECT * FROM gradings WHERE course = ? ORDER BY gradingDate DESC",[$_SESSION["course"]["id"]]);

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
        <div class="block clickable p-3 rounded d-flex flex-row" content="course_grading_edit">
            <div class="font-weight-bold flex-max mr-4">New grading sheet</div>
            <i class="material-icons flex-static mx-1">add_circle</i>
        </div>
    </div>
    <?php } ?>

    <?php
        foreach($list as $row) {
            ?>
            <div class="f-row p-2">
                <div class="block p-3 rounded d-flex flex-row">
                    <div class="font-weight-bold clickable flex-max mr-4" content="course_grading" contentOptions=<?="id:" . $row["gradingId"]?>>
                        <?=$row["title"]?>
                    </div>
                    <?php 
                    if(asStudent()) {
                        $t = sql_select_unique("SELECT g.grade, gr.minPoints, gr.maxPoints FROM gradings gr, grades g, users u WHERE gr.gradingId = g.grading AND g.user = u.userId AND g.user = ? AND gr.gradingId = ?",[$_SESSION["user"]["userId"],$row["gradingId"]]);
                        
                        
                        if ($t !== false) {
                            $percent = (floatval($t["grade"]) - floatval($t["minPoints"])) / (floatval($t["maxPoints"]) - floatval($t["minPoints"]));
                            $rgb = "rgb(" . intval(50+(1-$percent)*150) . "," . intval(50+$percent*150) . ",0)";
                            echo "<span class='grade' style='background-color:" . $rgb . ";'>" . $t["grade"] . "/" . $t["maxPoints"] . "</span>";
                        }
                    } 
                    ?>   
                            <span class="mx-4 font-italic"><?=date("Y. M. d. H:i",strtotime($row["gradingDate"]))?></span>
                    <?php if (asTeacher()) { ?> 
                            <i class="material-icons flex-static mx-1 clickable" content="course_grading_edit" contentOptions=<?="edit:" . $row["gradingId"]?>>edit</i>
                            <i class="material-icons flex-static mx-1 clickable" delete_popup="<?=$row["title"]?>" delete_service="course_grading_delete" delete_id="<?=$row["gradingId"]?>">delete</i>
                    <?php } ?>               
                </div>
            </div>
                
            <?php
        }
    ?>
</div>
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
        <div class="block clickable p-3 rounded d-flex flex-row" redirect="course_grading_edit" target="#content">
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
                    <div class="font-weight-bold clickable flex-max mr-4" redirect="course_grading" target="#content" options=<?="id:" . $row["gradingid"]?>>
                        <?=$row["title"]?>
                    </div>
                            <span class="mx-4 font-italic"><?=$row["gradingDate"]?></span>
                    <?php if (asTeacher()) { ?> 

                            <i class="material-icons flex-static mx-1 clickable" redirect="course_grading_edit" target="#content" options=<?="edit:" . $row["gradingid"]?>>edit</i>
                            <i class="material-icons flex-static mx-1 clickable">delete</i>
                    <?php } ?>                    
                </div>
            </div>
                
            <?php
        }
    ?>
</div>
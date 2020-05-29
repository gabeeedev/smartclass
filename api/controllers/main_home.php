<?php

require_once "../util/auth.php";
require_once "../util/util.php";

loginRedirect();

?>

<div class="row">

    <div class="col-6"> 
        <h2>Recent posts</h2>

        <?php

        $posts = sql_select(
            "SELECT 
            c.title, u.name, p.postDate, p.content, p.postId 
            FROM 
            posts p, 
            (SELECT * FROM attends WHERE attends.user = :user UNION SELECT * FROM teaches WHERE teaches.user = :user) a,
            users u, courses c 
            WHERE 
            p.course = a.course AND c.courseId = a.course AND p.user = u.userId 
            ORDER BY 
            p.postDate DESC 
            LIMIT 5",
            ["user" => $_SESSION["user"]["userId"]]);



        foreach($posts as $row) {
            ?>
            <div class="f-row p-2 mb-2">
                <div class="post-block p-3 rounded d-flex flex-column">
                    <div>
                        <b><?=$row["title"]?></b>
                    </div>
                    <div class="d-flex flex-row pb-2">
                        <div class="d-flex">
                            <b><?=$row["name"]?></b>
                        </div>
                        <div class="d-flex ml-auto">
                            <?=date("Y. M. d. H:i",strtotime($row["postDate"]))?>
                        </div>
                    </div>
                    <div class="d-flex">
                        <?=$row["content"]?>
                    </div>               
                    <?php
                    $comments = sql_select("SELECT u.name, c.postDate, c.content FROM comments c, users u WHERE c.user = u.userId AND c.post = ? ORDER BY c.postDate",[$row["postId"]]);
                    foreach ($comments as $com) {
                        ?>
                            <div class="mt-4 comment">
                                <div class="d-flex flex-row pb-1">
                                    <div class="d-flex font-italic small">
                                        <b><?=$com["name"]?></b>
                                    </div>
                                    <div class="d-flex ml-auto font-italic small">
                                        <?=date("Y. M. d. H:i",strtotime($com["postDate"]))?>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <?=$com["content"]?>
                                </div>  
                            </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
                
            <?php
        }


        //$posts = sql_select("SELECT u.name, p.postDate, p.content, p.postId FROM posts p, users u WHERE p.user = u.userId AND p.course = ? ORDER BY p.postDate DESC",[$_SESSION["course"]["id"]]);

        ?>
    </div>

    <div class="col-6">
        <h2>Upcoming assignments</h2>

        <?php 
            $assignments = sql_select("SELECT asg.title, c.title ctitle, asg.assignmentId, asg.availableTo, asg.course FROM assignments asg, (SELECT * FROM attends WHERE attends.user = :user UNION SELECT * FROM teaches WHERE teaches.user = :user) a, courses c WHERE asg.course = a.course AND c.courseId = asg.course AND asg.availableFrom < CURRENT_TIMESTAMP AND asg.availableTo > CURRENT_TIMESTAMP ORDER BY asg.availableTo",["user" => $_SESSION["user"]["userId"]]);
            foreach($assignments as $row) {
                ?>
                <div class="f-row p-2">
                    <div class="block p-3 rounded d-flex flex-row">
                        <div class="font-weight-bold clickable flex-max mr-4" page="course" pageOptions="course:<?=$row["course"]?>" sub="course_assignment" contentOptions=<?="id:" . $row["assignmentId"]?>>
                            <?=$row["ctitle"] . " - " . $row["title"]?>
                        </div>
                        <span class="mx-4 font-italic"><?=date("Y. M. d. H:i",strtotime($row["availableTo"]))?></span>                
                    </div>
                </div>
                    
                <?php
            }
        ?>

        <h2 class="mt-4">Recent grades</h2>
        <?php
            $grades = sql_select("SELECT g.grade, gr.title, c.title ctitle, gr.gradingDate, gr.minPoints, gr.maxPoints, gr.gradingId, gr.course FROM grades g, gradings gr, courses c WHERE g.user = ? AND g.grading = gr.gradingId AND gr.course = c.courseId ORDER BY gradingDate DESC LIMIT 3",[$_SESSION["user"]["userId"]]);

            foreach($grades as $row) {
                ?>
                <div class="f-row p-2">
                    <div class="block p-3 rounded d-flex flex-row">
                        <div class="font-weight-bold clickable flex-max mr-4" page="course" pageOptions="course:<?=$row["course"]?>" sub="course_grading" contentOptions=<?="id:" . $row["gradingId"]?>>
                            <?=$row["ctitle"] . " - " . $row["title"]?>
                        </div>
                        <?php 

                            $percent = (floatval($row["grade"]) - floatval($row["minPoints"])) / (floatval($row["maxPoints"]) - floatval($row["minPoints"]));
                            $rgb = "rgb(" . intval(50+(1-$percent)*150) . "," . intval(50+$percent*150) . ",0)";
                            echo "<span class='grade' style='background-color:" . $rgb . ";'>" . $row["grade"] . "/" . $row["maxPoints"] . "</span>";

                        ?>   
                                <span class="mx-4 font-italic"><?=date("Y. M. d. H:i",strtotime($row["gradingDate"]))?></span>           
                    </div>
                </div>
                    
                <?php
            }
        ?>
        <h2 class="mt-4">New materials</h2>

        <?php

        $materials = sql_select("SELECT c.title ctitle, m.title, m.materialId, ms.availableTo, ms.course FROM materials m, material_shared ms, courses c, attends a WHERE ms.material = m.materialId AND ms.course = c.courseId AND ms.course = a.course AND a.user = ? AND m.status = 0 AND ms.availableFrom < CURRENT_TIMESTAMP AND ms.availableTo > CURRENT_TIMESTAMP ORDER BY ms.availableFrom DESC",[$_SESSION["user"]["userId"]]);

        foreach($materials as $row) {
            ?>
            <div class="f-box p-2">
                <?php
                    $block_class = "block p-3 rounded d-flex flex-row";
                ?>
                <div class=<?='"' . $block_class . '"'?> >
                    <div class="font-weight-bold clickable flex-max mr-4" page="course" pageOptions="course:<?=$row["course"]?>" sub="course_material" contentOptions=<?="id:" . $row["materialId"]?>>
                        <?=$row["ctitle"] . " - " . $row["title"]?>
                    </div>
                    <span class="mx-4 font-italic"><?=date("Y. M. d. H:i",strtotime($row["availableTo"]))?></span>  
                </div>
            </div>
                
        <?php } ?>

        <h2 class="mt-4">Recent votes</h2>
        <?php

        $votes = sql_select("SELECT v.title, c.title ctitle, v.votingId, v.availableTo, v.course FROM votings v, courses c, (SELECT * FROM attends WHERE attends.user = :user UNION SELECT * FROM teaches WHERE teaches.user = :user) a WHERE v.course = c.courseId AND v.course = a.course AND availableFrom < CURRENT_TIMESTAMP AND availableTo > CURRENT_TIMESTAMP ORDER BY availableTo",["user" => $_SESSION["user"]["userId"]]);

        foreach($votes as $row) {
            ?>
            <div class="f-row p-2">
                <div class="block p-3 rounded d-flex flex-row">
                    <div class="font-weight-bold clickable flex-max mr-4" page="course" pageOptions="course:<?=$row["course"]?>" sub="course_voting" contentOptions=<?="id:" . $row["votingId"]?>>
                        <?=$row["ctitle"] . " - " . $row["title"]?>
                    </div>
                    <span class="mx-4 font-italic"><?=date("Y. M. d. H:i",strtotime($row["availableTo"]))?></span>                   
                </div>
            </div>
                
        <?php } ?>
    </div>

</div>
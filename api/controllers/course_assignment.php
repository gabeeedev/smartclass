<?php

require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();

$assignmentId = $_GET["id"];

if (asTeacher()) {
    $files = sql_select("SELECT af.file, u.name FROM assignment_files af, users u WHERE af.user = u.userid AND assignment = ?",[$assignmentId]);

    ?>    
        <div class="p-4">
            <table class="table">  
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Solution</th>
                    </tr>
                </thead>  
                <tbody>
    <?php
    foreach ($files as $row) {
        ?>
            <tr>
                <td><?=$row["name"]?></td>
                <td>
                    <a href="<?="api/files/assignments/" . $row["file"]?>" download >Download</a>     
                </td>
            </tr>
        <?php

    }
    ?>
                </tbody>
            </table>
        </div>
    <?php

} else {
    ?>



    <?php
// }

    $row = sql_select_unique("SELECT * FROM assignments WHERE assignmentid = ?",[$assignmentId]);
    $solution = sql_select_unique("SELECT * FROM assignment_files WHERE assignment = ? AND user = ?",[$assignmentId,$_SESSION["user"]["userid"]]);

    ?>  
        <div class="p-4">
            <h3>Solution</h3>
            <?php
                if ($solution !== false) {
                    ?> 
                        <a href="<?="api/files/assignments/" . $solution["file"]?>" download class="badge badge-primary p-2">Last solution</a> 
                    <?php
                }
            ?>
            <form id="assignmentSolutionForm">
                <input type="hidden" name="assignmentId" id="assingmentId" value="<?=$assignmentId?>">
                <div class="custom-file my-2">
                    <input type="file" class="custom-file-input" id="assignmentSolution" name="assignmentSolution">
                    <label class="custom-file-label" for="assignmentSolution">Choose file</label>
                </div>

                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>

        <div class="p-4">
            <h2><?=$row["title"]?></h2>
            <div class="my-4"><?=$row["content"]?></div>
        </div>
    <?php
    }

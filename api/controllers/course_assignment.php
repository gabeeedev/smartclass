<?php

require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();

$assignmentId = $_GET["id"];

if (asTeacher()) {
    $files = sql_select("SELECT af.aFileId, af.filePath, u.name FROM assignment_files af, users u WHERE af.user = u.userId AND assignment = ?",[$assignmentId]);

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
                <?php foreach ($files as $row) { ?>
                    <tr>
                        <td><?=$row["name"]?></td>
                        <td>
                            <button downloader="course_assignment_solution_download" class="btn btn-primary" id="<?=$row["aFileId"]?>">Download</button>     
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    <?php
}



    $row = sql_select_unique("SELECT * FROM assignments WHERE assignmentId = ?",[$assignmentId]);
    $solution = sql_select_unique("SELECT * FROM assignment_files WHERE assignment = ? AND user = ?",[$assignmentId,$_SESSION["user"]["userId"]]);

    if (asStudent()) {
    

    ?>  
        <div class="p-4">
            <h3>Solution</h3>
            <?php
                if ($solution !== false) {
                    ?> 
                        <a href="<?="files/assignments/" . $solution["filePath"]?>" download class="badge badge-primary p-2">Last solution</a> 
                    <?php
                }
            ?>
            <form id="assignmentSolutionForm">
                <input type="hidden" name="assignmentId" id="assingmentId" value="<?=$assignmentId?>">
                <div class="custom-file my-2">
                    <input type="file" class="custom-file-input" id="assignmentSolution" name="assignmentSolution">
                    <label class="custom-file-label" for="assignmentSolution">Choose file</label>
                </div>
                <div class="mb-2">Available extensions: 
                    <?php
                        foreach(explode(",",$row["extensions"]) as $ext) {
                            echo "<span class='badge badge-primary'>$ext</span>";
                        }
                    ?>
                </div>

                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>

        <?php } ?>

        <hr>
        <div class="p-4">
            <h2><?=$row["title"]?></h2>
            <div class="my-4"><?=$row["content"]?></div>
        </div>
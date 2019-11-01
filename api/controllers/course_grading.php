<?php

require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();

$id = $_GET["id"];
$course = $_SESSION["course"]["id"];

$grading = sql_select_unique("SELECT * FROM gradings WHERE gradingid = ?",[$id]);
if ($grading === false) {
    exit();
}

if (asTeacher()) {

    // $grades = sql_select("SELECT a.user, g.grade, g.comment FROM attends a LEFT JOIN grades g ON a.user = g.user WHERE a.course = ? AND g.grading = ?",[$course,$id]);
    $grades = sql_select("SELECT a.userid, a.name, g.grade, g.comment, g.grading FROM (SELECT * FROM users, attends WHERE users.userid = attends.user) a LEFT JOIN (SELECT * FROM grades WHERE grading = ?) g ON a.user = g.user WHERE a.course = ?",[$id,$course]);
    echo "<input type='hidden' id='gradingId' value='$id'>";
    ?>
        <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Grade</th>
                <th>Comment</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($grades as $row) {
                    echo "<tr uid='" . $row["userid"] . "'>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td><input type='number' data='gradeGrade'  value='".$row["grade"] . "'></td>";
                    echo "<td><input type='text' data='gradeComment' value='".$row["comment"] . "'></td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
    <div class="form-group col-12">
        <button type="button" class="btn btn-primary" id="saveGradesButton">Save grades</button>
    </div>

    <?php
} else {

    if ($grading["public_scores"] > 0) {
        $grades = sql_select("SELECT u.name, g.comment, g.grade FROM grades g, users u WHERE g.user = u.userid AND g.grading = ? ORDER BY u.name",[$id]);
    } else {
        $grades = sql_select("SELECT u.name, g.comment, g.grade FROM grades g, users u WHERE g.user = u.userid AND g.grading = ? AND u.userid = ?",[$id,$_SESSION["user"]["userid"]]);
    }

    ?>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Grade</th>
                <th>Comment</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($grades as $row) {
                    echo "<tr>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["grade"] . "</td>";
                    echo "<td>" . $row["comment"] . "</td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>

    <?php
}

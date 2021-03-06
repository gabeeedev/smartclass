<?php
require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();

if (!asTeacher()) {
    exit();
}

$title = "";
$description = "";
$min = "0";
$max = "100";
$public = "";

if (isset($_GET["edit"])) {
    $row = sql_select_unique("SELECT * FROM gradings where gradingId = ?",[$_GET["edit"]]);
    if ($row !== false) {
        $title = $row["title"];
        $description = $row["description"];
        $min = $row["minPoints"];
        $max = $row["maxPoints"];
        $public = $row["publicScores"] > 0 ? "checked" : "";
    }
}

?>

<h2>New grading sheet</h2>
<form id="gradingForm">
    <div class="col-main">    
        <div class="form-group col-12">
            <label for="gradingTitle">Title</label>
            <input type="text" class="form-control" id="gradingTitle" placeholder="Title" value=<?="'" . $title . "'"?>>
        </div>
        <div class="form-group col-12 mt-4">
            <label for="gradingDescription">Description</label>
            <textarea class="form-control" id="gradingDescription" placeholder="Description"><?=$description?></textarea>
        </div>
        <div class="form-group col-lg-3 col-md-6 col-sm-12">
            <label for="gradingMin">Minimum points</label>
            <input type="number" class="form-control" id="gradingMin" placeholder="Minimum points" value="<?=$min?>">
        </div>
        <div class="form-group col-lg-3 col-md-6 col-sm-12 mb-1">
            <label for="gradingMax">Maximum points</label>
            <input type="number" class="form-control" id="gradingMax" placeholder="Maximum points" value="<?=$max?>">
        </div>
        <i class="col-12 mb-4">Points are goint to be used to calculate statistics</i>

        <div class="form-check col-12 mb-4">
            <input type="checkbox" <?=$public?> id="gradingPublicScores">
            <label class="form-check-label" for="gradingPublicScores">
                Public scores <small>(Students can see each others' scores)</small>
            </label>
        </div>

        <?php
            if (isset($_GET["edit"])) {
                echo "<input type='hidden' value='" . $_GET["edit"] . "' id='gradingEdit'>";
            }
        ?>

        <div class="form-group col-12">
            <button type="submit" class="btn btn-primary">Create grading sheet</button>
        </div>
        
    </div>
</form>

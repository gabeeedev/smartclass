<?php
require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();

if (!asTeacher()) {
    exit();
}

$title = "";
$description = "";

?>

<h2>New voting</h2>
<form id="votingForm">
    <div class="row">    
        <div class="form-group col-12">
            <label for="votingTitle">Title</label>
            <input type="text" class="form-control" id="votingTitle" placeholder="Title" value=<?="'" . $title . "'"?>>
        </div>
        <div class="form-group col-12 mt-4">
            <label for="votingDescription">Description</label>
            <textarea class="form-control" id="votingDescription" placeholder="Description"><?=$description?></textarea>
        </div>
        
        <?php include "../util/timepicker.html"; ?>

        <div class="col-12">
            <h4>Answers</h4>
        </div>
        <div id="votingAnswerList" class="w-25">
            <div class="form-group col-12">
                <input type="text" class="form-control" name="votingAnswer" placeholder="1. answer">
            </div>
            <div class="form-group col-12">
                <input type="text" class="form-control" name="votingAnswer" placeholder="2. answer">
            </div>
        </div>
        <div class="col-12 mb-4">
            <button type="button" class="btn btn-primary" id="votingAddNewAnswer">New answer</button>
        </div>

        <div class="form-check col-12 mb-4">
            <input type="checkbox" value="" id="votingMultiple">
            <label class="form-check-label" for="votingMultiple">
                Allow multiple answers
            </label>
        </div>

        <div class="form-check col-12 mb-4">
            <input type="checkbox" value="" id="votingAnonymous">
            <label class="form-check-label" for="votingAnonymous">
                Anonymous
            </label>
        </div>

        <div class="form-check col-12 mb-4">
            <input type="checkbox" value="" id="votingResult">
            <label class="form-check-label" for="votingResult">
                Public results
            </label>
        </div>

        <?php
            if (isset($_GET["edit"])) {
                echo "<input type='hidden' value='" . $_GET["edit"] . "' id='edit'>";
            }
        ?>

        <div class="form-group col-12">
            <button type="submit" class="btn btn-primary">Create new voting</button>
        </div>
        
    </div>
</form>

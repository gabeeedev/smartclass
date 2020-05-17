<?php
require_once "../util/course.php";
require_once "../util/util.php";
require_once "../util/editor.php";
require_once "../util/timepicker.php";

loginRedirect();

if (!asTeacher()) {
    exit();
}

$title = "";
$content = "";
$fromDate = "";
$toDate = "";
$extensions = "";

if (isset($_GET["edit"])) {
    $editrow = sql_select_unique("SELECT * FROM assignments WHERE assignmentId = ?",[$_GET["edit"]]);
    $title = $editrow["title"];
    $content = $editrow["content"];
    $fromDate = $editrow["availableFrom"];
    $toDate = $editrow["availableTo"];
    $extensions = $editrow["extensions"];
}

?>

<h2>Assignment</h2>
<form id="assignmentForm">
    <div class="col-main">    
        <div class="form-group col-12">
            <label for="assignmentTitle">Title</label>
            <input type="text" class="form-control" id="assignmentTitle" placeholder="Title" value=<?="'" . $title . "'"?>>
        </div>
        <div class="col-12">
            <label for="assignmentContent">Description</label>
        </div>

        <?php generateEditor($content,"assignmentContent"); ?>


        <?php generateTimePicker($fromDate,$toDate); ?>

        <div class="form-group col-12 mt-4">
            <label for="assignmentExt">Available extensions</label>
            <div id="extList" class="badge-list"></div>
            <input type="text" class="form-control" style="display:inline-block;width:200px;" id="assignmentExt" placeholder="Extension" value="<?=$extensions?>">
        </div>

        <script>
            assignmentExt = new Set();
            function assignmentExtension() {
                ext = $("#assignmentExt").val().split(/[.,;/]+[ ]*|[ ]+/);
                ext = ext.map(x => x.toLowerCase());
                ext = Array.from(new Set(ext));

                tmp = "";
                ext.forEach(x => tmp += ('<span class="badge badge-primary">' + x + '</span>'));
                $("#extList").html(tmp);
            }

            assignmentExtension();

            $("#assignmentExt").bind("keyup change", function(e) {
                assignmentExtension();
            });
        </script>

        <?php
            if (isset($_GET["edit"])) {
                echo "<input type='hidden' value='" . $_GET["edit"] . "' id='assignmentEdit'>";
            }
        ?>

        <div class="form-group col-12">
            <button type="submit" class="btn btn-primary">Submit assignment</button>
        </div>
        
    </div>
</form>

<?php
require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();

if (!asTeacher()) {
    exit();
}

$title = "";
$content = "";

?>

<link rel="stylesheet" href="css/medium-editor.min.css">
<link rel="stylesheet" href="css/medium-bootstrap.css">

<h2>Assignment</h2>
<form id="assignmentForm">
    <div class="row">    
        <div class="form-group col-12">
            <label for="assignmentTitle">Title</label>
            <input type="text" class="form-control" id="assignmentTitle" placeholder="Title" value=<?="'" . $title . "'"?>>
        </div>
        <div class="form-group col-12 mt-4">
            <label for="assignmentContent">Assignment</label>
            <textarea class="medium-editor-textarea editable h-25" id="assignmentContent"><?=$content?></textarea>
        </div>

        <?php include "../util/timepicker.html"; ?>

        <div class="form-group col-12 mt-4">
            <label for="assignmentExt">Available extensions</label>
            <div id="extList" class="badge-list"></div>
            <input type="text" class="form-control" style="display:inline-block;width:200px;" id="assignmentExt" placeholder="Extension">
        </div>

        <script>
            assignmentExt = new Set();
            function assignmentExtension() {
                ext = $("#assignmentExt").val().split(/,[ ]*|,/);
                ext = ext.map(x => x.toLowerCase());
                ext = Array.from(new Set(ext));

                tmp = "";
                ext.forEach(x => tmp += ('<span class="badge badge-primary">' + x + '</span>'));
                $("#extList").html(tmp);
            }

            $("#assignmentExt").bind("keyup change", function(e) {
                assignmentExtension();
            });
        </script>

        <?php
            if (isset($_GET["edit"])) {
                echo "<input type='hidden' value='" . $_GET["edit"] . "' id='edit'>";
            }
        ?>

        <div class="form-group col-12">
            <button type="submit" class="btn btn-primary">Submit assignment</button>
        </div>
        
    </div>
</form>


<script src="js/medium-editor.min.js"></script>

<script>
var editor = new MediumEditor('#assignmentContent', {
    toolbar: {
        buttons: ['bold', 'italic', 'underline', 'strikethrough', 'anchor', 'justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull', 'superscript', 'subscript', 'orderedlist', 'unorderedlist', 'pre', 'outdent', 'indent', 'h1', 'h2', 'h3'],
        static: true,
        sticky: true,
        updateOnEmptySelection:true
    },
    placeholder: {
        text: '',
    }    
});

$("")
</script>

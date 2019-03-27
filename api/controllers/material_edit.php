<?php
require_once "../util/auth.php";
require_once "../util/util.php";

loginRedirect();

$title = "";
$content = "";

if (isset($_GET["edit"])) {
    $editrow = sql_select_unique("SELECT * FROM materials WHERE materialid = ?",[$_GET["edit"]]);
    $title = $editrow["title"];
    $content = $editrow["content"];
}

$_SESSION["materialFiles"] = [];

?>
<link rel="stylesheet" href="css/medium-editor.min.css">
<link rel="stylesheet" href="css/medium-bootstrap.css">

<h2>Material</h2>
<div>
    <form id="materialForm">
        <div class="form-group">
            <label for="materialTitle">Title</label>
            <input type="text" class="form-control" id="materialTitle" placeholder="Title" value=<?="'" . $title . "'"?>>
        </div>
        <div class="form-group mt-4">
            <label for="materialContent">Content</label>
            <textarea class="medium-editor-textarea editable h-25" id="materialContent"><?=$content?></textarea>
        </div>

        <?php
            if (isset($_GET["edit"])) {
                echo "<input type='hidden' value='" . $_GET["edit"] . "' id='edit'>";
            }
        ?>

        <button type="submit" class="btn btn-primary">Submit material</button>
    </form>
</div>
<h3 class="mt-3">Files</h3>
<div>
    <form id="materialFileForm">

        <div class="form-group">
            <label for="materialFileTitle">Title</label>
            <input type="text" class="form-control" id="materialFileTitle" name="materialFileTitle" placeholder="Title">
        </div>

        <div class="custom-file my-2">
            <input type="file" class="custom-file-input" id="materialFile" name="materialFile">
            <label class="custom-file-label" for="materialFile">Choose file</label>
        </div>

        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
</div>
<div id="materialFileList" class="d-flex w-50 flex-column">

</div>

<script src="js/medium-editor.min.js"></script>

<script>
var editor = new MediumEditor('#materialContent', {
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
</script>

<?php


?>
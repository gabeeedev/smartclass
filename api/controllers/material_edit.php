<?php
require_once "../util/auth.php";
require_once "../util/util.php";
require_once "../util/editor.php";

loginRedirect();

$title = "";
$content = "";

if (isset($_GET["edit"])) {
    $editrow = sql_select_unique("SELECT * FROM materials WHERE materialId = ?",[$_GET["edit"]]);
    $title = $editrow["title"];
    $content = $editrow["content"];
}

$_SESSION["materialFiles"] = [];

?>

<h2>Material</h2>
<form id="materialForm">
<div class="row">
        <div class="form-group col-12">
            <label for="materialTitle">Title</label>
            <input type="text" class="form-control" id="materialTitle" placeholder="Title" value=<?="'" . $title . "'"?>>
        </div>
        <div class="col-12">
            <label for="materialContent">Content</label>
        </div>
            <?php
                generateEditor($content,"materialContent");
            ?>
            <!-- <textarea class="medium-editor-textarea editable h-25" id="materialContent"></textarea> -->

        <?php
            if (isset($_GET["edit"])) {
                echo "<input type='hidden' value='" . $_GET["edit"] . "' id='edit'>";
            }
        ?>
        <div class="form-group col-12">
            <button type="submit" class="btn btn-primary">Submit material</button>
        </div>
    </div>
</form>
<h3 class="mt-3">Files</h3>
    <form id="materialFileForm">
    <div class="row">
        <div class="form-group col-12">
            <label for="materialFileTitle">Name (Leave it empty to use file name)</label>
            <input type="text" class="form-control" id="materialFileTitle" name="materialFileTitle" placeholder="Name">
        </div>

        <div class="form-group col-12">
            <div class="custom-file my-2">
                <input type="file" class="custom-file-input" id="materialFile" name="materialFile">
                <label class="custom-file-label" for="materialFile">Choose file</label>
            </div>
        </div>

        <div class="form-group col-12">
            <button type="submit" class="btn btn-primary">Upload</button>            
        </div>
    </div>
    </form>
<div id="materialFileList" class="d-flex w-resp flex-column">

</div>

<?php


?>
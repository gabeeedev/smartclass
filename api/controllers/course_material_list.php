<?php
require_once "../util/course.php";
require_once "../util/util.php";
require_once "../util/timepicker.php";

loginRedirect();

if(asTeacher()) {

    $sharableMaterials = sql_select("SELECT * FROM materials WHERE author = ?",[$_SESSION["user"]["userId"]]);
    
    ?>        
        <form id="materialShareForm">
            <div class="col-main">            
                <div class="form-group col-12">
                    <label for="materialShare">Material</label>
                    <select class="form-control" id="materialShare">
                        <?php
                            foreach($sharableMaterials as $row) {
                                echo "<option value='" . $row["materialId"] . "'>" . $row["title"] . "</option>";
                            }
                        ?>
                    </select>
                </div>
                <?php generateTimePicker(); ?>
                
                <div class="mb-4 col-12">
                    <button type="submit" class="btn btn-primary px-4">Share</button>
                </div>
            </div>
        </form>
    <?php
}
?>
<h2>Materials</h2>
<div class="w-100 p-2 icon-48">
    <i class="material-icons cursor-pointer list-changer" list-to="f-box">
    view_module
    </i>
    <i class="material-icons cursor-pointer list-changer" list-to="f-row">
    view_stream
    </i>
    <i class="material-icons cursor-pointer list-changer" list-to="">
    view_quilt
    </i>
</div>
<?php

    $course = $_SESSION["course"]["id"];
    $materials = sql_select("SELECT * FROM materials m, material_shared ms WHERE ms.material = m.materialId AND ms.course = ? AND m.status = 0 ORDER BY status, materialId DESC",[$course]);

?>
<div class="w-100 d-flex flex-wrap list-changeable" list-style="f-box">
    <?php
        foreach($materials as $row) {
            ?>
            <div class="f-box p-2">
                <?php
                    $block_class = "block p-3 rounded d-flex flex-row";
                ?>
                <div class=<?='"' . $block_class . '"'?> >
                    <div class="font-weight-bold clickable flex-max mr-4" content="course_material" contentOptions=<?="id:" . $row["materialId"]?>>
                        <?=$row["title"]?>
                    </div>
                </div>
            </div>
                
            <?php
        }
    ?>
</div>

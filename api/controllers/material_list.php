<?php
require_once "../util/auth.php";
require_once "../util/util.php";

loginRedirect();
$materials = sql_select("SELECT * FROM materials WHERE author = ? ORDER BY status, materialId DESC",[$_SESSION["user"]["userId"]]);
?>
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
<div class="w-100 d-flex flex-wrap list-changeable" list-style="f-box">

    <div class="f-box p-2">
        <div class="block clickable p-3 rounded d-flex flex-row" content="material_edit">
            <div class="font-weight-bold flex-max mr-4">Add new material</div>
            <i class="material-icons flex-static mx-1">add_circle</i>
        </div>
    </div>

    <?php
        foreach($materials as $row) {
            ?>
            <div class="f-box p-2">
                <?php
                    $block_class = "block p-3 rounded d-flex flex-row";
                    if($row["status"] == E_ARCHIVED)
                        $block_class .= " archived";
                ?>
                <div class=<?='"' . $block_class . '"'?> >
                    <div class="font-weight-bold clickable flex-max mr-4" content="material" contentOptions=<?="id:" . $row["materialId"]?>>
                        <?=$row["title"]?>
                    </div>
                    <i class="material-icons flex-static mx-1 clickable" content="material_edit" contentOptions=<?="edit:" . $row["materialId"]?>>edit</i>
                    <i class="material-icons flex-static mx-1 clickable" archive_popup="<?=$row["title"]?>" archive_service="material_archive" archive_id="<?=$row["materialId"]?>">archive</i>
                    <i class="material-icons flex-static mx-1 clickable" delete_popup="<?=$row["title"]?>" delete_service="material_delete" delete_id="<?=$row["materialId"]?>">delete</i>
                </div>
            </div>
                
            <?php
        }
    ?>
</div>
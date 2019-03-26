<?php
require_once "../util/auth.php";
require_once "../util/util.php";

loginRedirect();
// echo "dfsd";
$materials = sql_select("SELECT * FROM materials WHERE author = ? ORDER BY status, materialid DESC",[$_SESSION["user"]["userid"]]);
// printArray($materials);
// printArray($_SESSION);
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
        <div class="block clickable p-3 rounded d-flex flex-row" redirect="material_edit" target="#content">
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
                    <div class="font-weight-bold clickable flex-max mr-4" redirect="material" target="#content" options=<?="id:" . $row["materialid"]?>>
                        <?=$row["title"]?>
                    </div>
                    <i class="material-icons flex-static mx-1 clickable" redirect="material_edit" target="#content" options=<?="edit:" . $row["materialid"]?>>edit</i>
                    <i class="material-icons flex-static mx-1 clickable">archive</i>
                    <i class="material-icons flex-static mx-1 clickable">delete</i>
                </div>
            </div>
                
            <?php
        }
    ?>
</div>
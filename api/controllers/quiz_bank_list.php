<?php
require_once "../util/auth.php";
require_once "../util/util.php";

loginRedirect();
$banks = sql_select("SELECT * FROM quiz_banks WHERE author = ? ORDER BY bankId DESC",[$_SESSION["user"]["userId"]]);
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
        <div class="block clickable p-3 rounded d-flex flex-row" content="quiz_bank_edit">
            <div class="font-weight-bold flex-max mr-4">Add new question bank</div>
            <i class="material-icons flex-static mx-1">add_circle</i>
        </div>
    </div>

    <?php
        foreach($banks as $row) {
            ?>
            <div class="f-box p-2">
                <?php
                    $block_class = "block p-3 rounded d-flex flex-row";
                ?>
                <div class=<?='"' . $block_class . '"'?> >
                    <div class="font-weight-bold clickable flex-max mr-4" content="quiz_bank" contentOptions=<?="id:" . $row["bankId"]?>>
                        <?=$row["title"]?>
                    </div>
                    <i class="material-icons flex-static mx-1 clickable" delete_popup="<?=$row["title"]?>" delete_service="quiz_bank_delete" delete_id="<?=$row["bankId"]?>">delete</i>
                </div>
            </div>
                
            <?php
        }
    ?>
</div>
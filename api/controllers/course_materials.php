<?php
require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();

if(asTeacher()) {

    $sharableMaterials = sql_select("SELECT * FROM materials WHERE author = ?",[$_SESSION["user"]["userid"]]);
    
    ?>
        <h2>Share material</h2>
        <form id="materialShareForm">
            <div class="row">
                <div class="form-group col-12">
                    <label for="materialShare">Material</label>
                    <select class="form-control" id="materialShare">
                        <?php
                            foreach($sharableMaterials as $row) {
                                echo "<option value='" . $row["materialid"] . "'>" . $row["title"] . "</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="mb-2 col-12 text-center">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-dark datepicker-quick" datepicker-cmd="prev">-</button>
                        <button type="button" class="btn btn-dark datepicker-quick" datepicker-cmd="day">This day</button>
                        <button type="button" class="btn btn-dark datepicker-quick" datepicker-cmd="week">This week</button>
                        <button type="button" class="btn btn-dark datepicker-quick" datepicker-cmd="month">This month</button>
                        <button type="button" class="btn btn-dark datepicker-quick" datepicker-cmd="year">This year</button>
                        <button type="button" class="btn btn-dark datepicker-quick" datepicker-cmd="next">+</button>
                    </div>
                </div>
                <div class="form-group col-6">
                    <label for="fromPicker">Available from</label>
                    <input type="text" class="form-control datetimepicker-input" id="fromPicker" data-toggle="datetimepicker" data-target="#fromPicker"/>
                </div>
                <div class="form-group col-6">
                    <label for="toPicker">Available to</label>
                    <input type="text" class="form-control datetimepicker-input" id="toPicker" data-toggle="datetimepicker" data-target="#toPicker"/>
                </div>
                <div class="mb-4 col-12">
                    <button type="submit" class="btn btn-primary px-4">Share</button>
                </div>
                
            </div>
            
            
           
            <!-- <div class="f-static p-2">
                <button type="submit" class="btn btn-primary">Share</button>
            </div> -->
            
        </form>      

        <script>
            options = {
                sideBySide:true,
                format:"YYYY-MM-DD HH:mm"
            };

            $(function() {
                $("#fromPicker").datetimepicker(options);
                $("#toPicker").datetimepicker(options);
            });

            $(".datepicker-quick").click(function() {
                switch ($(this).attr("datepicker-cmd")) {
                    case "day":
                        $("#fromPicker").datetimepicker("date",moment().startOf("day"));
                        $("#toPicker").datetimepicker("date",moment().endOf("day"));
                        break;
                    case "week":
                        $("#fromPicker").datetimepicker("date",moment().startOf("week"));
                        $("#toPicker").datetimepicker("date",moment().endOf("week"));
                        break;
                    case "month":
                        $("#fromPicker").datetimepicker("date",moment().startOf("month"));
                        $("#toPicker").datetimepicker("date",moment().endOf("month"));
                        break;
                    case "year":
                        $("#fromPicker").datetimepicker("date",moment().startOf("year"));
                        $("#toPicker").datetimepicker("date",moment().endOf("year"));
                        break;                
                    case "next":
                        var to = moment($("#toPicker").datetimepicker("date"));
                        var from = moment($("#fromPicker").datetimepicker("date"));
                        $("#fromPicker").datetimepicker("date",from.add(1,"days"));
                        $("#toPicker").datetimepicker("date",to.add(1,"days"));
                        break;                
                    case "prev":
                        var to = moment($("#toPicker").datetimepicker("date"));
                        var from = moment($("#fromPicker").datetimepicker("date"));
                        $("#fromPicker").datetimepicker("date",from.add(-1,"days"));
                        $("#toPicker").datetimepicker("date",to.add(-1,"days"));
                        break;                
                    default:
                        break;
                }
            });
        </script>
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
    $materials = sql_select("SELECT * FROM materials m, material_shared ms WHERE ms.material = m.materialid AND ms.course = ? AND m.status = 0 ORDER BY status, materialid DESC",[$course]);

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
                    <div class="font-weight-bold clickable flex-max mr-4" redirect="material" target="#content" options=<?="id:" . $row["materialid"]?>>
                        <?=$row["title"]?>
                    </div>
                </div>
            </div>
                
            <?php
        }
    ?>
</div>

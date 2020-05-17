<?php
function generateTimePicker($from = "",$till = "",$fromId = "fromPicker",$toId = "toPicker") {

?>
<div class="d-flex flex-wrap flex-fill">
    <div class="mb-2 mt-4 col-12 text-center">
        <!-- <div class="btn-group" role="group"> -->
            <button type="button" class="btn btn-danger datepicker-quick" datepicker-cmd="prev" datepicker-unit="w">-W</button>
            <button type="button" class="btn btn-danger datepicker-quick" datepicker-cmd="prev" datepicker-unit="d">-D</button>
            <button type="button" class="btn btn-primary datepicker-quick" datepicker-cmd="day">This day</button>
            <button type="button" class="btn btn-primary datepicker-quick" datepicker-cmd="week">This week</button>
            <button type="button" class="btn btn-primary datepicker-quick" datepicker-cmd="month">This month</button>
            <button type="button" class="btn btn-primary datepicker-quick" datepicker-cmd="year">This year</button>
            <button type="button" class="btn btn-success datepicker-quick" datepicker-cmd="next" datepicker-unit="d">+D</button>
            <button type="button" class="btn btn-success datepicker-quick" datepicker-cmd="next" datepicker-unit="w">+W</button>
        <!-- </div> -->
    </div>
    <div class="form-group col-xl-6 col-sm-12">
        <label for="<?=$fromId?>">Available from</label>
        <input type="text" class="form-control datetimepicker-input" id="<?=$fromId?>" autocomplete="off" value="<?=$from?>" data-toggle="datetimepicker" data-target="#<?=$fromId?>"/>
    </div>
    <div class="form-group col-xl-6 col-sm-12">
        <label for="<?=$toId?>">Available till</label>
        <input type="text" class="form-control datetimepicker-input" id="<?=$toId?>" autocomplete="off" value="<?=$till?>" data-toggle="datetimepicker" data-target="#<?=$toId?>"/>
    </div>
</div>

<script>

    fromId = "#<?=$fromId?>";
    toId = "#<?=$toId?>";

    options = {
        sideBySide:true,
        format:"YYYY-MM-DD HH:mm",
        useCurrent:false
    };

    $(function() {
        $(fromId).datetimepicker(options);
        $(toId).datetimepicker(options);

        <?php

            if (strlen($from) > 0) {
                echo '$(fromId).data("datetimepicker").date("' . $from . '");';
            }
            if (strlen($till) > 0) {
                echo '$(toId).data("datetimepicker").date("' . $till . '");';
            }

        ?>

        $(fromId).on("change.datetimepicker", function (e) {
            $(toId).datetimepicker("minDate",e.date);
        });
        $(toId).on("change.datetimepicker", function (e) {
            $(fromId).datetimepicker("maxDate",e.date);
        });
    });

    $(".datepicker-quick").click(function() {
        switch ($(this).attr("datepicker-cmd")) {
            case "day":
                $(fromId).datetimepicker("date",moment().startOf("day"));
                $(toId).datetimepicker("date",moment().endOf("day"));
                break;
            case "week":
                $(fromId).datetimepicker("date",moment().startOf("isoweek"));
                $(toId).datetimepicker("date",moment().endOf("isoweek"));
                break;
            case "month":
                $(fromId).datetimepicker("date",moment().startOf("month"));
                $(toId).datetimepicker("date",moment().endOf("month"));
                break;
            case "year":
                $(fromId).datetimepicker("date",moment().startOf("year"));
                $(toId).datetimepicker("date",moment().endOf("year"));
                break;                
            case "next":
                var to = moment($(toId).datetimepicker("date"));
                var from = moment($(fromId).datetimepicker("date"));
                var unit = $(this).attr("datepicker-unit");
                $(toId).datetimepicker("date",to.add(1,unit));
                $(fromId).datetimepicker("date",from.add(1,unit));
                break;                
            case "prev":
                var from = moment($(fromId).datetimepicker("date"));
                var to = moment($(toId).datetimepicker("date"));
                var unit = $(this).attr("datepicker-unit");
                $(fromId).datetimepicker("date",from.add(-1,unit));
                $(toId).datetimepicker("date",to.add(-1,unit));
                break;                
            default:
                break;
        }
    });

</script>

<?php
}
?>
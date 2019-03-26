<?php
require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();

if(asTeacher()) {

    $data = sql_select("SELECT * FROM materials WHERE author = ?",[$_SESSION["user"]["userid"]]);

    

    ?>

        <form id="materialShareForm">
            <div class="d-flex flex-wrap flex-row">                
                    <div class="form-group f-box p-2">
                        <label for="materialShare">Material</label>
                        <select class="form-control" id="materialShare">
                            <?php
                                foreach($data as $row) {
                                    echo "<option value='" . $row["materialid"] . "'>" . $row["title"] . "</option>";
                                }
                            ?>
                        </select>
                    </div>

                    <div class="form-group f-box p-2">
                        <label for="fromPicker">Available from</label>
                        <input type="text" class="form-control" id="fromPicker">
                    </div>
                    <div class="form-group f-box p-2">
                        <label for="toPicker">Available from</label>
                        <input type="text" class="form-control" id="toPicker">
                    </div>
                    
                    
            </div>  
            <div class="f-static p-2">
                <button type="submit" class="btn btn-primary">Share</button>
            </div>
            
        </form>      

        <script>
            $(function() {
                $("#fromPicker").datepicker();
                $("#toPicker").datepicker();
            });
        </script>
    <?php
}

?>


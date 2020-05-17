<?php
require_once "../util/course.php";
require_once "../util/util.php";
require_once "../util/timepicker.php";
require_once "../util/editor.php";

loginRedirect();

if(asTeacher()) {

    $quizBanks = sql_select("SELECT * FROM quiz_banks WHERE author = ?",[$_SESSION["user"]["userId"]]);
    
    ?>
        <h2>Create quiz</h2>
        
        <form id="quizForm">
            <div class="col-main">   
                <div class="form-group col-12">
                    <label for="quizBank">Quiz bank</label>
                    <select class="form-control" id="quizBank">
                        <?php
                            foreach($quizBanks as $row) {
                                echo "<option value='" . $row["bankId"] . "'>" . $row["title"] . "</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-12">
                    <label for="quizTitle">Title</label>
                    <input type="text" class="form-control" id="quizTitle" placeholder="Title">
                </div>
                <div class="col-12">
                    <label for="quizDescription">Description</label>
                </div>
                <?php generateEditor("","quizDescription"); ?>
                <?php generateTimePicker("","","quizFrom","quizTill"); ?>
                
                <div class="form-group col-3">
                    <label for="quizQuestionCount">Number of questions <small>(Randomly selected from the bank)</small></label>
                    <input type="number" class="form-control" id="quizQuestionCount" placeholder="Number of questions">
                </div>
                <div class="w-100"></div>
                <div class="form-group col-3">
                    <label for="quizLength">Length <small>(In minutes)</small></label>
                    <input type="number" class="form-control" id="quizLength" placeholder="Length">
                </div>
                <div class="w-100"></div>

                <div class="form-check col-12 mb-4">
                    <input type="checkbox" value="" id="quizRandomizeQuestions">
                    <label class="form-check-label" for="quizRandomizeQuestions">
                        Randomize order of questions
                    </label>
                </div>

                <div class="form-check col-12 mb-4">
                    <input type="checkbox" value="" id="quizRandomizeAnswers">
                    <label class="form-check-label" for="quizRandomizeAnswers">
                        Randomize order of answers <small>(if possible)</small>
                    </label>
                </div>
                
                <div class="mb-4 col-12">
                    <button type="submit" class="btn btn-primary px-4">Create</button>
                </div>
            </div>
        </form>
    <?php
}
?>
<?php

require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();

$quizId = $_GET["id"];

$quiz = sql_select_unique("SELECT *,(availableFrom < CURRENT_TIMESTAMP AND availableTo > CURRENT_TIMESTAMP) available FROM quizes WHERE quizId = ? AND course = ?",[$quizId,$_SESSION["course"]["id"]]);

if ($quiz === false) {
    exit();
}

if (asTeacher()) {
    $filled = sql_select("SELECT * FROM quiz_fills, users WHERE quiz = ? AND userId = user AND finishTime IS NOT NULL ORDER BY name",[$quizId]);
    ?>  

        <div class="row w-resp mx-auto">
            <div class="col-12 text-center">
                <h1><?=$quiz["title"]?></h1>
            </div>

            <div class="form-group col-12">
                <label for="quizFillStudent">Select student</label>
                <select class="form-control" id="quizFillStudent">
                    <?php
                        foreach($filled as $row) {
                            echo "<option value='" . $row["quizFillId"] . "'>" . $row["name"] . "</option>";
                        }
                    ?>
                </select>
            </div>

            <div id="quizFilled" class="col-12 mt-3">
                
            </div>
        </div>

        <script>
            quizGetFilled();
        </script>

    <?php
}

if (asStudent()) {
    ?>
        <div class="row w-resp mx-auto">
        <div class="col-12 text-center">
            <h1><?=$quiz["title"]?></h1>
        </div>
    <?php
    if ($quiz["available"]) {
        $fill = sql_select_unique("SELECT * FROM quiz_fills WHERE quiz = ? AND user = ?",[$quizId,$_SESSION["user"]["userId"]]);
        ?>
            <div class="col-12">
            <h4>Description</h4>
            </div>
            <div class="col-12">
                <p><?=$quiz["description"]?></p>
            </div>
        <?php

        if ($fill["startTime"] === NULL) {
            ?>
                <div class="col-12">
                    <h4>Length</h4>
                </div>
                <div class="col-12">
                    <p><?=$quiz["length"]?> minutes</p>
                </div>
                <div class="col-12 text-center">
                    <button class="btn btn-primary px-4" id="quizBegin" quizId="<?=$quizId?>">Begin quiz</button>
                </div>
                
            <?php
            
        } else {
            if ($fill["finishTime"] === NULL && timeDiff(getCurrentTime(),$fill["startTime"]) < $quiz["length"]*60) {
                ?> 
                    <div class="col-12 text-center">
                        <h4 timer="<?=timeDiff($fill["startTime"],getCurrentTime())+$quiz["length"]*60?>"></h4>
                    </div>
                    <div class="col-12 mt-3"><form id="quizFillForm" quizId="<?=$quizId?>">
                <?php
                
                $questions = sql_select("SELECT * FROM quiz_answers, quiz_questions WHERE quizFillId = ? AND qid = questionId",[$fill["quizFillId"]]);


                foreach($questions as $question) {
                    $data = json_decode($question["question"],true);
                    ?>
                        <div quiz-answer qid="<?=$question["qid"]?>" type="<?=$data["type"]?>" class='block px-3 pt-3 mb-4'>
                        <div>
                            <h4><?=$data["question"]?></h4>
                        </div>
                    <?php

                    switch ($data["type"]) {
                        case "text":
                            ?>
                                <div class="form-group">
                                    <label>Answer</label>
                                    <input type="text" class="form-control"></input>
                                </div>
                            <?php
                            break;
                        case "number":
                            ?>
                                <div class="form-group">
                                    <label>Answer</label>
                                    <input type="number" class="form-control"></input>
                                </div>
                            <?php
                            break;
                        case "choice":
                            foreach($data["answers"] as $index => $answer) {
                                ?>
                                    <div class="form-check">
                                        <input type="radio" name="qr<?=$question["qid"]?>" value="<?=$index?>" class="form-check-input">
                                        <label><?=$answer?></label>
                                    </div>
                                <?php
                            }
                            break;
                        case "multichoice":
                            foreach($data["answers"] as $index => $answer) {
                                ?>
                                    <div class="form-check">
                                        <input type="checkbox" name="qr<?=$question["qid"]?>" value="<?=$index?>" class="form-check-input">
                                        <label><?=$answer?></label>
                                    </div>
                                <?php
                            }
                            break;
                    }

                    ?>
                        </div>
                        
                    <?php
                }

                ?>
                        <div class="form-group text-center">
                            <button class="btn btn-primary px-4 py-2" type="submit">Finish</button>
                        </div>
                    </form></div> 
                <?php

            }
        }

        
    } else {

    }
    ?>
        </div>
    <?php
}
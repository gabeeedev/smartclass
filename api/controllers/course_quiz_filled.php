<?php

require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();

$quizFillId = $_GET["quizFillId"];

$answers = sql_select("SELECT * FROM quiz_answers, quiz_questions WHERE quizFillId = ? AND qid = questionId",[$quizFillId]);

foreach($answers as $row) {
        $question = json_decode($row["question"],true);
        $answer = json_decode($row["answer"],true);
    ?>
        <div class='block px-3 py-3 mb-4'>
        <div>
            <h4><?=$question["question"]?></h4>
        </div>

        <?php
            switch ($question["type"]) {
                case "text":
                case "number":
                    ?>
                        <div>
                            <div><?=$answer?></div>
                        </div>
                    <?php
                    break;
                case "choice":
                    ?>
                        <div>
                            <div><?=$question["answers"][$answer]?></div>
                        </div>
                    <?php
                    break;
                case "multichoice":
                    echo "<div>";
                    foreach($answer as $i){
                        echo "<div>" . $question["answers"][$i] . "</div>";
                    }
                    echo "</div>";

                    ?> </div> <?php

                    break;
                default:
                    # code...
                    break;
            }
        ?>

        </div>
    <?php
}


?>
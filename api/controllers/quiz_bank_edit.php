<?php
require_once "../util/auth.php";
require_once "../util/util.php";
require_once "../util/editor.php";

loginRedirect();

?>

<form id="bankForm">
    <div class="row w-resp mx-auto">
        <div class="col-12 text-center">
            <h2>New question bank</h2>
        </div>
        <div class="form-group col-12">
            <label for="bankTitle">Title</label>
            <input type="text" class="form-control" id="bankTitle" placeholder="Title">
        </div>
        <div class="col-12 text-center">
            <h3>Questions</h3>
            <hr>
        </div>
        <div id="questionList" class="col-12 mt-3">
        
        </div>
        <div class="col-12 mb-4 text-center">
        <hr>
            <h4 class="mr-2">Add new question</h4>
            <div class="btn-group w-100" role="group">
                <button type="button" class="btn btn-normal" newQuizQuestion="text">Text</button>
                <button type="button" class="btn btn-normal" newQuizQuestion="number">Number</button>
                <button type="button" class="btn btn-normal" newQuizQuestion="choice">Choice</button>
                <button type="button" class="btn btn-normal" newQuizQuestion="multichoice">Multiple choice</button>
            </div>
        </div>
        <div class="form-group col-12 mt-4 text-center">
            <button type="submit" class="btn btn-primary"><b>Create question bank</b></button>
        </div>
        </div>
    </div>
</form>

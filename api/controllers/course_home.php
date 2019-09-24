<?php

require_once "../util/auth.php";
require_once "../util/util.php";

loginRedirect();

?>

<h1><b><?=$_SESSION["course"]["data"]["title"]?></b></h1>

<div class="w-50 d-flex flex-wrap">

<div class="f-row p-2">
    <div class="block p-3 rounded d-flex flex-column">
        <h3>New post</h3>
        <form id="postForm">
            <div class="form-group mt-4">
                <textarea class="medium-editor-textarea editable w-100" id="postContent"></textarea>
            </div>
            <div class="d-flex flex-row">
                <button type="submit" class="btn btn-primary ml-auto">Post</button>
            </div>
        </form>
    </div>
</div>

<?php

    $posts = sql_select("SELECT u.name, p.postDate, p.content, p.postid FROM posts p, users u WHERE p.user = u.userid AND p.course = ? ORDER BY p.postDate DESC",[$_SESSION["course"]["id"]]);

    foreach($posts as $row) {
        ?>
        <div class="f-row p-2">
            <div class="block p-3 rounded d-flex flex-column">
                <div class="d-flex flex-row pb-2">
                    <div class="d-flex">
                        <b><?=$row["name"]?></b>
                    </div>
                    <div class="d-flex ml-auto">
                        <b><?=$row["postDate"]?></b>
                    </div>
                </div>
                <div class="d-flex">
                    <?=$row["content"]?>
                </div>                
                    <form class="commentForm">
                        <div class="d-flex flex-row mt-4">
                            <div class="d-flex w-100 pr-2">
                                <textarea class="comment w-100" id="commentContent"></textarea>
                            </div>
                            <div><button type="submit" class="btn btn-primary ml-auto">Comment</button></div>
                        </div>
                    </form>
            </div>
        </div>
            
        <?php
    }
?>
</div>
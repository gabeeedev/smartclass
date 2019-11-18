<?php

require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();

?>



<div class="w-50 d-flex flex-wrap m-auto">
<h1><b><?=$_SESSION["course"]["data"]["title"]?></b></h1>
<div class="f-row p-2">
    <div class="post-block p-3 rounded d-flex flex-column">
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
        <div class="f-row p-2 pt-4">
            <div class="post-block p-3 rounded d-flex flex-column">
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
                <form class="commentForm" postId="<?=$row["postid"]?>">
                    <div class="d-flex flex-row mt-4">
                        <div class="d-flex w-100 pr-2">
                            <textarea class="comment w-100 resize-textarea"></textarea>
                        </div>
                        <div><button type="submit" class="btn btn-primary ml-auto">Comment</button></div>
                    </div>
                </form>
                <?php
                    $comments = sql_select("SELECT u.name, c.postDate, c.content FROM comments c, users u WHERE c.user = u.userid AND c.post = ? ORDER BY c.postDate DESC",[$row["postid"]]);
                    foreach ($comments as $com) {
                        ?>
                            <div class="mt-4">
                                <div class="d-flex flex-row pb-1">
                                    <div class="d-flex font-italic small">
                                        <b><?=$com["name"]?></b>
                                    </div>
                                    <div class="d-flex ml-auto font-italic small">
                                        <?=$com["postDate"]?>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <?=$com["content"]?>
                                </div>  
                            </div>
                        <?php
                    }
                ?>
            </div>
        </div>
            
        <?php
    }
?>
</div>
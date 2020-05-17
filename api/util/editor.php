<?php
function generateEditor($content = "", $id = "textEditor") {
?>

<div class="col-12 mb-1">
  <div class="btn-group" role="group">
    <button type="button" class="btn btn-primary btn-editor" editorType="simple" editorCmd="formatblock" editorAttr="div"><span><b>T</b></span></button>
    <button type="button" class="btn btn-primary btn-editor" editorType="simple" editorCmd="formatblock" editorAttr="h1"><span style="font-size:large;"><b>H1</b></span></button>
    <button type="button" class="btn btn-primary btn-editor" editorType="simple" editorCmd="formatblock" editorAttr="h2"><span style="font-size:medium;"><b>H2</b></span></button>
    <button type="button" class="btn btn-primary btn-editor" editorType="simple" editorCmd="formatblock" editorAttr="h3"><span style="font-size:small;"><b>H3</b></span></button>
    <button type="button" class="btn btn-primary btn-editor" editorType="simple" editorCmd="bold"><span><b>B</b></span></button>
    <button type="button" class="btn btn-primary btn-editor" editorType="simple" editorCmd="italic"><span><i>I</i></span></button>
    <button type="button" class="btn btn-primary btn-editor" editorType="simple" editorCmd="underline"><span><u>U</u></span></button>
    <button type="button" class="btn btn-primary btn-editor" editorType="link"><span><i class="material-icons" style="vertical-align: middle;">link</i></span></button>
    <button type="button" class="btn btn-primary btn-editor" editorType="simple" editorCmd="justifyleft"><span><i class="material-icons" style="vertical-align: middle;">format_align_left</i></span></button>
    <button type="button" class="btn btn-primary btn-editor" editorType="simple" editorCmd="justifycenter"><span><i class="material-icons" style="vertical-align: middle;">format_align_center</i></span></button>
    <button type="button" class="btn btn-primary btn-editor" editorType="simple" editorCmd="justifyright"><span><i class="material-icons" style="vertical-align: middle;">format_align_right</i></span></button>
    <button type="button" class="btn btn-primary btn-editor" editorType="simple" editorCmd="justifyfull"><span><i class="material-icons" style="vertical-align: middle;">format_align_justify</i></span></button>
    <button type="button" class="btn btn-primary btn-editor" editorType="simple" editorCmd="insertunorderedlist"><span><i class="material-icons" style="vertical-align: middle;">format_list_bulleted</i></span></button>
    <button type="button" class="btn btn-primary btn-editor" editorType="simple" editorCmd="insertorderedlist"><span><i class="material-icons" style="vertical-align: middle;">format_list_numbered</i></span></button>
    <button type="button" class="btn btn-primary btn-editor" editorType="simple" editorCmd="formatblock" editorAttr="pre"><span style="font-size:small;"><b>C</b></span></button>
  </div>
</div>
<div class="col-12 mb-4">
  <div contenteditable="true" class="form-control geditor" id="<?=$id?>">
    <?php
      echo $content;
    ?>
  </div>
</div>

<?php } ?>
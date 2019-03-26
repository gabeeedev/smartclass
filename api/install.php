<?php

require_once "util/util.php";


if (isset($_POST["install"])) {
    if (checkPostData([
        "mysqlAddress","mysqlUsername","mysqlDatabase",
        "adminUsername","adminEmail","adminName","adminPassword"])) 
    {
        $sql = file_get_contents("install.sql");
        $sql = str_replace("`database`.`","`" . $_POST['mysqlDatabase'] . "`.`" . $_POST['mysqlPrefix'] . "_",$sql);

        $config = fopen("util/config.php","w+");
        writeConfig($config,$_POST);
    }
} else {

?>

<link rel="stylesheet" href="css/themes/light.css">
<div class="flex-center">
    <div class="login-form">
        <form id="installForm">
            <div class="form-group">
                <input type="text" class="form-control form-simple" id="mysqlAddress" placeholder="MySQL address">
            </div>
            <div class="form-group">
                <input type="text" class="form-control form-simple" id="mysqlUsername" placeholder="MySQL username">
            </div>
            <div class="form-group">
                <input type="text" class="form-control form-simple" id="mysqlPassword" placeholder="MySQL password">
            </div>
            <div class="form-group">
                <input type="text" class="form-control form-simple" id="mysqlDatabase" placeholder="MySQL database">
            </div>
            <div class="form-group">
                <input type="text" class="form-control form-simple" id="mysqlPrefix" placeholder="MySQL table prefix">
            </div>
            <div class="form-group">
                <input type="text" class="form-control form-simple" id="adminUsername" placeholder="Admin username">
            </div>
            <div class="form-group">
                <input type="text" class="form-control form-simple" id="adminEmail" placeholder="Admin email">
            </div>
            <div class="form-group">
                <input type="text" class="form-control form-simple" id="adminPassword" placeholder="Admin Password">
            </div>
            <div class="form-group">
                <input type="text" class="form-control form-simple" id="adminName" placeholder="Admin name">
            </div>
            <button type="submit" class="btn btn-login">Install</button>
        </form>
    </div>
</div>

<script>

    $("#installForm").submit(function(e) {
        e.preventDefault();
        data = getFormInputs("installForm");
        data.install = true;
        $.post("api/install.php",data,function(data) {
            console.log(data);
        });
    });

</script>

<?php

}

?>


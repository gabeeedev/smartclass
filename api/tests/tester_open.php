<?php 

    // require_once "/api/util/config.php";
    require_once "../util/util.php";
    

    // if(isset($testMode) && $testMode === true) { 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/themes/light.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <title>SClass</title>
</head>
<body>
    <div class="page">
        <div class="w-50 mx-auto mt-4">
            <?php 
            //include "api/controllers/developer_testing.php";
            require_once "../util/util.php";
    $dir = scandir("./");

    foreach($dir as $file) {
        if (strpos($file,"test_") > -1) {
            require_once $file;
        }
    } 
            ?>
        </div>
    </div>
</body>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/script.js"></script>

</html>

<?php
    // } else {
    //     include("index.html");
    // }

    

?>
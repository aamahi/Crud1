<?php
require_once("function.php");
$info="";
$task=$_GET['task'] ?? "report";
$error=$_GET['error'] ?? "0";

if("delete"==$task){
    $id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_STRING);
    if($id>0){
        deleteStudent($id);
        header('location:/crud/index.php?task=report');
    }
}

if('seed'==$task){
    seed();
    $info ="Seeding is Compleate";
}
$fname='';
$lname='';
$roll='';
if(isset($_POST['save'])){
    $fname=filter_input(INPUT_POST,'fname',FILTER_SANITIZE_STRING);
    $lname=filter_input(INPUT_POST,'lname',FILTER_SANITIZE_STRING);
    $roll=filter_input(INPUT_POST,'roll',FILTER_SANITIZE_STRING);
    $id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_STRING);

 if($id){
     //update the exitsting student
    if ($fname!='' && $lname!='' && $roll!='') {
    $result=updateStudent($id,$fname,$lname,$roll);
    
    if($result){
        header('location:/crud/index.php?task=report');
    }
    else{
        $error=1;
    }
    }
    }else{
        //add a new student
        if ($fname!='' && $lname!='' && $roll!='') {
            $result = addStudent($fname,$lname,$roll);
            if($result){
                header('location:/crud/index.php?task=report');
            }
            else{
                $error=1;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="//cdn.rawgit.com/necolas/normalize.css/master/normalize.css">
    <link rel="stylesheet" href="//cdn.rawgit.com/milligram/milligram/master/dist/milligram.min.css">
   
    <title>Crud Project</title>
    <style>
        body{
            margin-top:30px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="column column-60 column-offset-20">
            <h2>Crud Project </h2>
            <p>A simple project to perform Curd oparation Using Plain File and PHP</p>
            <hr/>
            <?php
            include "nav.php";
            if($info!=""){
                 echo "<p>{$info}</p>";
             }
             ?>
        </div>
    </div>
    <?php 
        if("1"==$error):
    ?>
    <div class="row">
        <div class="column column-60 column-offset-20">
             <blockquote>
                Duplicate Roll number
             </blockquote>
        </div>
    </div>
    <?php 
        endif;
    ?>
    <?php 
        if("report"==$task):
    ?>
    <div class="row">
        <div class="column column-60 column-offset-20">
             <?php genarateReport() ?>
        </div>
    </div>
    <?php 
        endif;
    ?>
    <?php 
        if("add"==$task):
    ?>
    <div class="row">
        <div class="column column-60 column-offset-20">
             <form action="/crud/index.php?task=add" method="POST">
                <label for="fname">First Name</label>
                <input type="text" name="fname" id="fname" value="<?php echo $fname; ?>">
                <label for="lname">Last Name</label>
                <input type="text" name="lname" id="lname" value="<?php echo $lname;?>">
                <label for="roll">Roll</label>
                <input type="number" name="roll" id="roll" value="<?php echo $roll; ?>">
                <button type="submit" name="save">Save</button>
             </form>
        </div>
    </div>
<?php 
    endif;
?>
<?php 
    if("edit"==$task):
    $id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_STRING);
    $student = getStudent($id);
    if($student):
    ?>
    <div class="row">
        <div class="column column-60 column-offset-20">
             <form method="POST">
                <input type="hidden" name="id" value="<?php echo $id;?>">
                <label for="fname">First Name</label>
                <input type="text" name="fname" id="fname" value="<?php echo $student['fname']; ?>">
                <label for="lname">Last Name</label>
                <input type="text" name="lname" id="lname" value="<?php echo $student['lname'];?>">
                <label for="roll">Roll</label>
                <input type="number" name="roll" id="roll" value="<?php echo $student['roll']; ?>">
                <button type="submit" name="save">Update</button>
             </form>
        </div>
    </div>
    <?php 
        endif;
    endif;
    ?>
</div>
<script type="text/javascript" src="/crud/script.js"></script>
</body>
</html>
<?php
session_start();

if(!isset($_SESSION['history'])){
    $_SESSION['history']=array();
}

if(isset($_POST['num1'])){
    $num1 = $_POST['num1'];
}

if(isset($_GET['num1'])){
    $num1 = $_POST['num1'];
}

if(isset($_POST['num2'])){
    $num2 = $_POST['num2'];
}

if(isset($_GET['num2'])){
    $num2 = $_POST['num2'];
}

if(isset($_POST['oper'])){
    $oper = $_POST['oper'];
}

if(isset($_GET['oper'])){
    $oper = $_POST['oper'];
}


function suma($op1,$op2){
    array_push($_SESSION['history'],"". $op1 ."+" . $op2. " = ". $op1+$op2);
    return $op1 + $op2;
}

function resta($op1,$op2){
    array_push($_SESSION['history'],"". $op1 ."-" . $op2. " = ". $op1-$op2);
    return $op1 - $op2;
}

function multiplicar($op1,$op2){
    array_push($_SESSION['history'],"". $op1 ."x" . $op2. " = ". $op1*$op2);
     return $op1 * $op2;
}

function dividir($op1,$op2){
    array_push($_SESSION['history'],"". $op1 ."/" . $op2. " = ". $op1/$op2);
    return $op1 / $op2;
}
function potencia($op1,$op2){
    array_push($_SESSION['history'],"". $op1 ."^" . $op2. " = ". $op1**$op2);

    return $op1**$op2;
}

function calculate($op1,$op2,$type){
    switch ($type){
        case "plus":
            return suma($op1,$op2);
        case "minus":
            return resta($op1,$op2);
        case "times":
            return multiplicar($op1,$op2);
        case "divide":
            return dividir($op1,$op2);
        case "pot":
            return potencia($op1,$op2);

    }
}

?>
<?php foreach($_SESSION['history'] as $operacion):?>
<p><?= $operacion;?></p>
<?php endforeach;?>
<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
    <input type="number" name="num1" id="">
    <select name="oper" id="">
        <option value="plus">+</option>
        <option value="minus">-</option>
        <option value="times">x</option>
        <option value="pot">^</option>   
    </select>
    <input type="number" name="num2" id="">
    <p>
    <?php 
    if(isset($num1) && isset($num2) && isset($oper)){
        echo calculate($num1,$num2,$oper);
    }
    ?>
    </p>
    <input type="submit" value="Calcular">
</form>


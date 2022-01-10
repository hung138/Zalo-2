<?php
include 'dbCon.php';

function LogOut() {
    if(empty($_POST['tokken'])){
        Respone(1002, []); 
    } else {
        $token = $_POST['tokken'];
        $isA = isAuth($token);
        
        if($isA == 1){
            Respone(1000, []);
        } else{
            Respone(9998, []);
        }
    }
}

LogOut();
?>

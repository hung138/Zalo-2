<?php
include 'dbCon.php';

function LogIn() {
    if(empty($_POST['token']) || empty($_POST['admin_id'])){
        Respone(1002, []); 
    } else {
        $id = $_POST['admin_id'];
    
        $conn = connectt();
    
        $queryy = "Select * from user where id = '$id' and song = 0 ";
        $result = mysqli_query($conn, $queryy);
        
        if (mysqli_num_rows($result) == 0){
            // neu loi
            Respone(9995, []);
        } else{
            $row = mysqli_fetch_array($result);
            
            $db = [];
            $db['admin_id'] = $row['id'];
            $db['ten'] = $row['tenDN'];
            if($row['quyen'] == 0){
                $db['role'] = 'User binh thuong';
            }
            if($row['quyen'] == 1){
                $db['role'] = 'Xoa bai viet, binh luan';
            }
            if($row['quyen'] == 2){
                $db['role'] = 'Sua, xoa tai khoan, xoa bai viet, binh luan';
            }
            if($row['quyen'] == 3){
                $db['role'] = 'Co toan quyen, super admin';
            }
            $db['active'] = $row['song'];
            Respone(1000, $db);
        }
    }
}

LogIn();
?>
<?php

function connect() {
    $h = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'zalochat';
 
    $conn = mysqli_connect('localhost', 'root', '', 'zalochat') or die ('Loi ket noi');
    mysqli_set_charset($conn, "utf8");
    
    return $conn;
};

function SignUp() {
    if(empty($_POST['tenDK']) || empty($_POST['soDtDK']) || empty($_POST['passDK'])
            || empty($_POST['linkDK'])){
        echo 'Khong duoc de trong';
        die (); 
    } else {
        $username = $_POST['tenDK'];
        $sdt = $_POST['soDtDK'];
        $password = $_POST['passDK'];
        $avat = $_POST['linkDK'];
    
        $conn = connect();
    
        $queryy = "Select * from user where sdt = '$sdt'";
        $result = mysqli_query($conn, $queryy);
        
        if (mysqli_num_rows($result) > 0){
        // neu loi
         echo '<script language="javascript">alert("So dien thoai bi trung"); '
            . 'window.location="signup.php";</script>';
        die ();
        } else{
            $sql = "INSERT INTO user (id, tenDN, matkhau, sdt, linkAvatar, quyen) VALUES "
                . "('null', '$username', '$password', '$sdt', '$avat', '0')";
            
            if (mysqli_query($conn, $sql)){
                 echo '<script language="javascript">alert("Dang ki thanh cong"); '
         . 'window.location="login.php";</script>';
            } else {
                echo '<script language="javascript">alert("Co loi trong qua trinh xu ly"); '
            . 'window.location="signup.php";</script>';
            }
        }
    }
}

function LogIn() {
    if(empty($_POST['soDT']) || empty($_POST['passDN'])){
        echo 'Khong duoc de trong';
        die (); 
    } else {
        $sdt = $_POST['soDT'];
        $password = $_POST['passDN'];
    
        $conn = connect();
    
        $queryy = "Select * from user where sdt = '$sdt' and matkhau = '$password' and song = 0";
        $result = mysqli_query($conn, $queryy);
        
        if (mysqli_num_rows($result) == 0){
        // neu loi
         echo '<script language="javascript">alert("Thong tin khong dung"); '
         . 'window.location="login.php";</script>';
        die ();
        } else{
            $row = mysqli_fetch_array($result);
            $id = $row['id'];
            $name = $row['tenDN'];
            $quyen = $row['quyen'];
            
            $_SESSION['user-Id'] = $id;
            $_SESSION['username'] = $name;
            $_SESSION['user-level'] = $quyen;
            
            echo '<script language="javascript">alert("Dang nhap thanh cong"); '
         . 'window.location="home.php";</script>';
        }
    }
}

function LogOut() {
   session_destroy();
    echo 'Dang xuat thanh cong';
    exit();
}

function LayProfile(){
    $curr_id = $_SESSION['user-Id'];
    
    $conn = connect();
    
    $queryy = "Select * from user where id = '$curr_id'";
    $result = mysqli_query($conn, $queryy);
    
    //$data = array();
    if (mysqli_num_rows($result) > 0)
    {
        // neu ko loi
        $row = mysqli_fetch_array($result);
        echo json_encode($row);
    }
    else {
        // neu loi
        echo '<script language="javascript">alert("Loi, hay dang nhap lai"); '
         . 'window.location="login.php";</script>';
        die ();
    }
}

function XulyDoiMatKhau(){
    if(!empty($_POST['tenMoi']) && !empty($_POST['mkMoi']) && !empty($_POST['sdtMoi'])){
    $username   = $_POST['tenMoi'];
    $password   = $_POST['mkMoi'];
    $sdtM = $_POST['sdtMoi'];
    $ava = $_POST['avaMoi'];
    
    $curr_id = $_POST['idMoi'];
    $ht_id = $_SESSION['user-Id'];
    
    $conn = connect();
    
    $queryy = "Select * from user where sdt = '$sdtM' and id != '$curr_id'";
    $result = mysqli_query($conn, $queryy);
    
    if (mysqli_num_rows($result) > 0)
    {
        // neu loi  sdt bi trung
        echo 4;
    }
    else {
        // neu ko loi
        $sql = "Update user set tenDN = '$username', matkhau = '$password', sdt = '$sdtM', linkAvatar = '$ava' where id = '$curr_id'";
          
        if (mysqli_query($conn, $sql)){
            if($curr_id == $ht_id){
                $_SESSION['username'] = $username;
                echo 3;
            } else {
                echo 2;
            }
        }
        else {
            echo 1;
        }
    }
    
    } else{
        // neu trong
        echo 0;
    }
}

function DoiThongTin(){
    if(!empty($_POST['tenMoi']) && !empty($_POST['mkMoi']) && !empty($_POST['sdtMoi'])){
    $username   = $_POST['tenMoi'];
    $password   = $_POST['mkMoi'];
    $sdtM = $_POST['sdtMoi'];
    $ava = $_POST['avaMoi'];
    
    $curr_id = $_POST['idMoi'];
    $ht_id = $_SESSION['user-Id'];
    
    $conn = connect();
    
    $queryy = "Select * from user where sdt = '$sdtM' and id != '$curr_id'";
    $result = mysqli_query($conn, $queryy);
    
    if (mysqli_num_rows($result) > 0)
    {
        // neu loi  sdt bi trung
        echo 4;
    }
    else {
        // neu ko loi
        $sql = "Update user set tenDN = '$username', matkhau = '$password', sdt = '$sdtM', linkAvatar = '$ava' where id = '$curr_id'";
          
        if (mysqli_query($conn, $sql)){
            if($curr_id == $ht_id){
                $_SESSION['username'] = $username;
                echo 3;
            } else {
                echo 2;
            }
        }
        else {
            echo 1;
        }
    }
    
    } else{
        // neu trong
        echo 0;
    }
}

function GetListUser(){
    $conn = connect();
    
    $curr_id = $_SESSION['user-Id'];
    $key_user = $_POST['key_user'];
    
    $queryy = "Select * from user where id != '$curr_id' and song = 0 and (tenDN like '%$key_user%' or sdt like '%$key_user%')";
    $result = mysqli_query($conn, $queryy);
    
    $data = array();
    if (mysqli_num_rows($result) > 0)
    {
       $data = mysqli_fetch_all($result);
    }
    echo json_encode($data);
}  

function GetListUserBan(){
    $conn = connect();
   
    $queryy = "Select * from user where song = 1";
    $result = mysqli_query($conn, $queryy);
    
    $data = array();
    if (mysqli_num_rows($result) > 0)
    {
       $data = mysqli_fetch_all($result);
    }
    echo json_encode($data);
}  

function GetListChoKetBan(){
    $conn = connect();
    
    $curr_id = $_SESSION['user-Id'];
    
    $queryy = "Select * from user as u, banbe as b where u.song = 0 and b.tt = 1 and ((b.user1 = '$curr_id' and u.id = b.user2) "
            . "or (b.user2 = '$curr_id' and b.user1 = u.id))";
    $result = mysqli_query($conn, $queryy);
    
    $data = array();
    if (mysqli_num_rows($result) > 0)
    {
       $data = mysqli_fetch_all($result);
    }
    echo json_encode($data);
}  

function GetListChoChat(){
    $conn = connect();
    
    $curr_id = $_SESSION['user-Id'];
    
    $queryy = "Select * from user as u, chat as c where u.song = 0 and c.user2 = '$curr_id' and u.id = c.user1"
            . " ORDER BY c.stt desc";
    $result = mysqli_query($conn, $queryy);
    
    $data = array();
    if (mysqli_num_rows($result) > 0)
    {
       $data = mysqli_fetch_all($result);
    }
    echo json_encode($data);
} 

function LayProfileUser(){
    $curr_id = $_POST['detailUser'];
    
    $user1  = $_SESSION['user-Id'];
    $user2  = $curr_id;
            
    $conn = connect();
    
    $queryy = "Select * from user where id = '$curr_id'";
    $result = mysqli_query($conn, $queryy);
    
    if (mysqli_num_rows($result) > 0)
    {
        // neu ko loi
        $row = mysqli_fetch_array($result);
       
        $queryy2 = "Select * from banbe where (user1 = '$user1' and user2 = '$user2') "
            . "or (user1 = '$user2' and user2 = '$user1') ";
        $result2 = mysqli_query($conn, $queryy2);
    
        if (mysqli_num_rows($result2) > 0)
        {  // da co du lieu ket ban
            $data = mysqli_fetch_array($result2);
            $row[] = $data[3]; // 0 - chua ket ban, 1 - da gui loi moi ket ban, 2 - da la ban be
            $row[] = $data[0];
        } else{
             $row[] = '0';  // chua ket ban
             $row[] = '-1';
        }
    
        $queryy3 = "Select * from block where id_user_block = '$user1' and id_user_bi_block = '$user2'";
        $result3 = mysqli_query($conn, $queryy3);
        if (mysqli_num_rows($result3) > 0)
        {  
            $row[] = 0;
        } else{
            $row[] = 1;
        }
        
        $queryy4 = "Select * from block where id_user_block = '$user2' and id_user_bi_block = '$user1'";
        $result4 = mysqli_query($conn, $queryy4);
        if (mysqli_num_rows($result4) > 0)
        {  
            $row[] = 1;
        } else{
            $row[] = 0;
        }
    
        echo json_encode($row);
    }
}

function CapQuyen(){
    $curr_id = $_POST['quyenID'];
    $quyen   = $_POST['quyenAdm'];
    
    $conn = connect();
    
    $queryy = "Update user set quyen = '$quyen' where id = '$curr_id'";
    
    if (mysqli_query($conn, $queryy))
    {
       echo 1;
    }
    else {
       echo 0;
    }
}

function GuiBlock(){
    $conn = connect();
    
    $user1 = $_SESSION['user-Id'];
    $user2 = $_POST['blockid'];
    
    date_default_timezone_set("Asia/Bangkok");
    $ngay = date('Y-m-d H:i:s', time());
    
    $queryy = "INSERT INTO block (id_user_block, id_user_bi_block) VALUES "
                . "('$user1', '$user2')";
    if (mysqli_query($conn, $queryy)){
        echo 1;
    }else {
        echo 0;
    }
}

function XoaBlock(){
    $user1 = $_SESSION['user-Id'];
    $user2 = $_POST['unblockid'];
    
    $conn = connect();
    
    $queryy = " Delete from block where id_user_block = '$user1' and id_user_bi_block = '$user2'";
    if (mysqli_query($conn, $queryy))
    {
        echo 1;
    } else{
        echo 0;
    }
}

function XoaProfileUser(){
    $curr_id = $_POST['xoaUser'];
    
    $conn = connect();
    
    $queryy = "Update user set song = 1 where id = '$curr_id'";
    if (mysqli_query($conn, $queryy))
    {
        echo 'Xoa thanh cong';
    } else{
        echo 'Loi';
    }
}

function KhoiPhucProfileUser(){
    $curr_id = $_POST['kpUser'];
    
    $conn = connect();
    
    $queryy = "Update user set song = 0 where id = '$curr_id'";
    if (mysqli_query($conn, $queryy))
    {
        echo 1;
    } else{
        echo 0;
    }
}

function TaoChat(){
    $conn = connect();
    
    $user1 = $_SESSION['user-Id'];
    $user2 = $_POST['moChatId'];
    
    $queryy = "Select * from chat, user where (id = '$user2' and user1 = '$user1' and user2 = '$user2') "
            . "or (id = '$user2' and user1 = '$user2' and user2 = '$user1')";
    $result = mysqli_query($conn, $queryy);
    
    if (mysqli_num_rows($result) > 0)
    {
        $queryy2 = "Update chat set tt = 1 where user1 = '$user2' and user2 = '$user1'";
        mysqli_query($conn, $queryy2);
        
        $data = mysqli_fetch_all($result);
        echo json_encode($data);
    } else{
        $queryy2 = "Select * from user where id = '$user2'";
        $result2 = mysqli_query($conn, $queryy2);
        $data = mysqli_fetch_row($result2);
        
        $row = array();
        $row[] = [-1,0,0,0,0,0,0,$data[0],$data[1],$data[2],$data[3],$data[4],$data[5],$data[6]];
        
        echo json_encode($row);
    }
}

function GuiTinNhan(){
    $conn = connect();
    
    $user1 = $_SESSION['user-Id'];
    $user2 = $_POST['guiChatId'];
    
    $message = $_POST['message'];
    $media = $_POST['media'];
    
    date_default_timezone_set("Asia/Bangkok");
    $ngay = date('Y-m-d H:i:s', time());
    
    $queryy = "INSERT INTO chat (user1, user2, noidung, media, ngay, tt) VALUES "
                . "('$user1', '$user2', '$message', '$media', '$ngay', 0)";
    if (mysqli_query($conn, $queryy)){
        echo 0;
    }else {
        echo 1;
    }
}

function XoaConver(){
    $user1 = $_SESSION['user-Id'];
    $user2 = $_POST['xoaCV'];
    
    $conn = connect();
    
    $queryy = " Delete from chat where (user1 = '$user1' and user2 = '$user2') "
            . "or (user1 = '$user2' and user2 = '$user1') ";
    if (mysqli_query($conn, $queryy))
    {
        echo '1';
    } else{
        echo '0';
    }
}

function XoaTinNhan(){
    $tn_id = $_POST['xoaTN'];
    
    $conn = connect();
    
    $queryy = " Delete from chat where stt = '$tn_id'";
    if (mysqli_query($conn, $queryy))
    {
        echo '1';
    } else{
        echo '0';
    }
}

function GuiKetBan(){
    $conn = connect();
    
   $user1 = $_SESSION['user-Id'];
   $user2 = $_POST['ketbanID'];
    
   $queryy = "Select * from banbe where (user1 = '$user1' and user2 = '$user2') "
            . "or (user1 = '$user2' and user2 = '$user1') ";
    $result = mysqli_query($conn, $queryy);
    
    if (mysqli_num_rows($result) > 0)
    {  // da co du lieu ket ban
        $sql = "Update banbe set user1 = '$user1', user2 = '$user2', tt = '1' where (user1 = '$user1' and user2 = '$user2') "
            . "or (user1 = '$user2' and user2 = '$user1') ";
        if (mysqli_query($conn, $sql)){
            echo 1;  // thanh cong
        }else {
            echo 0;  // that bai
        }
    } else{
       $sql = "INSERT INTO banbe (user1, user2, stt, tt) VALUES "
                . "('$user1', '$user2', 'null', '1')";
        if (mysqli_query($conn, $sql)){
            echo 1;  // thanh cong
        }else {
            echo 0;  // that bai
        }
    }
}

function ChapNhanKetBan(){
    $conn = connect();
    
    $user1 = $_SESSION['user-Id'];
    $user2 = $_POST['ketbanOkID'];
 
    $sql = "Update banbe set tt = '2' where (user1 = '$user1' and user2 = '$user2') "
            . "or (user1 = '$user2' and user2 = '$user1') ";
    if (mysqli_query($conn, $sql)){
        echo 1;  // thanh cong
    }else {
        echo 0;  // that bai
    }
}

function HuyKetBan(){
    $conn = connect();
    
    $user1 = $_SESSION['user-Id'];
    $user2 = $_POST['huyketbanID'];
 
    $sql = "Update banbe set tt = '0' where (user1 = '$user1' and user2 = '$user2') "
            . "or (user1 = '$user2' and user2 = '$user1') ";
    if (mysqli_query($conn, $sql)){
        echo 1;  // thanh cong
    }else {
        echo 0;  // that bai
    }
}

function GetListFriend(){
    $conn = connect();
    
    $curr_id = $_SESSION['user-Id'];
    
    $sql = "Select * from banbe where tt = 2 and (user1 = '$curr_id' or user2 = '$curr_id') ";
    $result = mysqli_query($conn, $sql);
    $data = array();
    
    if (mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_all($result);
        foreach ($row as $value) {
            $idban = $value[0];
            if($value[0] == $curr_id){
                $idban = $value[1];
            }
            $queryy = "Select * from user where id = '$idban' and song = 0";
            $result2 = mysqli_query($conn, $queryy);
            
            if (mysqli_num_rows($result2) > 0){
                $data[] = mysqli_fetch_array($result2);
            }
        }
    }
    
    echo json_encode($data);
}  

function GuiPost(){
    $conn = connect();
    
    $curr_id = $_POST['guiPostID'];
    
    $message = $_POST['message2'];
    $media = $_POST['media2'];
    
    date_default_timezone_set("Asia/Bangkok");
    $ngay = date('Y-m-d H:i:s', time());
    
    $queryy = "INSERT INTO baiviet (id, id_user, noidung, media, tgTao) VALUES "
                . "('null', '$curr_id', '$message', '$media', '$ngay')";
    if (mysqli_query($conn, $queryy)){
        echo 0;
    }else {
        echo 1;
    }
}

function SuaBV(){
    $conn = connect();
    
    $bl_id = $_POST['upBVID'];
    
    $message = $_POST['message3'];
    $media = $_POST['mediaBV2'];
    
    date_default_timezone_set("Asia/Bangkok");
    $ngay = date('Y-m-d H:i:s', time());
 
    $sql = "Update baiviet set noidung = '$message', media = '$media' "
            . "where id = '$bl_id'";
    if (mysqli_query($conn, $sql)){
        echo 1;  // thanh cong
    }else {
        echo 0;  // that bai
    }
}

function XoaBV(){
    $bv_id = $_POST['xoaBV'];
    
    $conn = connect();
    
    $queryy = " Delete bv.*, bl.* from baiviet as bv, binhluan as bl where bv.id = '$bv_id' and bl.id_baiviet = bv.id";
    if (mysqli_query($conn, $queryy))
    {
        echo '1';
    } else{
        echo '0';
    }
}

function GetListPost(){
    $conn = connect();
    
    $curr_id = $_POST['getPostAll'];
    $ts = $_POST['TrcSau'];
    $bth = $_POST['baiTH'];
    
    $queryy = "Select * from baiviet where id_user = '$curr_id' Order By id DESC LIMIT 1";
    $sql2 = "Select Max(id) as maxx, Min(id) as minn from baiviet where id_user = '$curr_id'";
    
    if($ts == 1){
        $queryy = "Select * from baiviet where id_user = '$curr_id' and id < '$bth' Order By id DESC LIMIT 1";
    } else if($ts == 2){
        $queryy = "Select * from baiviet where id_user = '$curr_id' and id > '$bth' LIMIT 1";
    } else if($ts == 3){
        $queryy = "Select * from baiviet where id = '$bth'";
    }
    $result = mysqli_query($conn, $queryy);
    
    if (mysqli_num_rows($result) > 0)
    {
       $data = array();
       $data = mysqli_fetch_row($result);
       
       if($ts == 3){
           $uID = $data[1];
           $sql2 = "Select Max(id) as maxx, Min(id) as minn from baiviet where id_user = '$uID'";
       }
       
       $result2 = mysqli_query($conn, $sql2);
       $row = mysqli_fetch_row($result2);
       
       $data[] = $row[0];
       $data[] = $row[1];
       
       $id_user = $_SESSION['user-Id'];
       $bt = $data[0];
       $sql3 = "Select * from thich where id_baiviet = '$bt' and id_user = '$id_user'";
       $result3 = mysqli_query($conn, $sql3);
       if (mysqli_num_rows($result3) > 0){
           $data[] = 1;
       } else{
           $data[] = 0;
       }
       
       $sql4 = "Select count(id_baiviet) from thich where id_baiviet = '$bt'";
       $result4 = mysqli_query($conn, $sql4);
       $row4 = mysqli_fetch_row($result4);
       $data[] = $row4[0];
    } else{
        $data = array('0', $curr_id);
    }
    echo json_encode($data);
}  

function GuiLike(){
    $conn = connect();
    
    $bl_id = $_POST['baiThuID'];
    $curr_id = $_SESSION['user-Id'];
    
    date_default_timezone_set("Asia/Bangkok");
    $ngay = date('Y-m-d H:i:s', time());
    
    $queryy = "INSERT INTO thich (id_baiviet, id_user, ngay) VALUES "
                . "('$bl_id', '$curr_id', '$ngay')";
    if (mysqli_query($conn, $queryy)){
        echo 1;
    }else {
        echo 0;
    }
}

function XoaLike(){
    $bl_id = $_POST['baiThuIDBoLike'];
    $curr_id = $_SESSION['user-Id'];
    
    $conn = connect();
    
    $queryy = " Delete from thich where id_baiviet = '$bl_id' and id_user = '$curr_id'";
    if (mysqli_query($conn, $queryy))
    {
        echo '1';
    } else{
        echo '0';
    }
}

function GuiBL(){
    $conn = connect();
    
    $bl_id = $_POST['guiBLID'];
    $curr_id = $_SESSION['user-Id'];
    
    $message = $_POST['binhluan'];
    $media = $_POST['mediaBL'];
    
    date_default_timezone_set("Asia/Bangkok");
    $ngay = date('Y-m-d H:i:s', time());
    
    $queryy = "INSERT INTO binhluan (stt, id_baiviet, id_user, noidung, media, ngay) VALUES "
                . "('null', '$bl_id', '$curr_id', '$message', '$media', '$ngay')";
    if (mysqli_query($conn, $queryy)){
        echo $curr_id;
    }else {
        echo 0;
    }
}

function GetBinhLuan(){
    $conn = connect();
    
    $curr_id = $_POST['blID'];
    
    $queryy = "Select * from binhluan as bl, user as u where bl.id_baiviet = '$curr_id' and bl.id_user = u.id";
    $result = mysqli_query($conn, $queryy);
    
    $data = array();
    if (mysqli_num_rows($result) > 0)
    {
       $data = mysqli_fetch_all($result);
    }
    echo json_encode($data);
}  

function XoaBL(){
    $bl_id = $_POST['xoaBL'];
    
    $conn = connect();
    
    $queryy = " Delete from binhluan where stt = '$bl_id'";
    if (mysqli_query($conn, $queryy))
    {
        echo '1';
    } else{
        echo '0';
    }
}

function SuaBL(){
    $conn = connect();
    
    $bl_id = $_POST['upBLID'];
    
    $message = $_POST['binhluan2'];
    $media = $_POST['mediaBL2'];
    
    date_default_timezone_set("Asia/Bangkok");
    $ngay = date('Y-m-d H:i:s', time());
 
    $sql = "Update binhluan set noidung = '$message', media = '$media' "
            . "where stt = '$bl_id'";
    if (mysqli_query($conn, $sql)){
        
        $sql2 = "Select bv.id from baiviet as bv, binhluan as bl where bl.stt = '$bl_id' and bv.id = bl.id_baiviet";
        $res = mysqli_query($conn, $sql2);
        
        if (mysqli_num_rows($res) > 0){
           $data = mysqli_fetch_row($res);
           echo $data[0];  // thanh cong
        } else{
           echo 0;
        }
        
    }else {
        echo 0;  // that bai
    }
}
?>


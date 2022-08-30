<?php
//设置网页文件字符集
header("Content-type:text/html;charset=UTF-8");
//包含数据库连接文件
require_once 'Conn.php';
//设置数据库字符集，避免中文乱码
$db->query("SET NAMES utf8");

//处理用户提交的原始数据
function checkInput($data) {
    $data = trim($data);   //去除空格等不必要字符
    $data = stripslashes($data);  //删除反斜杠
    $data = htmlspecialchars($data);   //转义HTML特殊字符
    return $data;
}
//获取用户名
$userName=checkInput($_POST['userName']);
if(empty($userName)){
    echo"<script>alert('用户名没有填写!');history.go(-1);</script>";
    exit();
}

//检查用户名是否已经存在
$sql="SELECT*FROM account WHERE username='$userName'";
$result=$db->query($sql);
if($result->num_rows>0){
    echo"<script>alert('该用户名已经存在!');history.go(-1);</script>";
    exit();
}
//获取姓名
$cName=checkInput($_POST['cName']);

//获取密码
$password=checkInput($_POST['pwd']);
if(empty($password)){
    echo"<script>alert('密码没有填写!');history.go(-1);</script>";
    exit();
}
//获取国家
$country=checkInput($_POST['country']);

//获取省份
$province=checkInput($_POST['province']);

//获取城市
$city=checkInput($_POST['city']);

//获取地址
$address=checkInput($_POST['address']);

//获取邮编
$zip=checkInput($_POST['zip']);

//获取手机
$phone=checkInput($_POST['phone']);

//获取邮箱
$email=checkInput($_POST['email']);



/* 将用户信息添加到account数据表*/
$sql = "INSERT  INTO  Account  VALUES('$userName','$password','$cName',
'$country','$province','$city','$address','$zip','$phone','$email') ";
$result = $db->query($sql);
if($result){
    echo"<script>alert('注册成功!');history.go(-1);</script>";
}
else{
    echo"<script>alert('注册失败!');history.go(-1);</script>";
}
?>

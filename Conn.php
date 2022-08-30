<?php
//实例化mysqli类，连接bookshop数据库
$db=new mysqli("localhost","root","","bookshop");

//检查链接，如果链接发生错误，退出脚本并显示提示信息
if($db->connect_errno){
    exit("数据库连接失败。");
}
?>

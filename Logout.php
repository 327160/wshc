<!-- 请补全注销部分代码 -->
<?php
session_start();
unset($_SESSION['userName']); //释放Session中的userName变量
session_destroy(); //销毁会话中的全部数据
header("location:Index.php"); //回到主页
?> 

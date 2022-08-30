<link rel="stylesheet" type="text/css" href="Style.css" />
<!-- 网页头部 -->
<header></header>
<!-- 导航区 -->
<nav>
	<ul>
		<li><a href="Index.php">主 页</a></li>
		<li><a href="Register.php">用户注册</a></li>
		<li><a href="UserProfile.php">用户信息</a></li>
		<li><a href="ShoppingCart.php">购物车</a></li>
		<li><a href="Search.php">搜索</a></li>
		<li><a href="WishList.php">我的收藏</a></li>
		<?php
// 如果已经设置了Session变量“userName”，显示“注销”链接，否则显示“用户登录”链接。
if (isset($_SESSION['userName'])) {
    echo "<li><a href='Logout.php'>注销</a></li>";
} else {
    echo "<li><a href='Login.php'>用户登录</a></li>";
}
?>
	</ul>
	<span id='welcome'><?php
	// 如果已经设置了Session变量“userName”，读取并显示。
if (isset($_SESSION['userName'])) {
    echo $_SESSION['userName'] . "，欢迎访问网上书城系统！";
} else {
    echo "欢迎访问网上书城系统！";
}
?></span>
</nav>
<!-- 内容区的开始 -->
<main> 
<?php
error_reporting(0);
?>
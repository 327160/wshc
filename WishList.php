<?php
session_start(); // 启动会话
                 // 如果未登录，没有设置Session变量“userName”，跳转到登录页
if (! isset($_SESSION['userName'])) {
    header('Location:Login.php');
}
?>
<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8">
<title>收藏夹</title>
<!-- <script type="text/javascript">
//捕获文本框失去焦点事件
function updateQuantity(productid)
{
	document.getElementById("txt_p"+productid).value=document.getElementById("txt_p"+productid).value.replace(/[^0-9-]+/,'');
	window.location.href="Collect.php?productid="+productid+"&count="+document.getElementById("txt_p"+productid).value;
}
//捕获回车事件
function quantityUp(productid)
{
	if(window.event.keyCode == 13){ 
		document.getElementById("txt_p"+productid).value=document.getElementById("txt_p"+productid).value.replace(/[^0-9-]+/,'');
		window.location.href="Collect.php?productid="+productid+"&count="+document.getElementById("txt_p"+productid).value;
	}
}
</script> -->
</head>
<body>
<?php
include 'HeaderNav.php'; // 包含页头与导航页
?>
<!-- 内容区的元素 -->

<?php

	//
	require_once 'Conn.php';
	//
	$db->query("SET NAMES utf8");
	//
	$del = $_GET['del'];
	//
	$dell=$_GET['dell'];
	//
	$productid=$_GET['productid'];
	//
	if(isset($dell))
	{
		/* $sql = "INSERT INTO collect (Username, ProductId, Name, Descn, Image, ListPrice) select username, productid,name,descn,image,listprice from product where productid='".$productid."'"; */
		$sql = "insert into collect (Username, ProductId, Name, Descn, Image, ListPrice) (select '" . $_SESSION['userName'];
		$sql = $sql . "','" . $productid . "',name,descn,image,listprice from product WHERE productid = '" . $productid . "');";
		$result=$db->query($sql);
	}
	//
	if (isset($del)) {
	    $sql = "delete from collect where productid = '" . $productid. "'";
	    $result = $db->query($sql);
	} 
	//
	$sql="select productid,name,descn,image,listprice from collect where username='". $_SESSION['userName']."'";
	//
	$result = $db->query($sql);
	//
	if ($result->num_rows>=1)
	{
	   
	    echo "<table class='tb'>
		<tr><th width=\"10%\">名称</th>
		<th width=\"45%\">描述</th>
		<th width=\"15%\">图片</th>
		<th width=\"10%\">价格</th>
		<th width=\"10%\">加入购物车</th>
		<th width=\"10%\">删除</th>
		</tr>";
	    // 获取数据
	    while ($row = $result->fetch_assoc()) {
	        echo "<tr><td>".$row["name"].
	        "</td><td>".$row["descn"].
	        "</td><td><img src=\"images/".$row["image"]."\"  height=120px width=80px/>".
	        "</td><td>".$row["listprice"].
	        "</td><td><a href=\"ShoppingCart.php?productid=".$row["productid"]."\">加入购物车</a>".
			"</td><td><a href = \"WishList.php?del=1&productid=" . $row["productid"] . "\">删除</a>".
	        "</td></tr>";
	    }
	    echo "</table>";
	}
	else
	{
		echo"暂无收藏";
	}
	//
	$result->close();
	//
	$db->close();
?>

<?php
include 'Footer.html'; // 包含页脚页
?>
</body>
</html>
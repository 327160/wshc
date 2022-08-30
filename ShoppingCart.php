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
<title>购物车</title>
<script type="text/javascript">
//捕获文本框失去焦点事件
function updateQuantity(productid)
{
	document.getElementById("txt_p"+productid).value=document.getElementById("txt_p"+productid).value.replace(/[^0-9-]+/,'');
	window.location.href="ShoppingCart.php?productid="+productid+"&count="+document.getElementById("txt_p"+productid).value;
}
//捕获回车事件
function quantityUp(productid)
{
	if(window.event.keyCode == 13){ 
		document.getElementById("txt_p"+productid).value=document.getElementById("txt_p"+productid).value.replace(/[^0-9-]+/,'');
		window.location.href="ShoppingCart.php?productid="+productid+"&count="+document.getElementById("txt_p"+productid).value;
	}
}
</script>

</head>
<body>
<?php
include 'HeaderNav.php'; // 包含页头与导航页
?>
<!-- 内容区的元素 -->
<?php
// 显示购物车
// 如果有删除标志，则删除购物车中的该书籍，
// 如果有数量更新标志，则更新购物车中该书籍的数量
// 先读取用户的购物车内容，再判断用户选购的书籍是否已经在购物车中，如果已经在购物车中，数量加1，
// 如果不在购物车中，加入购物车，更新数据库，并显示购物车中的内容。
// 引用数据库连接文件
require_once 'Conn.php';
// 设置字符集，避免中文乱码
$db->query("SET NAMES utf8");
// 书籍id
$productid = $_GET['productid'];
// 删除标志
$del = $_GET['del'];
// 数量更新标志
$count = $_GET['count'];

// 先判断删除标志
if (isset($del)) {
    $sql = "delete from cart where username = '" . $_SESSION['userName'] . "' and productid = '" . $productid . "'";
    $result = $db->query($sql);
} else {
    // 判断数量更新标志
    if (isset($count)) {
        $sql = "update cart set quantity = " . $count . " where username = '" . $_SESSION['userName'] . "' and productid = '" . $productid . "'";
        $result = $db->query($sql);
    } else {
        // 定义SQL语句，查询用户购物车中是否已经存在该书籍
        $sql = "select count(*) c from cart where username = '" . $_SESSION['userName'] . "' and productid = '" . $productid . "'";
        // 执行查询
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        $totalNumber = $row["c"];
        if ($totalNumber > 0) {
            // 购物车已经有这个书籍了，将数据库中该记录的数量加一
            $sql = "update cart set quantity = quantity +1 where  username = '" . $_SESSION['userName'] . "' and productid = '" . $productid . "'";
        } else {
            // 购物车中没有这个书籍，将该数据插入数据库中去
            // INSERT INTO cart (username,productid,NAME,listprice,quantity) (SELECT 'aaa','1',NAME,listprice,1 FROM product WHERE productid = '1');
            $sql = "insert into cart (username,productid,name,listprice,quantity) (select '" . $_SESSION['userName'];
            $sql = $sql . "','" . $productid . "',NAME,listprice,1 FROM product WHERE productid = '" . $productid . "');";
        }
        // echo $sql;
        // 更新数据库
        $result = $db->query($sql);
    }
}
// 重新查询数据库中的购物车记录，返回查询结果并用表格显示
$sql = "select productid,name,quantity,listprice from cart where username = '" . $_SESSION['userName'] . "'";
$result = $db->query($sql);
$sql = "SELECT SUM(listprice*quantity) s FROM cart WHERE username = '" . $_SESSION['userName'] . "'";
$result2 = $db->query($sql);
$row2 = $result2->fetch_assoc();
if ($result->num_rows >= 1) {
    echo "<div id=\"main\">";
    echo "<table class='tb' width=100%><tr><th>书籍名称</th><th>数量</th><th>单价</th><th>删除</th></tr>";
    // 获取数据
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["name"] . "</td><td>";
        echo "<input type=\"text\" id=\"txt_p" . $row["productid"] . "\" value=" . $row["quantity"];
        echo " onblur=\"updateQuantity(" . $row["productid"] . ")\" ";
        echo " onKeyUp=\"quantityUp(" . $row["productid"] . ")\" ";
        echo "/>";
        echo "</td><td>" . $row["listprice"] . "</td><td><a href = \"ShoppingCart.php?del=1&productid=" . $row["productid"] . "\">删除</a></td></tr>";
    }
    echo "<tr><th></th><th>总价：</th><th>" . $row2["s"] . "</th><th></th></tr>";
    echo "</table>";
    
    echo "<li><a href=\"Index.php\"> 继续选购</a></li>";
    echo "<li><a href=\"CheckOut.php\"> 结算</a></li>";
    
    echo "</div>";
}
// 计算总价

// 释放结果集
$result->close();
$result2->close();
// 关闭连接
$db->close();

?>

<?php
include 'Footer.html'; // 包含页脚页
?>
</body>
</html>
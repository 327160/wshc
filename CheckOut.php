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
<title>结算</title>

</head>
<body>
<?php
include 'HeaderNav.php'; // 包含页头与导航页
?>
<!-- 内容区的元素 -->
<div id="main">
<?php
// 显示购物车的内容和用户信息
require_once 'Conn.php';
// 提交标志
$check = $_GET['check'];
// 设置字符集，避免中文乱码
$db->query("SET NAMES utf8");
if (isset($check)) {
    $sql = "set @uname='".$_SESSION['userName']."'";
    $db->query($sql);
    $sql = "call checkout(@uname)";
    $result = $db->query($sql);
    
    echo "订单提交成功，感谢您的订购<br/>";
    echo "订单商品将开始配送，请保持您的联系方式畅通<br/>";
    echo "如对本订单有任何疑问，请联系我们的客服40000000000<br/>";
    echo "网上书城团队<br/>";
} else {
    // 查询数据库中的购物车记录，返回查询结果并用表格显示
    $sql = "select productid,name,quantity,listprice from cart where username = '" . $_SESSION['userName'] . "'";
    $result = $db->query($sql);
    $sql = "SELECT SUM(listprice*quantity) s FROM cart WHERE username = '" . $_SESSION['userName'] . "'";
    $result2 = $db->query($sql);
    $row2 = $result2->fetch_assoc();
    if ($result->num_rows >= 1) {
        echo "<table class='tb'><tr><th>书籍名称</th><th>数量</th><th>单价</th></tr>";
        // 获取数据
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["name"] . "</td><td>";
            echo $row["quantity"];
            echo "</td><td>" . $row["listprice"] . "</td></tr>";
        }
        echo "<tr><th></th><th>总价：</th><th>" . $row2["s"] . "</th></tr>";
        echo "</table>";
    }
    // 查询用户信息并显示
    $sql = "SELECT  cname,country,province,city,address,zip,phone FROM account WHERE username = '" . $_SESSION['userName'] . "'";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();
    echo "<table class='tb'>";
    echo "<tr><td>姓名：</td><td>" . $row["cname"] . "</td></tr>";
    echo "<tr><td>国家：</td><td>" . $row["country"] . "</td></tr>";
    echo "<tr><td>省份：</td><td>" . $row["province"] . "</td></tr>";
    echo "<tr><td>城市：</td><td>" . $row["city"] . "</td></tr>";
    echo "<tr><td>地址：</td><td>" . $row["address"] . "</td></tr>";
    echo "<tr><td>邮编：</td><td>" . $row["zip"] . "</td></tr>";
    echo "<tr><td>电话：</td><td>" . $row["phone"] . "</td></tr>";
    echo "</table>";
    echo "<a href=\"CheckOut.php?check=1\"> 提交订单</a>";
    // 释放结果集
    $result->close();
    // 关闭连接
    $db->close();
}
?>
</div>
<?php
include 'Footer.html'; // 包含页脚页
?>
</body>
</html>
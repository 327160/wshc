<?php
session_start(); //启动会话
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>网上书城系统</title>

</head>
<body>
<?php 
include 'HeaderNav.php';  //包含页头与导航页
?>
<!-- 内容区的元素 -->

<?php
//引用数据库连接文件
require_once 'Conn.php';
//设置字符集，避免中文乱码
$db->query("SET NAMES utf8");
$cateid=$_GET['cateid'];
$perNumber=5; //每页显示的记录数
$page=$_GET['page']; //获得当前的页面值
$result=$db->query("SELECT COUNT(*) c FROM product WHERE categoryid = ".$cateid); //获得记录总数
$row = $result->fetch_assoc();
$totalNumber=$row["c"];
$totalPage=ceil($totalNumber/$perNumber); //计算出总页数
if (!isset($page)) {
 $page=1;
} //如果没有值,则赋值1
$startCount=($page-1)*$perNumber; //分页开始,根据此方法计算出开始的记录
$result=$db->query("select productid,name,descn,image,listprice from product where categoryid = $cateid limit $startCount,$perNumber"); //根据前面的计算出开始的记录和记录数
//查询到记录，返回查询结果并用表格显示
echo "<div id=\"main\">";
if ($result->num_rows>=1){
   
    echo "<table class='tb'><tr><th width=\"10%\">名称</th><th width=\"40%\">描述</th><th width=\"20%\">图片</th><th width=\"10%\">价格</th><th width=\"10%\">加入购物车</th><th width=\"10%\">是否收藏</th></tr>";
    // 获取数据
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["name"].
        "</td><td>".$row["descn"].
        "</td><td><img src=\"images/".$row["image"]."\"  height=120px width=80px/>".
        "</td><td>".$row["listprice"].
        "</td><td><a href=\"ShoppingCart.php?productid=".$row["productid"]."\">加入购物车</a>".
        "</td><td><a href=\"WishList.php?dell=1&productid=".$row["productid"]."\">收藏</a></td>
        </tr>";
    }
    echo "</table>";
    
}


if ($page != 1) { //页数不等于1
?>
<a href="Products.php?cateid=<?php echo $cateid;?>&page=<?php echo $page - 1;?>">上一页</a> <!--显示上一页-->
<?php
}
for ($i=1;$i<=$totalPage;$i++) {  //循环显示出页面
?>
<a href="Products.php?cateid=<?php echo $cateid;?>&page=<?php echo $i;?>"><?php echo $i ;?></a>
<?php
}
if ($page<$totalPage) { //如果page小于总页数,显示下一页链接
?>
<a href="Products.php?cateid=<?php echo $cateid;?>&page=<?php echo $page + 1;?>">下一页</a>
</div>
<?php
} 
//释放结果集
$result->close();
//关闭连接
$db->close();
?>
<?php 
include 'Footer.html';   //包含页脚页
?>
</body>
</html>

<?php
session_start(); // 启动会话
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>网上书城系统</title>

</head>
<body>
<?php
include 'HeaderNav.php'; // 包含页头与导航页
?>
<!-- 内容区的元素 -->
<?php
// 显示图书的类别
// 引用数据库连接文件
require_once 'Conn.php';
// 设置字符集，避免中文乱码
$db->query("SET NAMES utf8");
// 定义SQL语句，按学号查询信息
$sql = "SELECT CategoryId,NAME,Descn,Image FROM Category;";
// 执行查询
$result = $db->query($sql);
// 查询到记录，返回查询结果并用表格显示
if ($result->num_rows >= 1) {	
//     请补全查询的记录结果
     echo "<div id=\"main\">";
     echo "<table width=80% align=center>";
     	//获取数据
     //<a href="http://www.w3school.com.cn">W3School</a>
     $i =0;
     while ($row =$result->fetch_assoc())
	 {
     	
		$temp = "<td align=center>
		<a href=\"Products.php?cateid=" . $row["CategoryId"] . "\">
		<img src='Images\\" . $row['Image'] . "' height=150px width=100px>
		</a><br/>" . $row["Descn"] . "</td>";
     		//按照每行4列排列
     		$i ++ ;
     		if(($i - 1) % 4 ==0){
     			//第一列
				
     			echo "<tr>" . $temp;
     		}
			elseif($i % 4==0)
			{
     			//第四列
     			echo $temp . "</tr>";     			
     		}
			else
			{
     			//第二列和第三列
     			echo $temp;
     		}
     		
     		 
     }	  
     echo "</table>";
     echo "</div>";
} // 没有查询到记录
else {
    echo "<div style='color:red;margin-top:50px;'>没有查到书籍类别内容！</div>";
}
// 释放结果集
$result->close();
// 关闭连接
$db->close();
?>

<?php
include 'Footer.html'; // 包含页脚页
?>
</body>
</html>

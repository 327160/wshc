<?php
session_start(); // 启动会话
// 如果未登录，没有设置Session变量“userName”，跳转到登录页
if (!isset($_SESSION['userName'])) {
    header('Location:Login.php');
}


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>搜索</title>
    <style type="text/css">
        #login {
            width: 300px;
            border: 1px solid blue;
            line-height: 40px;
            margin: 0 auto;
            padding-left: 50px;
            padding-top: 15px;
            padding-bottom: 15px;
            text-align: left;
            font-size: 14px;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>
    <?php
    include 'HeaderNav.php';
    ?>

    <h1>搜索书籍</h1>
    <form action=" " method="post" enctype="multipart/form-data">
        <div id="login">
            <div>
                书名：<input type="text" name="sjname" />&nbsp;&nbsp;<input type="submit" name="btnss" value="搜索" />
            </div>
        </div>
    </form>


    <?php
    if (isset($_POST["btnss"])) {
        $sjName = $_POST["sjname"]; //用户输入的书名
        //引用数据库连接文件
        require_once 'Conn.php';
        $db->query("SET NAMES utf8");
        //定义SQL语句
        $sql = "SELECT*FROM product WHERE Name like '%$sjName%'";
        $result = $db->query($sql);
 
        if ($result->num_rows >= 1) {

            echo "<table class='tb'><tr><th width=\"10%\">名称</th><th width=\"50%\">描述</th><th width=\"20%\">图片</th><th width=\"10%\">价格</th><th width=\"10%\">加入购物车</th></tr>";
            // 获取数据
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["Name"] .
                    "</td><td>" . $row["Descn"] .
                    "</td><td><img src=\"images/" . $row["Image"] . "\"  height=120px width=80px/>" .
                    "</td><td>" . $row["ListPrice"] .
                    "</td><td><a href=\"ShoppingCart.php?productid=" . $row["ProductId"] . "\">加入购物车</a>" .
                    "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "没有查询到记录";
        }
        //释放结果集
        $result->close();
        //关闭连接
        $db->close();
    }
    ?>



    <?php
    include 'Footer.html';   //包含页脚页
    ?>
</body>

</html>
<?php 
//用户单击“登录”按钮返回页面，判断登录是否成功
if(isset($_POST["btnSubmit"])){
    //登录
    $userName=$_POST["userName"]; //用户输入的用户名
    $pwd=$_POST["pwd"]; //用户输入的密码

    //引用数据库连接文件
    require_once 'Conn.php';
    //定义SQL语句
    $sql="SELECT*FROM Account WHERE Username='$userName'AND Password='$pwd'";
    //执行查询
    $result=$db->query($sql);
    //登录成功
    if($result->num_rows>=1){
        //使用Session保存登录的用户名信息
        session_start(); //启动会话
        $_SESSION['userName']=$_POST["userName"];

        //使用Cookie保存登录的用户名信息，保存时间为30天
        setcookie("userName",$_POST["userName"],time()+60*60*24*30);

        //默认返回的页面为主页
        $backUr1="Index.php";
        //若网页接受到了“frompage”参数的传值，则登录成功后跳转到“frompage”
        //参数传递的网页文件地址
        if(isset($_GET["frompage"])){
            $backUr1=$_GET["frompage"].'.php';
        }
        //网页跳转
        echo"<script>window.location='{$backUr1}'</script>";
    }
    //登录失败,弹出提示框
    else{
        echo"<script>window.alert('用户名或密码错误!')</script>";
    }
}


?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>用户登录</title>
<style type="text/css">
#login{
    width:300px;
    border:1px solid blue;
    line-height:40px;
    margin:0 auto;
    padding-left:50px;
    padding-top:15px;
    padding-bottom:15px;
    text-align:left;
    font-size:14px;
}
.error{
    color:red;
}
</style>
</head>
<body>
<?php 
include 'HeaderNav.php';  //包含页头与导航页

//$actionUr1变量为登录form表单的action的URL地址，设置为登录页面自身
$actionUr1=$_SERVER['PHP_SELF'];
//如果页面接受到了URL的“frompage”参数传值，则form表单的action的URL地址继
//续传递该参数
if(isset($_GET["frompage"])){
    $actionUr1=$actionUr1.'?frompage='.$_GET["frompage"];
}
?>

<h1>用户登录</h1>
<form action=" " method="post" enctype="multipart/form-data">
<div id="login">
	<div>
		 用户名：<input type="text" name="userName"/><span class="error">*</span>
	</div>
	<div>
		密&nbsp;&nbsp;&nbsp;码：<input type="password" name="pwd"/><span class="error">*</span>
	</div>
	<div style="margin-left:85px;">
		<input type="submit" name="btnSubmit" value="登录"/>
	</div>
</div>
</form>

<script type="text/javascript">
    var elform=document.getElementsByTagName("form")[0];//获取表单
    elform.onsubmit=function(){
        //表单提交,调用checkDate()函数验证数据，如果验证出错，中止表单提交
        return checkData();
    }
    //验证用户输入的各项数据
    function checkData(){
        var valid=ture; //验证是否通过的标识
        //用户名必填
        var eluserName=document.getElementsByTagName("userName")[0];//获取用户名文本框
        if(eluserName.value==""){
            eluserName.nextSibling.innerHTML="*用户名必填!";
            //用户名文本框右侧的文字标签显示提示信息
            valid=false; //验证错误
        }else{
            eluserName.nextSibling.innerHTML="*"; //清楚错误提示信息
        }
        //密码必填
        var elPwd=document.getElementsByName("pwd")[0]; //获取密码文本框
        if(elPwd.value==""){
            elPwd.nextSibling.innerHTML="*密码必填!";
            valid=false;
        }
        else{
            elPwd.nextSibling.innerHTML="*";
        }

        return valid; //返回验证结果
    }
</script>
<!-- 补全数据验证 -->

<?php 
include 'Footer.html';   //包含页脚页
?>
</body>
</html>
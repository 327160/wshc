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
<meta charset="UTF-8">
<title>用户信息</title>
<style type="text/css">
body {
	margin: 0px;
	text-align: center;
}

#reg {
	width: 370px;
	border: 1px solid blue;
	line-height: 40px;
	margin: 0 auto;
	padding-left: 100px;
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
// 包含页头与导航页
include 'HeaderNav.php';
// 引用数据库连接文件
require_once 'Conn.php';
// 设置字符集，避免中文乱码
$db->query("SET NAMES utf8");

// 处理用户提交的原始数据
function checkInput($data)
{
    $data = trim($data); // 去除空格等不必要字符
    $data = stripslashes($data); // 删除反斜杠
    $data = htmlspecialchars($data); // 转义HTML特殊字符
    return $data;
}
// 判断是否通过提交表单进入的页面
if (isset($_POST['cName'])) {
    // 获取姓名
    $cName = checkInput($_POST['cName']);
    
    // 获取国家
    $country = checkInput($_POST['country']);
    
    // 获取省份
    $province = checkInput($_POST['province']);
    
    // 获取城市
    $city = checkInput($_POST['city']);
    
    // 获取地址
    $address = checkInput($_POST['address']);
    
    // 获取邮编
    $zip = checkInput($_POST['zip']);
    
    // 获取手机
    $phone = checkInput($_POST['phone']);
    
    // 获取邮箱
    $email = checkInput($_POST['email']);
    
    /* 将用户信息添加到account数据表 */
    $sql = "update account set cname = '$cName', country = '$country', province = '$province', city = '$city', address = '$address', zip = '$zip', phone = '$phone',email = '$email' ";
    $sql = $sql . " where username = '" . $_SESSION['userName'] . "'";
    $result = $db->query($sql);
    if ($result) {
        echo "<script>alert('保存成功！'); </script>";
    } else {
        echo "<script>alert('保存失败！'); </script>";
    }
}
// 显示用户信息
$sql = "SELECT  cname,country,province,city,address,zip,phone,email FROM account WHERE username = '" . $_SESSION['userName'] . "'";
$result = $db->query($sql);
$row = $result->fetch_assoc();

?>
<h1>用户信息</h1>
	<form action="UserProfile.php" method="post">
		<div id="reg">
			<div>
				姓名：<input type="text" name="cName"
					value="<?php echo $row['cname']?>" />
			</div>
			<div>
				国家：<input type="text" name="country"
					value="<?php echo $row['country']?>" />
			</div>
			<div>
				省份：<input type="text" name="province"
					value="<?php echo $row['province']?>" />
			</div>
			<div>
				城市：<input type="text" name="city" value="<?php echo $row['city']?>" />
			</div>
			<div>
				地址：<input type="text" name="address"
					value="<?php echo $row['address']?>" />
			</div>
			<div>
				邮编：<input type="text" name="zip" value="<?php echo $row['zip']?>" />
			</div>
			<div>
				手机：<input type="text" name="phone"
					value="<?php echo $row['phone']?>" /><span class="error"></span>
			</div>
			<div>
				邮箱：<input type="text" name="email"
					value="<?php echo $row['email']?>" /><span class="error"></span>
			</div>
			<div style="margin-left: 85px;">
				<input type="submit" name="btnSubmit" value="保存" />
			</div>
		</div>
	</form>
<?php
// 释放结果集
$result->close();
// 关闭连接
$db->close();
?>
<script type="text/javascript">
	var elform=document.getElementsByTagName("form")[0]; //获取表单
	elform.onsubmit=function(){
		//表单提交,调佣checkData()函数验证数据，如果验证出错,中止表单提交
		return checkData();
	}
	//验证用户输入的各项数据
	function checkData(){
		var valid=true; //验证是否通过的标识

		//手机号码必须符合规则
		var exPhone=document.getElementsByTagName("phone")[0]; //获取手机文本框
		var regexMobile=/^1[3|5|8]\d{9}$/;  //手机号码规则
		if(elPhone.value!=""&&!regexMobile.test(elPhone.value)){
			elPhone.nextSibling.innerHTML="请输入有效的手机号码!";
			valid=false;
		}
		else{
			elPhone.nextSibling.innerHTML="";
		}
		//邮箱必须符合规则
		var elEmail=document.getElementsByName("email")[0]; //获取邮箱文本框
		var regexEmail=/([\w\-]+\@[\w\-]+\.[\w\-]+)/;  //电子邮箱地址规则
		if(elEmail.value!=""&&!regexEmail.test(elEmail.value)){
			elEmail.nextSibling.innerHTML="*请输入有效的邮箱地址!";
			valid=false;
		}
		else{
			elEmail.nextSibling.innerHTML="";
		}

		return valid; //返回验证结果
	}
</script>

<?php
include 'Footer.html'; // 包含页脚页
?>
</body>
</html>
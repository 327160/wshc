<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>用户注册</title>
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
include 'HeaderNav.php';  //包含页头与导航页
?>
    <h1>用户注册</h1>
    <form action="RegisterData.php" method="post">
        <div id="reg">
            <div style="margin-left:-14px;">
                用户名：<input type="text" name="userName" /><span class="error">*</span>
            </div>
            <div>
                密码：<input type="password" name="pwd" /><span class="error">*</span>
            </div>
            <div style="margin-left:-28px;">
                确认密码：<input type="password" name="confirmPwd" /><span class="error">*</span>
            </div>
            <div>
                姓名：<input type="text" name="cName" />
            </div>
            <div>
                国家：<input type="text" name="country" />
            </div>
            <div>
                省份：<input type="text" name="province" />
            </div>
            <div>
                城市：<input type="text" name="city" />
            </div>
            <div>
                地址：<input type="text" name="address" />
            </div>
            <div>
                邮编：<input type="text" name="zip" />
            </div>
            <div>
                手机：<input type="text" name="phone" /><span class="error"></span>
            </div>
            <div>
                邮箱：<input type="text" name="email" /><span class="error"></span>
            </div>
            <div style="margin-left:85px;">
                <input type="submit" name="btnSubmit" value="注册" />
            </div>
        </div>
    </form>
    <script type="text/javascript">
    var elform = document.getElementsByTagName("form")[0]; //获取表单
    elform.onsubmit = function() {
        //表单提交,调佣checkData()函数验证数据,如果验证出错，中止表单提交
        return checkData();
    }
    //验证用户输入的各项数据
    function checkData() {
        var valid = true; //验证是否通过的标识
        //用户名必填
        var elUserName = document.getElementsByName("userName")[0]; //获取用户名文本框
        if (elUserName.value == "") {
            elUserName.nextSibling.innerHTML = "*用户名必填!";
            //用户名文本框右侧的文字标签显示提示信息
            valid = false; //验证错误
        } else {
            elUserName.nextSibling.innerHTML = "*"; //清除错误提示信息
        }

        //密码必填
        var elPwd = document.getElementsByName("pwd")[0]; //获取密码文本框
        if (elPwd.value == "") {
            elPwd.nextSibling.innerHTML = "*密码必填!";
            valid = false;
        } else {
            elPwd.nextSibling.innerHTML = "*";
        }

        //确定密码必须与密码相同
        var elConfirmPwd = document.getElementsByName("confirmPwd")[0];
        //获取确定密码文本框
        if (elConfirmPwd.value != elPwd.value) {
            elConfirmPwd.nextSibling.innerHTML = "*确定密码必须与密码一致!";
            valid = flase;
        } else {
            elConfirmPwd.nextSibling.innerHTML = "*";
        }

        //手机号码必须符合规则
        var exPhone = document.getElementsByName("phone")[0]; //获取手机文本框
        var regexMobile = /^1[3|5|8]\d{9}$/; //手机号码规则
        if (elPhone.value != "" && !regexMobile.test(elPhone.value)) {
            elPhone.nextSibling.innerHTML = "*请输入有效的手机号码!";
            valid = false;
        } else {
            elPhone.nextSibling.innerHTML = "*";
        }

        //邮箱必须符合规则、
        var elEmail = document.getElementsByName("email")[0]; //获取邮箱文本框
        var regexEmail = /([\w\-]+\@[\w\-]+\.[\w\-]+)/; //电子邮箱地址规则
        if (elEmail.value != "" && !regexEmail.test(elEmail.value)) {
            elEmail.nextSibling.innerHTML = "*请输入有效的邮箱地址!";
            valid = false;
        } else {
            elEmail.nextSibling.innerHTML = "";
        }
        return valid; //返回验证结果
    }
    </script>
    <!-- 表单数据验证 -->

    <?php 
include 'Footer.html';   //包含页脚页
?>
</body>

</html>
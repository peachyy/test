<?php
require_once("login.func.php");
require_once("login.inc.php");
require_once("update.inc.php");
if($_SESSION['loginok']){
	header('Location:client/index.php?module=view&action=index');
	exit;
}
$height=($_SESSION['login_errnum']>=3)?'37px':'45px';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 transitional//EN" "http://www.w3.org/tr/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=($domain_purchase['corpname']? $domain_purchase['corpname']: '邮件服务器')?> </title>
<style type="text/css">
<!--
body {
	margin:0;
	padding:0;
	font-size:12px;
	font-family:Arial, Helvetica, sans-serif;
	color:#333333;
	background:#FFFFFF;
}
div ul, div ul li {
	margin:0px;
	padding:0px;
	list-style:none;
}
img {
	border:0px;
}
a:link {
	color:#333333;
	text-decoration:none;
}
a:visited {
	color:#333333;
	text-decoration:none;
}
a:hover {
	color:#FF9900;
	text-decoration:none;
}
.color01 {
	color:#3399CC;
}
.container {
	width:809px;
	height:600px;
	overflow:hidden;
	margin:0 auto;
}
.logo {
	position:relative;
	top:20px;
	height:47px;
}
.logo ul li {
	float:left;
}
.right {
	width:460px;
	text-align:right;
	position:relative;
	right:20px;
}
.main {
	clear:both;
}
.main div {
	float:left;
}
.main_left {
	width:809px;
}
.main_left01 {
	height:76px;
}
.main_left02 {
    width:809px;
	height:223px;
	background:url(<?if($logo_info['login_bg']): echo($logo_info['login_bg']); else:?>images/login9/bg.jpg<?endif;?>);
}
.main_left03 {
	height:7px;
}
.main_left04 {
	height:121px;
	background:url(images/login9/login_25.gif) no-repeat left;
}
.main_left05 {
	padding:20px 0 0 120px;
}
.main_left05 ul li {
	height:40px;
	line-height:40px;
}
.main_center {
	width:373px;
	z-index:50;
	position:relative;
	left:417px;
	top:-440px;
  
}
.main_center_top { 
	height:71px;
	width:100%;
	background:url(images/login9/login_01.gif) no-repeat bottom;
	text-indent:280px;
}
.main_center_main {
	height:341px;
	width:100%;
	background:url(images/login9/login_02.jpg);
}
.main_center_main01 {
	padding:10px 0 0 30px;
}
.Login {
	padding-top:20px;
}
*html .Login {
	padding-top:22px;
}
.main_center_bott {
	height:24px;
	width:100%;
	background:url(images/login9/login_03.gif);
}
.main_right {
	width:19px;
}
.main_rightbg {
	height:223px;
	background:url(images/login9/bg01.jpg);
}
.login_table_text1_input {
	width:172px;
	border:#0a8fda 1px solid;
	background-color:#E8F9FF;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:14px;
	padding:5px 3px
}
.login_table_code_input{
	width:85px;
	border:#0a8fda 1px solid;
	background-color:#E8F9FF;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:14px;
	padding:5px 3px
}
.login_table_select {
	width:180px;
	height:22px;
	border:1px solid #84a1bd;
	float:left
}
.cop {
	clear:both;
	height:8px;
	background:#2d8819;
	position:relative;
	top:-400px;
}
.CopyRight {
	text-align:center;
	line-height:20px;
	position:relative;
	top:-380px;
}
.code-img{
	margin:-10px 0 0 0;
}
-->
</style>
<script type="text/javascript">
<!--
if(top.location !== self.location) {
    top.location = self.location;
}
window.onload=function (){
	<?if($domain_info['customfieldenable'] == 'on'):?>
	document.getElementById("customfieldvalue").focus();
	<?else:?>
    document.getElementById("user").focus();

	//记住用户名功能
	var login_name = getCookie('login_name');
	if(login_name != undefined && login_name != '') {
		document.getElementById("user").value = login_name;
		document.getElementById("remuser").checked = true;
	}
	<?endif;?>

	//自动更换每月图片
	var month_img = document.getElementById("month_img");
	var month = new Date().getMonth() + 1;
	month = month < 10? '0' + month: month;
	month_img.src = "images/login9/login_month" + month + ".gif";
}

function getCookie(VarName) {
	var VarName;
	var CookieFound = false;
	var CookieString = document.cookie;

	var aCookieString = CookieString.split('; ');
	for(var i=0; i<aCookieString.length; i++) {
		j = aCookieString[i].indexOf('=');
		if(VarName == aCookieString[i].substring(0,j))
			return aCookieString[i].substr(j+1);
	}
}

function get_host_address(domain) {
	var domain;

	if(location.hostname.match(/^([0-9.]+)$/)) {
		domain = 'mail' + '.' + domain;
	} else {
		var host_tmp = location.hostname.split('.');
		domain = host_tmp[0] +'.'+ domain;
	}

	if(location.port == 80) {
		return domain;
	} else {
		return domain + ':' + location.port;
	}
}

function loginCheck(form) {
    if (form.user.value == "") {
        alert("邮件帐号不能为空！");
        form.user.focus();
        return false;
    }
    if (form.password.value == "") {
        alert("登录密码不能为空！");
        form.password.focus();
        return false;
    }
	if(form.domain.value == '') {
        alert("请选择邮件域名！");
        return false;
	} else {
		//form.action = "http://" + get_host_address(form.domain.value) + "<?=$_SERVER['REQUEST_URI']?>";
	}

	return true;
}
function show_code() {
	var img=document.getElementById('imgcode');
	img.src="captcha.php?t="+new Date().getTime(); 
}
//-->
</script>
</head>
<body>
<div class="container">
	<div class="logo">
		<ul>
			<li>
				<?if($logo_info['login_logo']):?>
				<img title="企业电子邮件中心" src="<?=$logo_info['login_logo']?>" />
				<?else:?>
				<img title="企业电子邮件中心" src="images/login9/logo.gif" />
				<?endif;?>
			</li>
			<li class="right">
				<a title="设为首页" href="#" onclick="this.style.behavior='url(#default#homepage)';this.setHomePage('<?php echo ($_SERVER['HTTPS']=='off'?'http://':'https://').$domain.$_SERVER['REQUEST_URI'];?>');">设为首页</a>
				<?php if($domain_info['applyenable'] == 'on'){ ?><a title="注册" href="#" onclick="window.open('applybefore.php')">注册</a><?php } ?>
				<?if($webmail_modules['show_admin_link'] <> 'off'):?>
				<a title="管理员登录" href="admin/index.php">管理员登录</a>
				<?endif;?>
				<a title="帮助" href="help/email-help-home.htm">帮助</a>
			</li>
		</ul>
	</div>

	<div class="main">
		<div class="main_left">
			<ul>
				<li class="main_left01"></li>
				<li class="main_left02"></li>
				<li class="main_left03"></li>
				<li class="main_left04">
					<div class="main_left05">
						<ul>
							<li><img src="images/login9/login_33.jpg" align="absmiddle" />&nbsp;&nbsp;精准反垃圾，有效过滤超过98.6%的<span class="color01">垃圾邮件</span>；</li>
							<li><img src="images/login9/login_37.jpg" align="absmiddle"  />&nbsp;&nbsp;<span class="color01">病毒邮件</span>有效拦截率超过99.9%；</li>
						</ul>
					</div>
				</li>
			</ul>
		</div>
		<div class="main_center">
		<div class="main_center_top"><img id="month_img" src="images/blank.gif"/></div>
		<div class="main_center_main">
 			<div class="main_center_main01">
				<ul>
				<li><img src="images/login9/login_11.gif" title="登录企业邮箱" /></li>
				<li class="Login">

					<form name="form" method="post" action="/webmail/client/index.php?module=operate&action=login" onsubmit="return loginCheck(this);">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<?if($domain_info['customfieldenable'] == 'on'):?>
					<tr>
						<td class="color01" width="80" align="right"><?=$domain_info['customfieldname']?></td>
						<td>&nbsp;&nbsp;<input class="login_table_text1_input" type="text" name="customfieldvalue" id="customfieldvalue" maxlength="50" style="font-weight:bold; font-family:Verdana, Arial, Helvetica, sans-serif" /></td>
					</tr>
					<?else:?>
					<tr>
						<td class="color01" width="80" align="right">登录帐号</td>
						<td>&nbsp;&nbsp;<input class="login_table_text1_input" type="text" name="user" id="user" maxlength="50" style="font-weight:bold; font-family:Verdana, Arial, Helvetica, sans-serif" /></td>
					</tr>
					<?endif;?>
					<tr>
						<td colspan="2" height="4px"></td>
					</tr>
					<tr>
						<td height="20px"></td>
						<td style=" padding-left:6px;">
							<?if(checkDomainVisit()):?>
							<strong style="letter-spacing:1px;">&nbsp;&nbsp;<?php echo "@". $domain_name;?></strong>
							<input type="hidden" name="domain" value="<?=$domain_name?>" />
							<?else:?>
							<select name="domain"  class="login_table_select" style="height:auto; font-family:Verdana, Arial, Helvetica, sans-serif; line-height:14px;">
							<?=getDomainSelect()?>
							</select>
							<?endif;?>
						</td>
					</tr>
					<tr>
						<td class="color01" width="80" align="right" height="<?=$height?>">登录密码</td>
						<td>&nbsp;&nbsp;<input class="login_table_text1_input" type="password" name="password"  maxlength="50" style="font-weight:bold; font-family:Verdana, Arial, Helvetica, sans-serif"/></td>
					</tr>
					<?php if($_SESSION['login_errnum']>=3):?>
					<tr>
						<td class="color01" width="80" align="right" height="32px">验&nbsp;&nbsp;证&nbsp;&nbsp;码</td>
						<td >
							&nbsp;&nbsp;<input class="login_table_code_input" type="text" name="code" id="user" size="10" maxlength="10" style="font-weight:bold; font-family:Verdana, Arial, Helvetica, sans-serif" />
							<a href="javascript:show_code();" title="点击刷新验证码"><img id="imgcode" src="captcha.php" class="code-img"/></a>
						</td>
					</tr>
					<?php endif;?>
					<tr>
						<td class="color01" width="80" align="right" height="<?=$height?>">语&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;言</td>
						<td style=" padding-left:6px;">
							<select class="login_table_select" name="language" style="height:auto; font-family:Verdana, Arial, Helvetica, sans-serif; line-height:14px;">
							<option value="ZH" selected="selected">　 　　简体中文</option>
							<option value="tw">　 　　繁体中文</option>
							<option value="en">　 　　English</option>
							</select>
						</td>
					</tr>
					<tr>
						<td></td>
						<td height="45px" style="line-height:20px;">
							<table>
							<tr>
								<?if($domain_info['customfieldenable'] <> 'on'):?>
								<td><input name="remuser" id="remuser" type="checkbox" style="float:left" align="absmiddle" />&nbsp;记住用户名</span></td>
								<?endif;?>
								<td><input name="ssl" type="checkbox" style="float:left" align="absmiddle" />&nbsp;SSL安全登录</td>
							</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="padding-left:60px;">
							<input name="enter" type="hidden" value='true' />
							<input title="登录邮箱" value="" type="submit" style="background-image:url(images/login9/login_18.gif);BORDER-bottom: medium none;BORDER-left: medium none;BORDER-right: medium none; BORDER-TOP: medium none; width:86px; height:33px;"/>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input name="getpass" title="忘记密码" value="" type="button" onclick="window.open('getpass.php')" style="background-image:url(images/login9/login_20.gif);BORDER-bottom: medium none;BORDER-left: medium none;BORDER-right: medium none; BORDER-TOP: medium none; width:86px; height:33px;"/>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="height:10px; background:url(images/login9/line.gif) no-repeat"></td>
					</tr>
					<tr>
						<td colspan="2" style="line-height:20px; text-indent:70px;">SMTP： <?php echo"$domain";?></td>
					</tr>
					<tr>
						<td colspan="2" style="line-height:20px; text-indent:70px;">POP3： <?php echo"$domain";?></td>
					</tr>
					</table>
					</form>

				</li>
				</ul>
			</div>
		</div>
		<div class="main_center_bott">&nbsp;</div>
	</div>
</div>
<div class="cop"></div>
<div class="CopyRight">
	当前时间: <?php echo $date;?><br />
	CopyRight © <?php echo $domain_purchase['corpname'];?> 2009&nbsp;&nbsp;<a href="http://www.comingchina.com">Power by U-Mail</a></div>
</div>
</body>
</html>

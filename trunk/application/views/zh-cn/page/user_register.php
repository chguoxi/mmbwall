<div id="box">

	<nav class="login_nav" id="wz_nav">
		<a href="<?php echo site_url('login')?>" class="backbtn"><img
			src="<?php echo $common_theme_path?>images/alogin_button-2.gif"
			width="28" height="26" /></a> <a
			href="<?php echo site_url('register')?>" class="loginbtn">注册</a> <a
			href="<?php echo site_url()?>" class="rightbtn"><img
			src="<?php echo $common_theme_path?>images/alogin_button-8.gif"
			width="32" height="26" /></a>
		<div class="cboth"></div>
	</nav>

	<div id="wz_center">
		<div class="wz_a">

			<div class="zc_a_center">
				<div class="zc_wz">
					<img
						src="<?php echo $common_theme_path?>images/alogin_button-9.gif"
						width="85" height="93" /><span>我们将为您跳转至电脑版注册界面</span>
				</div>
				<div class="zc_login">
					<p>
						<a href="<?php echo site_url('login')?>">
							<img src="<?php echo $common_theme_path?>images/button.gif" width="100" /></a>
						<a href="<?php echo $register_url?>"><img
							src="<?php echo $common_theme_path?>images/alogin_button-6.gif" width="100" /></a>
					</p>
				</div>
			</div>
		</div>
		<div class="fhdb"></div>
	</div>
	<div id="index_bottom"></div>

</div>
<?php echo $footer;?>
<script>
//setTimeout(" window.location.href=\"<?php echo $register_url?>\";",10000);
</script>
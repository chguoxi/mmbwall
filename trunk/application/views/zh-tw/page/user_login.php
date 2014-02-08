<div id="box">

	<nav class="login_nav" id="wz_nav">
		<a class="backbtn" href="<?php echo site_url()?>"><img width="28"
			height="26" src="<?php echo $image_path?>icon.gif"></a> <a
			class="loginbtn" href="<?php echo site_url('login')?>">登陸</a> <a
			class="rightbtn" href="<?php echo site_url('register')?>">註冊</a>
	</nav>

	<div id="wz_center">
		<div class="wz_a">
			<div class="wz_a_top"></div>
			<div class="login_a_center">

				<form action="<?php echo site_url('user/login')?>" method="post"
					id="login_form">
					<div class="" id="show_tips"></div>
					<fieldset>
						<ul>
							<li><input name="loginid" type="text" class="input_a" required />
							</li>
							<li><input name="passwd" type="password" class="input_b"
								required /></li>
							<li class="login_button"><button type="button" id="login_button">
									<img
										src="<?php echo $image_path?>login_button.gif" />
								</button>
								<?php echo anchor('forgotpassword','忘記密碼?')?></li>
						</ul>
					</fieldset>
				</form>

			</div>
			<div class="wz_a_bottom"></div>
		</div>
		<div class="fhdb"></div>
	</div>
	<div id="index_bottom"></div>
</div>
<?php echo $footer;?>
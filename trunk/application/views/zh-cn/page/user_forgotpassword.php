
	<nav id="wz_nav" class="login_nav">
            <a href="<?php echo site_url('login')?>" class="backbtn" ><img src="<?php echo $common_theme_path?>images/login_icon.gif" width="28" height="26" /></a>
            <a href="<?php echo $findpassword_url?>" class="loginbtn">找回密码</a>
            <a href="<?php echo site_url()?>" class="rightbtn"><img src="<?php echo $common_theme_path?>images/icon.gif" width="32" height="26" /></a>		
	</nav>

<div id="box">
    <div id="wz_center">
       
            <div class="login_a_center range">
                <div class="zhmm_wz">
                    <img src="<?php echo $common_theme_path?>images/icon3.gif" width="67" height="76" />
                    &nbsp;&nbsp;<span><a href="#">请用户访问中国LED在线PC版</a> <a href="<?php echo $findpassword_url?>" id="findpass">找回密码</a>
                    </span>
                    
                    <p class="zhmm_fontbold"></p>
                </div>
                <div class="zc_login"><a href="<?php echo site_url('login')?>"><img src="<?php echo $common_theme_path?>images/alogin_button-7.gif" /></a></div>  
             </div>
        
        <div class="fhdb"></div>
    </div>

</div>
<?php echo $footer;?>
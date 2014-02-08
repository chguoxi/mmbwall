<footer id="footer">
        <span><a href="#" >返回頂部&nbsp;<img src="<?php echo $image_path?>bottom_icon.gif" width="13" height="27" /></a></span>
        <p class="footer_nav">
		<a href="<?php echo $pc_site_url?>">電腦版</a>| <a href="<?php echo site_url()?>" style="color:#999999" >3G版</a>|
		<?php if (!is_login()):?>
		<a href="<?php echo site_url('login')?>?redirect=<?php echo uri_string()?>">登入</a>
		<?php else:?>
		<a href="<?php echo site_url('logout')?>">登出</a>
		<?php endif;?>
		| <br> <a href="https://www.facebook.com/healthworldno1">臉書粉絲團</a>|
		<a href="https://plus.google.com/103695293060253502698/posts">Google+</a>
       </p>
</footer>
<script src="<?php echo $script_path?>common.js"></script>
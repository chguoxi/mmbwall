<footer id="footer">
        <span><a href="#" >返回顶部&nbsp;<img src="<?php echo $common_theme_path?>images/bottom_icon.gif" width="13" height="27" /></a></span>
        <p class="footer_nav">
		<a href="<?php echo $pc_site_url?>">电脑版</a>| <a href="<?php echo site_url()?>" style="color:#999999" >3G版</a>|
		<?php if (!is_login()):?>
		<a href="<?php echo site_url('login')?>">登陆</a>
		<?php else:?>
		<a href="<?php echo site_url('logout')?>">退出</a>
		<?php endif;?>
		| <br> <a href="http://weibo.com/ledinside">新浪微博</a>|
		<a>微信ID：中国LED在线</a>
       </p>
</footer>
<script src="<?php echo $common_theme_path?>js/common.js"></script>
<?php require_once 'cs.php';echo '<img src="'._cnzzTrackPageView(5787642).'" width="0" height="0"/>';?>
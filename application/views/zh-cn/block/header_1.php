<header>
	<div id="logo">
		<div id="logo_left">
			<img src="<?php echo $common_theme_path?>images/logo.gif" />
		</div>
		<div id="logo_right" class="version">
			<div></div>
			<div></div>
			<div></div>
		</div>
		<div class="cboth"></div>
	</div>
	<nav class="main_nav">
		<a href="<?php echo site_url('')?>"
			class="nav_home <?php if ($catetype=='all') echo 'current '?>" >全部</a> 
			<a href="<?php echo site_url('node/page/news')?>"
			class="nav_news <?php if ($catetype=='news') echo 'current '?>">资讯</a> <a
			href="<?php echo site_url('node/page/marketanalyze')?>"
			class="nav_analyze <?php if ($catetype=='marketanalyze') echo 'current '?>">市场研究</a>
		<a href="<?php echo site_url('node/page/pricequotes')?>"
			class="nav_price <?php if ($catetype=='pricequotes') echo 'current '?>">价格分析</a>
	</nav>
</header>
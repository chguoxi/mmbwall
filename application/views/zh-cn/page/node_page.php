<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<header>
<?php $this->load->view(SITE_LANG.'/block/header')?>
<nav id="nav">
		<ul>
			<li><a href="<?php echo site_url('node/page/pricequotes')?>"
				class="<?php if ($catetype=='pricequotes') echo 'on2 '?>">价格分析</a></li>
			<li><a href="<?php echo site_url('node/page/marketanalyze')?>"
				class="<?php if ($catetype=='marketanalyze') echo 'on2 '?>">市场研究</a></li>
			<li><a href="<?php echo site_url('node/page/news')?>"
				class="<?php if ($catetype=='news') echo 'on2 '?>">资讯</a></li>
			<li><a href="<?php echo site_url('')?>"
				class="<?php if ($catetype=='all') echo 'on2 '?>">首页</a></li>
		</ul>
	</nav>
</header>
<div class="content">

	<div class="boxtit2"><?php echo $catename?></div>
	<div class="boxnr article-list">
	<?php if (count($nodes)):?>
	    <ul id="node_page_list">
	    	<?php foreach ($nodes as $node):?>
	    		<li><?php echo anchor('node/view/'.$node->nid,$node->title)?></li>
	    	<?php endforeach;?>
			
	    </ul>
	<?php endif;?>
</div>
</div>
<div class="button1"  style="padding-top: 10px;">
	<a page="0" id="get_more" type="<?php echo $catetype?>" href="javascript:void(0)"><img
		src="<?php echo $common_theme_path?>images/button4.gif" width="219"
		height="46" /></a>
</div>
</div>
<?php echo $footer;?>
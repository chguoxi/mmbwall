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
	<div class="new_box">
		<a href="<?php echo site_url()?>">首页</a><span>></span><a
			href="<?php echo site_url('node/page/'.$catetype)?>"><?php echo $catename?></a><span>></span><a
			class="on3">正文</a>
	</div>
	<p class="font_bt2">
		<?php echo anchor('node/view/'.$node->nid,$node->title)?>
	</p>
	<p class="date">
		<a href="#"></a><?php echo date('Y-m-d H: i',$node->timestamp)?>
	</p>

	<div class="nr_wz">
		<article>
			<?php if (isset($node->node_img) && !empty($node->node_img)):?>
			<section class="new_img">
				<img src="<?php echo $node->node_img?>" />
			</section>
			<?php endif;?>
			<section class="wz_font16"><?php echo $node->teaser?></section>
			<?php if (!is_login() && $node->type=='research'):?>
			<section class="scfx_botton" >
				<a href="<?php echo site_url('login')?>/?redirect=/node/view/<?php echo $node->nid?>"></a>
			</section>
			<?php else :?>
			<section class="wz_font16"><?php echo $node->body?></section>
			<?php endif;?>
			
			<?php $this->load->view(SITE_LANG.'/block/social_share')?>
			
		</article>
	</div>
	<div class="box">
		<div class="boxtit">评论</div>
		<section><?php $this->load->view(SITE_LANG.'/block/sina_t_comment')?></section>
	</div>
	<div class="box">
		<div class="boxtit">推荐文章</div>
		<div class="boxnr article-list">
		<?php if (count($recommend)):?>
			<ul>
				<?php foreach ($recommend as $rnode):?>
					<li><?php echo anchor('node/view/'.$rnode->nid,$rnode->title)?></li>
				<?php endforeach;?>
			</ul>		
		<?php endif;?>

		</div>
	</div>
	
</div>

<?php echo $footer;?>
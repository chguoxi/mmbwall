<?php $this->load->view(SITE_LANG.'/block/fb_lib')?>
<header>
<?php $this->load->view(SITE_LANG.'/block/header')?>
<?php $this->load->view(SITE_LANG.'/block/main_nav')?>
</header>
<div class="content">
	<div class="new_box">
		<a href="<?php echo site_url()?>">首頁</a><span>></span>
		<?php if (!empty($catename)):?>
		<a href="<?php echo site_url('node/page/'.$catetype)?>"><?php echo $catename?></a><span>></span>
		<?php endif;?>
		<a class="on3">正文</a>
	</div>
	<p class="font_bt2">
		<?php echo anchor('node/view/'.$node->post_number,$node->post_title)?>
	</p>
	<p class="date">
		<a href="#"></a><?php echo $node->cr_time?>
	</p>

	<div class="nr_wz">
		<article>
			<?php if (isset($node->photo_url) && !empty($node->photo_url)):?>
			<section class="new_img">
				<img src="<?php echo $node->photo_url?>" />
			</section>
			<?php endif;?>
			<section class="wz_font16"><?php echo $node->post_content?></section>
			<?php $this->load->view(SITE_LANG.'/block/social_share')?>
		</article>
	</div>
	
	<div class="box">
		<div class="boxtit">評論</div>
		<section class="box_pl" style="margin-top:0;">
			<?php $this->load->view(SITE_LANG.'/block/fb_comment')?>
		</section>	
	</div>
	
	<div class="box">
		<div class="boxtit">推薦文章</div>
		<div class="boxnr article-list">
		<?php if (count($recommend)):?>
			<ul>
				<?php foreach ($recommend as $rnode):?>
					<li><?php echo anchor('node/view/'.$rnode->post_number,$rnode->post_title)?></li>
				<?php endforeach;?>
			</ul>		
		<?php endif;?>

		</div>
	</div>
	
</div>

<?php echo $footer;?>
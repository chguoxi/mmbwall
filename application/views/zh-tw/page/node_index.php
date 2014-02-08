<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<header>
<?php $this->load->view(SITE_LANG.'/block/header')?>
<?php $this->load->view(SITE_LANG.'/block/main_nav')?>

</header>
<div class="content">
	<?php if (count($category_nodes)):?>
	<?php foreach ($category_nodes as $key=>$nodes):?>
	<div class="box2">
		<div class="boxtit2"><?php echo $categories[$key]?></div>
		<div class="boxnr2 article-list">
		    <?php if ( isset($nodes[0]->photo_url) && !empty($nodes[0]->photo_url) ):?>
		    <dl>
				<dt>
					<img src="<?php echo $nodes[0]->photo_url?>" width="122"
						height="75" />
				</dt>
				<dd>
		            <?php echo anchor('node/view/'.$nodes[0]->post_id,$nodes[0]->post_title)?>
		        </dd>
			</dl>
			<?php unset($nodes[0])?>
		    <?php endif;?>
		    <ul>
		    	<?php foreach ($nodes as $k=>$node):?>
			    <li><?php echo anchor('node/view/'.$node->post_number,$node->post_title)?></li>
		    	<?php endforeach;?>
		    </ul>
		</div>
		<div class="button1">
			<?php $cate= $key!='issues'?$key:'news';?>
			<a href="<?php echo site_url('column/'.$cate)?>" class="center_btn">進入<?php echo $categories[$key]?>頻道</a>
		</div>
	</div>
	<?php endforeach;?>
	<?php endif;?>
</div>
<?php echo $footer;?>
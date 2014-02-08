<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<header>
<?php $this->load->view(SITE_LANG.'/block/header')?>
<?php $this->load->view(SITE_LANG.'/block/main_nav')?>
</header>
<div class="content">

	<div class="boxtit2"><?php echo $catename?></div>
	<div class="boxnr article-list">
	<?php if (count($nodes)):?>
	    <ul id="node_page_list">
	    	<?php foreach ($nodes as $node):?>
	    		<li><?php echo anchor('node/view/'.$node->post_number,$node->post_title)?></li>
	    	<?php endforeach;?>
			
	    </ul>
	<?php endif;?>
</div>
</div>
<div class="button1"  style="padding-top: 10px;">
	<a page="1" id="get_more" class="center_btn" type="<?php echo $catetype?>" href="javascript:void(0)">查看更多<?php echo $catename?>資訊</a>
</div>

<?php echo $footer;?>
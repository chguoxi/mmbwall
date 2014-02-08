<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
    <?php foreach ($nodes as $key=>$node):?>
		<li><?php echo anchor('node/view/'.$node->nid,$node->title)?></li>
	<?php endforeach;?>
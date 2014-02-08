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
	<!--  
	<div id="banner">
		<img src="<?php echo $common_theme_path?>images/pic.gif">
	</div>	
	-->
	<?php if (count($focus_node)):?>
	<div class="focus-news">
		<p class="aafont"><img src="<?php echo $common_theme_path?>images/focus.png" height="30"/><?php echo anchor('node/view/'.$focus_node->nid,$focus_node->title)?></p>
		<div class="bbfont article-summary" jumpurl="<?php echo site_url('node/view/'.$focus_node->nid)?>"><?php echo $focus_node->teaser?></div>
	</div>		
	<?php endif;?>

	<div class="box">
		<div class="boxtit">资讯</div>
		<div class="boxnr article-list">
			<ul>
				    <?php foreach ($nodes['news'] as $key=>$node):?>
				    	<li><?php echo anchor('node/view/'.$node->nid,$node->title)?></li>
				    <?php endforeach;?>
			    </ul>
		</div>
		<div class="button1">
			<a href="<?php echo site_url('node/page/news')?>"><img
				src="<?php echo $common_theme_path?>images/button1.gif" width="219"
				height="46" /></a>
		</div>
	</div>
	<div class="box2">
		<div class="boxtit2">价格分析</div>
		<div class="boxnr2 article-list">
			<?php $fpricequotes = array_shift($nodes['pricequotes'])?>
		   
		    <?php if (isset($fpricequotes->filepath)&& !empty($fpricequotes->filepath)):?>
		     <dl>
				<dt>
					<img src="<?php echo $fpricequotes->filepath?>" width="122"
						height="75" />
				</dt>
				<dd>
		            <?php echo anchor('node/view/'.$fpricequotes->nid,$fpricequotes->title)?>
		        </dd>
			</dl>
		     <?php endif;?>
		   
		    
		    <ul>
				    <?php foreach ($nodes['pricequotes'] as $key=>$node):?>
				    	<li><?php echo anchor('node/view/'.$node->nid,$node->title)?></li>
				    <?php endforeach;?>
		    </ul>
		</div>
		<div class="button1">
			<a href="<?php echo site_url('node/page/pricequotes')?>"><img
				src="<?php echo $common_theme_path?>images/button2.gif" width="219"
				height="46" /></a>
		</div>
	</div>

	<div class="box2">
		<div class="boxtit2">市场研究</div>
		<div class="boxnr2 article-list">
		<?php $fmarketanalyze = array_shift($nodes['marketanalyze'])?>
		<?php if (isset($fmarketanalyze->filepath)&& !empty($fmarketanalyze->filepath)):?>
	    <dl>
				<dt>
					<img src="<?php echo $fmarketanalyze->filepath?>" width="122"
						height="75" />
				</dt>
				<dd>
	       		<?php echo anchor('node/view/'.$fmarketanalyze->nid,$fmarketanalyze->title)?>
	        </dd>
			</dl>		
		<?php endif;?>

	    <ul>
		    <?php foreach ($nodes['marketanalyze'] as $key=>$node):?>
		    	<li><?php echo anchor('node/view/'.$node->nid,$node->title)?></li>
		    <?php endforeach;?>
	    </ul>
		</div>
		<div class="button1">
			<a href="<?php echo site_url('node/page/pricequotes')?>"><img
				src="<?php echo $common_theme_path?>images/button3.gif" width="219"
				height="46" /></a>
		</div>
	</div>

</div>
<?php echo $footer;?>
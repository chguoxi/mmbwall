<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<nav class="nav">
	<ul>
		<li><a href="<?php echo site_url('')?>"
			class="<?php if ($catetype=='home') echo 'on2 '?>">首頁</a></li>
		<li><a href="<?php echo site_url('column/news')?>"
			class="<?php if ($catetype=='news') echo 'on2 '?>">醫訊情報</a></li>
		<li><a href="<?php echo site_url('column/elderly')?>"
			class="<?php if ($catetype=='elderly') echo 'on2 '?>">銀髮養生</a></li>
		<li><a href="<?php echo site_url('column/food')?>"
			class="<?php if ($catetype=='food') echo 'on2 '?>">樂活飲食</a></li>

	</ul>
</nav>
<nav class="nav ">
	<ul>
		<li><a href="<?php echo site_url('column/relationship')?>"
			class="<?php if ($catetype=='relationship') echo 'on2 '?>">親子天空</a></li>
		<li><a href="<?php echo site_url('column/sick')?>"
			class="<?php if ($catetype=='sick') echo 'on2 '?>">疾病不上身</a></li>
		<li><a href="<?php echo site_url('column/times')?>"
			class="<?php if ($catetype=='times') echo 'on2 '?>">醫藥新時代</a></li>
		<li><a href="<?php echo site_url('column/skin')?>"
			class="<?php if ($catetype=='skin') echo 'on2 '?>">美體美膚</a></li>
	</ul>
</nav>
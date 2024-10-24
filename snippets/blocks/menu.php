<?php

/**
 * Available variables:
 * Block-variables.
 */

// build html-attributes
$attrs = Html::attr([
	'class' => 'menu'
], false, ' ');

?>
<div<?= $attrs ?>>
	<?= $site->menu($block) ?>
</div>
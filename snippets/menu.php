<?php

/**
 * Available variables:
 * string	$attrs	HTML-Attributes of the root element as a ready-made string prefixed with a space.
 * string $entriesHtml	HTML of all entries (and children).
 * string $listTag	HTML-Tag of the list element.
 */

?>
<<?= $listTag ?><?= $attrs ?>>
	<?= $entriesHtml ?>
</<?= $listTag ?>>
<?php

/**
 * Available variables:
 * string	$attrs	HTML-Attributes of the entry element as a ready-made string prefixed with a space.
 * string	$entriesHtml	HTML of all child-entries.
 * string	$linkAttrs	HTML-Attributes of the link-element as a ready-made string prefixed with a space.
 * string	$listTag	HTML-Tag of the list element.
 * string	$listEntryTag	HTML-Tag of the entry element.
 * string	$title	Entry Title.
 * string	$url	Entry URL.
 */

?>
<<?= $listEntryTag ?><?= $attrs ?>>
	<a href="<?= $url ?>"<?= $linkAttrs ?>><?= $title ?></a>
	<?php if ($entriesHtml): ?>
		<<?= $listTag ?>>
			<?= $entriesHtml ?>
		</<?= $listTag ?>>
	<?php endif ?>
</<?= $listEntryTag ?>>
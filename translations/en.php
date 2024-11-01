<?php

return [
	// roles
	'menu.role.visitor' => 'Visitor',

	// block
	'menu.block.name' => 'Menu',
	'menu.block.tab.main.label' => 'General',

	// field
	'menu.field.label' => 'Menus',

	// fields
	'menu.fields.display_name.label' => 'Name',
	'menu.fields.display_name.placeholder' => 'e.g.: Main Menu',
	'menu.fields.display_name.help' => 'Displayed only in the administration.',

	'menu.fields.internal_key.label' => 'Internal Key',
	'menu.fields.internal_key.placeholder' => 'e.g.: meta',
	'menu.fields.internal_key.help' => 'Required to refer to the menu in snippets. Must be unique.',

	'menu.fields.visibility.label' => 'Visibility',
	'menu.fields.visibility.help' => 'The actual visibility also depends on the settings of parent entries.<br>No verification takes place at this point.',
	'menu.fields.visibility.option.none.text' => 'Off',
	'menu.fields.visibility.option.all.text' => 'Everyone',
	'menu.fields.visibility.option.visitor.text' => 'Visitors',
	'menu.fields.visibility.option.admin.text' => 'Administrators',

	'menu.fields.list_tag.label' => 'HTML Tag: List',

	'menu.fields.list_entry_tag.label' => 'HTML Tag: Entry',

	'menu.fields.active_page_css_class.label' => 'CSS-Class: Active Page',
	'menu.fields.active_page_css_class.help' => 'The HTML-Tag of the active internal page receives this CSS-Class.',

	'menu.fields.active_desc_page_css_class.label' => 'CSS-Class: Parent Active Page',
	'menu.fields.active_desc_page_css_class.help' => 'All parent pages HTML-Tags of the active internal page receive this CSS-Class.',

	'menu.fields.entries.label' => 'Entries',
	'menu.fields.link.label' => 'Link',

	'menu.fields.title.label' => 'Title',
	'menu.fields.title.placeholder' => 'Override link text with...',

	'menu.fields.attrs.label' => 'HTML Attributes',
	'menu.fields.attrs.fields.name.label' => 'Name',
	'menu.fields.attrs.fields.name.placeholder' => 'e.g.: class, style',
	'menu.fields.attrs.fields.value.label' => 'Value'
];
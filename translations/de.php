<?php

return [
	// roles
	'menu.role.visitor' => 'Besucher',

	// block
	'menu.block.name' => 'Menü',
	'menu.block.tab.main.label' => 'Allgemein',

	// field
	'menu.field.label' => 'Menüs',

	// fields
	'menu.fields.display_name.label' => 'Name',
	'menu.fields.display_name.placeholder' => 'z.B.: Hauptmenü',
	'menu.fields.display_name.help' => 'Wird nur in der Verwaltung angezeigt.',

	'menu.fields.internal_key.label' => 'Interner Schlüssel',
	'menu.fields.internal_key.placeholder' => 'z.B.: meta',
	'menu.fields.internal_key.help' => 'Wird benötigt, um das Menü in Snippets anzusprechen. Muss einzigartig sein.',

	'menu.fields.visibility.label' => 'Sichtbarkeit',
	'menu.fields.visibility.help' => 'Die tatsächliche Sichtbarkeit hängt auch von der Einstellung übergeordneter Einträge ab.<br>An dieser Stelle findet keine Überprüfung statt.',
	'menu.fields.visibility.option.none.text' => 'Aus',
	'menu.fields.visibility.option.all.text' => 'Alle',
	'menu.fields.visibility.option.visitor.text' => 'Besucher',
	'menu.fields.visibility.option.admin.text' => 'Administratoren',

	'menu.fields.list_tag.label' => 'HTML-Tag: Liste',

	'menu.fields.list_entry_tag.label' => 'HTML-Tag: Eintrag',

	'menu.fields.active_page_css_class.label' => 'CSS-Klasse: Aktive Seite',
	'menu.fields.active_page_css_class.help' => 'Das HTML-Tag der aktiven internen Seite erhält diese CSS-Klasse.',

	'menu.fields.active_desc_page_css_class.label' => 'CSS-Klasse: Übergeordnete aktive Seite',
	'menu.fields.active_desc_page_css_class.help' => 'Alle HTML-Tags von übergeordneten Seiten der internen aktiven Seite erhalten diese CSS-Klasse.',

	'menu.fields.entries.label' => 'Einträge',

	'menu.fields.link.label' => 'Verknüpfung',

	'menu.fields.title.label' => 'Titel',
	'menu.fields.title.placeholder' => 'Text der Verknüpfung überschreiben mit...',

	'menu.fields.attrs.label' => 'HTML-Attribute',
	'menu.fields.attrs.fields.name.label' => 'Name',
	'menu.fields.attrs.fields.name.placeholder' => 'z.B.: class, style',
	'menu.fields.attrs.fields.value.label' => 'Wert'
];
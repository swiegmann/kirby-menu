<?php


Kirby::plugin('swiegmann/menu', [
	'options' => [
		'activeDescPageAttr' => 'aria-activedescendant',
		'activePageAttr' => 'aria-current',
		'deepness' => 3,
		'defaultRoleKeys' => [],
		'listEntryTag' => 'li',
		'listTag' => 'ul',
		'visitorRoleKey' => 'visitor'
	],


	'blueprints' => [
		'blocks/menu' => __DIR__ . '/blueprints/blocks/menu.yml',

		'fields/menu' => __DIR__ . '/blueprints/fields/menu.yml',
		'fields/menu-entries' => function(&$kirby) {
			return include __DIR__ . '/blueprints/fields/menu-entries.php';
		},
		'fields/menu-active-page-attr' => __DIR__ . '/blueprints/fields/menu-active-page-attr.yml',
		'fields/menu-active-desc-page-attr' => __DIR__ . '/blueprints/fields/menu-active-desc-page-attr.yml',
		'fields/menu-attrs' => __DIR__ . '/blueprints/fields/menu-attrs.yml',
		'fields/menu-list-tag' => __DIR__ . '/blueprints/fields/menu-list-tag.yml',
		'fields/menu-list-entry-tag' => __DIR__ . '/blueprints/fields/menu-list-entry-tag.yml',
		'fields/menu-visibility' => function(&$kirby) {
			return include __DIR__ . '/blueprints/fields/menu-visibility.php';
		},

		'tabs/menu' => __DIR__ . '/blueprints/tabs/menu.yml'
	],


	'snippets' => [
		'blocks/menu' => __DIR__ . '/snippets/blocks/menu.php',

		'menu' => __DIR__ . '/snippets/menu.php',
		'menu-entry' => __DIR__ . '/snippets/menu-entry.php'
	],


	'translations' => [
		'de' => require_once __DIR__ . '/translations/de.php',
		'en' => require_once __DIR__ . '/translations/en.php',
	],


	'siteMethods' => [
		/**
		 * Generates HTML-Output from either a block or a field.
		 * When called with field-content the internal-key parameter is required.
		 * 
		 * @param Kirby\Cms\Block|Kirby\Content\Field	$source
		 * @param string|null $internalKey
		 * 
		 * @return string
		 */
		'menu' => function(Kirby\Cms\Block|Kirby\Content\Field $source, string $internalKey = null): string
		{
			$rootEntry = false;

			if (get_class($source) == 'Kirby\Cms\Block') { // called with a block
				$rootEntry = $source;
			} else { // called with a field
				if (!$internalKey) {
					throw new Exception('$site->menu() must be called with an internal name as 2nd parameter when called with a field');
				}

				$entries = $source->toStructure();

				if ($entries->isNotEmpty()) {
					$rootEntry = $entries->findBy('internal_key', $internalKey);
				}

				unset($entries);
			}

			if (
				!$rootEntry
				|| !$this->_menuUserHasRole($rootEntry->content()->get('visibility')->split())
			) {
				return '';
			}

			// get values/set defaults
			$listTag = ($value = $rootEntry->content()->get('list_tag')->value())
				? $value
				: kirby()->option('swiegmann.menu.listTag', 'ul');

			$listEntryTag = ($value = $rootEntry->content()->get('list_entry_tag')->value())
				? $value
				: kirby()->option('swiegmann.menu.listEntryTag', 'ul');

			$activePageAttr = ($value = $rootEntry->content()->get('active_page_attr')->value())
				? $value
				: kirby()->option('swiegmann.menu.activePageAttr', '');

			$activeDescPageAttr = ($value = $rootEntry->content()->get('active_desc_page_attr')->value())
				? $value
				: kirby()->option('swiegmann.menu.activeDescPageAttr', '');			

			// generate children html
			$childEntriesHtml = '';
			$childEntries = $rootEntry->content()->get('entries')->toStructure();

			foreach ($childEntries as &$childEntry) {
				$childEntriesHtml .= $this->_menuEntry(
					entry: $childEntry,
					listTag: $listTag,
					listEntryTag: $listEntryTag,
					activePageAttr: $activePageAttr,
					activeDescPageAttr: $activeDescPageAttr
				);
			}
			
			if (!$childEntriesHtml) {
				return '';
			}

			// build attributes
			$convertedAttrs = [];
			$attrs = $rootEntry->content()->get('attrs')->yaml();
			foreach($attrs as &$attr) {
				$convertedAttrs[$attr['name']] = strlen($attr['value']) ? $attr['value'] : true;
			}
			$attrsHtml = Html::attr($convertedAttrs, false, ' ');

			// generate result
			return snippet('menu', [
				'entriesHtml' => $childEntriesHtml,
				'attrs' => $attrsHtml,
				'listTag' => $listTag
			], true);
		},


		/**
		 * Returns a HTML-String of a menu entry including its child-entries.
		 * Used internally.
		 * 
		 * @param Kirby\Cms\StructureObject	$entry
		 * @param string $listTag	Root HTML-Tag of child-entries
		 * @param string $listEntryTag	HTML-Tag of the entry
		 * @param string $activePageAttr	HTML-Attribute applied to the current Kirby-Page
		 * @param string $activeDescPageAttr	HTML-Attribute applied to Structure-Parents of the current Kirby-Page
		 * 
		 * @return string
		 */
		'_menuEntry' => function(Kirby\Cms\StructureObject $entry, string $listTag, string $listEntryTag, string $activePageAttr, string $activeDescPageAttr): string
		{
			if (!$this->_menuUserHasRole($entry->content()->get('visibility')->split())) {
				return '';
			}

			$linkField = $entry->content()->get('link');
			$linkValue = $linkField->value();
			$url = '';
			$title = '';			
			
			// resolve link-field to a title and url
			$page = false;
			
			// type: page
			if (str_starts_with($linkValue, 'page://')) { 
				if (($page = $this->pages()->find($linkValue)) && $page->isListed()) {
					$title = $page->title();
					$url = $linkField->toUrl();
				}
			}
			
			// type: file
			else if (str_starts_with($linkValue, 'file://')) { 
				if (($page = $this->pages()->index()->files()->find($linkValue)) && $page->isListed()) { // TODO check isListed on $file
					$title = $page->filename();
					$url = $linkField->toUrl();
				}

				$page = false;
			}
			
			// type: url
			else if (str_starts_with($linkValue, 'http://') || str_starts_with($linkValue, 'https://')) {
				$title = $linkValue;
				$url = $linkField->toUrl();
			}
			
			// type: tel
			else if (str_starts_with($linkValue, 'tel:')) {
				$title = $linkValue;
				$url = $linkField->toUrl();
			}
			
			// type: email
			else if (str_starts_with($linkValue, 'mailto:')) {
				$title = $linkValue;
				$url = $linkField->toUrl();
			}
			
			// type: anchor
			else if (str_starts_with($linkValue, '#')) { 
				$title = $linkValue;
				$url = $linkField->toUrl();
			}
			
			// type: everything else
			else {
				$title = $linkValue;
				$url = $linkValue;
			}


			if (!strlen($title) || !$url) {
				return '';
			}
			
			
			// overwrite title
			if (($s = $entry->content()->get('title')->value()) && strlen($s)) {
				$title = $s;
			}
			
			
			// build attributes
			$convertedAttrs = [];
			$attrs = $entry->content()->get('attrs')->yaml();
			foreach($attrs as &$attr) {
				$convertedAttrs[$attr['name']] = strlen($attr['value']) ? $attr['value'] : true;
			}
			
			$convertedAttrs[$activePageAttr] = $activePageAttr && $page && $page->isActive();
			$convertedAttrs[$activeDescPageAttr] = $activeDescPageAttr && $page && !$page->isActive() && $page->isOpen();
			
			$attrsHtml = Html::attr($convertedAttrs, false, ' ');


			// add children
			$childEntries = $entry->content()->get('entries')->toStructure();
			$childEntriesHtml = '';

			foreach ($childEntries as &$childEntry) {
				$childEntriesHtml .= $this->_menuEntry(
					entry: $childEntry,
					listTag: $listTag,
					listEntryTag: $listEntryTag,
					activePageAttr: $activePageAttr,
					activeDescPageAttr: $activeDescPageAttr
				);
			}

			// generate result
			return snippet('menu-entry', [
				'attrs' => $attrsHtml,
				'entriesHtml' => $childEntriesHtml,
				'listTag' => $listTag,
				'listEntryTag' => $listEntryTag,
				'url' => $url,
				'title' => htmlspecialchars($title)
			], true);
		},


		/**
		 * Return the existence of the current user role in given role-keys.
		 * Used internally.
		 * 
		 * @param array	$roles	Kirby role-keys.
		 * 
		 * @return bool
		 */
		'_menuUserHasRole' => function(array $roles): bool
		{
			$role = ($user = kirby()->user())
				? $user->role()->name()
				: kirby()->option('swiegmann.menu.visitorRoleKey', 'visitor');

			return in_array($role, $roles);
		}
	],


  'validators' => [
		/**
		 * Returns true when the amount of unique values of the given key in a field
		 * is equal to the amount of given entries (= each key is unique).
		 * 
		 * @param array	$field
		 * @param array $key
		 * 
		 * @return bool
		 */
    'menuKeyUnique' => function(array $field, string $key): bool
		{
			$values = array_column(
				Yaml::decode($field),
				$key
			);

			return count($values) == count(array_unique($values));
    }
  ]
]);
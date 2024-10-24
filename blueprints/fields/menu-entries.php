<?php

// Programmable Blueprints:
// https://getkirby.com/docs/cookbook/development-deployment/programmable-blueprints


$field = [
  'type' => 'structure',

  'label' => t('menu.fields.entries.label'),

  'columns' => [
    'link' => [
      'width' => '1/1',
      'mobile' => true
    ]
  ],

  'fields' => [
    'visibility' => [
      'extends' => 'fields/menu-visibility'
    ],

    'link' => [
      'type' => 'link',
      'label' => t('menu.fields.link.label'),
      'max' => '1',
      'required' => true,
      'options' => [
        'url',
        'page',
        'file',
        'email',
        'tel',
        'anchor',
        'custom'
      ],
      // 'width' => '2/3'
    ],

    'title' => [
      'type' => 'text',
      'label' => t('menu.fields.title.label'),
      'placeholder' => t('menu.fields.title.placeholder'),
      'counter' => false
    ],

    'attrs' => [
      'extends' => 'fields/menu-attrs'
    ]
  ]
];


$result = $field;


// self-include field according to deepness
$deepness = $kirby->option('swiegmann.menu.deepness', 1);

for($i=1; $i < $deepness; $i++) {
  // add field 'entries' before/after field X
  $original = $result['fields'];
  $before = array_splice($original, 0, array_search('attrs', array_keys($field['fields'])) + 1);
  $insert = array('entries' => $result);
  $result['fields'] = $before + $insert + $original;
  $result = array_merge($field, $result);
}


return $result;
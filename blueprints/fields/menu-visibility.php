<?php

// Programmable Blueprints:
// https://getkirby.com/docs/cookbook/development-deployment/programmable-blueprints

$roles = $kirby->roles()->sort('title');
$visitorRoleKey = $kirby->option('swiegmann.menu.visitorRoleKey', 'visitor');

// try to get the native visitor role
$visitorRole = $roles->findByKey($visitorRoleKey);
$visitorRoleTitle = $visitorRole ? $visitorRole->title() : t('menu.role.visitor');

// build options
$options = [];
$options[] = [
  'value' => $visitorRoleKey,
  'text' => $visitorRoleTitle
];
foreach($roles as &$role) {
  if ($role->name() !== $visitorRoleKey) {
    $options[] = [
      'value' => $role->name(),
      'text' => $role->title()
    ];
  }
}

// build default options
$default = $kirby->option('swiegmann.menu.defaultRoleKeys', []);
if (!$default) { // add all roles
  $default[] = $visitorRoleKey;
  foreach($roles as &$role) {
    if ($role->name() !== $visitorRoleKey) {
      $default[] = $role->name();
    }
  }
}

return [
  'type' => 'multiselect',
  'label' => t('menu.fields.visibility.label'),
  'icon' => 'users',
  'columns' => 3,
  'help' => t('menu.fields.visibility.help'),
  'default' => $default,
  'search' => false,
  'sort' => true,
  'options' => $options
];
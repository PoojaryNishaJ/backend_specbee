<?php

/**
 * @file
 * Provide views data for quick_node_clone.module.
 */

/**
 * Implements hook_views_data_alter().
 */
function fourteenth_views_views_data_alter(&$data) {
  $data['node']['node_link'] = [
    'field' => [
      'title' => t('Node link'),
      'help' => t('Provide a link to the Content.'),
      'id' => 'new_node_clone_link',
    ],
  ];
}

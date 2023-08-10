<?php

namespace Drupal\node_term_user\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

/**
 * Provides a controller for displaying node details.
 */
class NodeTermUser extends ControllerBase {
  /**
   * Displays the node details.
   */
  public function nodeTermUser() {
    $node = Node::load(2);
    if ($node->getType() == 'shapes') {
      $node_title = $node->getTitle();

      $term_entity = $node->get('field_colors')->entity;
      $term_name = $term_entity->getName();

      $user_entity = $term_entity->get('field_user')->entity;
      $username = $user_entity->getAccountName();

      return [
        '#markup' => $node_title . " | " . $term_name . " |  " . $username,
      ];
    }
    return [
      '#markup' => "No valid results found.",
    ];
  }

}

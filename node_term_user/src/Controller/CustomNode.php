<?php

namespace Drupal\node_term_user\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

/**
 * Provides a controller for displaying node details.
 */
class CustomNode extends ControllerBase {

  /**
   * Displays the node details.
   */
  public function customNode() {
    $node = Node::load(2);
    if ($node->getType() == 'shapes') {
      $node_title = $node->getTitle();

      // Get the referenced taxonomy term entity.
      $term_entities = $node->get('field_colors')->referencedEntities()[0];
      $term_name = $term_entities->getName();

      // Get the referenced user entity from the term.
      $user_entities = $term_entities->get('field_user')->referencedEntities()[0];
      $username = $user_entities->getAccountName();

      // Output the result.
      return [
        '#markup' => $node_title . " | " . $term_name . " |  " . $username,
      ];
    }

    // Output if there are no valid results.
    return [
      '#markup' => "No valid results found.",
    ];
  }

}

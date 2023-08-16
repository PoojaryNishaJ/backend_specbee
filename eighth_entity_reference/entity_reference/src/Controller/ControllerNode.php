<?php

namespace Drupal\entity_reference\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

/**
 * Undocumented class.
 */
class ControllerNode extends ControllerBase {

  /**
   * Function.
   */
  public function nodeLoad() {
    $nid = 1;
    $node = Node::load($nid);
    if ($node && $node->getType() === 'shapes') {
      $shape = $node->getTitle();
      $color_term = $node->get('field_colors')->entity;
      $color = $color_term->getName();
      $username = $color_term->get('field_user')->entity->getDisplayName();
      $build = [
        '#markup' => " $shape $color $username",
      ];
      return $build;
    }
  }

}

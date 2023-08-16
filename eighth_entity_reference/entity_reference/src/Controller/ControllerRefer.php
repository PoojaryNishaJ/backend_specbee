<?php

namespace Drupal\entity_reference\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

/**
 * Undocumented class.
 */
class ControllerRefer extends ControllerBase {

  /**
   * Function.
   */
  public function referNode() {
    $nid = 1;
    $node = Node::load($nid);
    if ($node && $node->getType() === 'shapes') {
      $shape = $node->getTitle();

      $color_referred = $node->get('field_colors')->referencedEntities();
      $color_referred_term = reset($color_referred);
      $color = $color_referred_term->getName();

      $user_referred = $color_referred_term->get('field_user')->referencedEntities();
      $user_referred_name = reset($user_referred);
      $username = $user_referred_name->getDisplayName();

      $build = [
        '#markup' => "$shape $color $username",
      ];
      return $build;
    }
  }

}

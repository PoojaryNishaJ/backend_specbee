<?php

namespace Drupal\newdropdown\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for newdropdown routes.
 */
class NewdropdownController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    return $build;
  }

}

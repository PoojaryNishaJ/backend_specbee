<?php

namespace Drupal\custom_table_task\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for Custom table task routes.
 */
class CustomTableTaskController extends ControllerBase {

  /**
  * Builds the response.
  */
  public function build() {
    $query = \Drupal::database()->select('custom_user_details', 'pp')
      ->fields('pp')
      ->execute();
    $rows = [];
    foreach ($query as $row) {
      $rows[] = [
        'id' => $row->id,
        'first_name' => $row->first_name,
        'last_name' => $row->last_name,
        'email' => $row->email,
        'phone_number' => $row->phone_number,
        'gender' => $row->gender,
      ];
    }

    $build = [
      '#theme' => 'new_table',
      '#rows' => $rows,
    ];
    return $build;
  }

}

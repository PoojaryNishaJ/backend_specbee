<?php

namespace Drupal\custom_table_task\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Returns responses for Custom table task routes.
 */
class CustomTableTaskController extends ControllerBase {

  /**
   * Database.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * Constructor for the controller.
   */
  public function __construct(Connection $database) {
    $this->database = $database;
  }

  /**
   * Creates an instance of the controller.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database')
    );
  }

  /**
   * Builds the response.
   */
  public function build() {
    $query = $this->database->select('custom_user_details', 'pp')
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

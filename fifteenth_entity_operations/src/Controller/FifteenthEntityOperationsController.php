<?php

namespace Drupal\fifteenth_entity_operations\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Returns responses for Fifteenth entity operations routes.
 */
class FifteenthEntityOperationsController extends ControllerBase {

  /**
   * The entity type manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Builds the entity manager instance for the given entity type.
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->entityTypeManager = $entityTypeManager;
  }

  /**
   * Returns the entity type manager instance.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * Builds the response.
   */
  public function build($node) {
    // Load the node based on the provided node ID.
    $node = $this->entityTypeManager->getStorage('node')->load($node);

    if ($node) {
      return [
        '#markup' => $node->getTitle(),
      ];
    }
    else {
      throw new NotFoundHttpException();
    }
  }

}

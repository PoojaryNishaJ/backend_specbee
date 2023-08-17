<?php

namespace Drupal\access_controller;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines an AccessControlService service.
 */
class AccessControlService {

  /**
   * The entity type manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected EntityTypeManagerInterface $entityTypeManager;

  /**
   * The current user service.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected AccountInterface $currentUser;

  /**
   * Constructs an AccessControlService object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   The entity type manager.
   * @param \Drupal\Core\Session\AccountInterface $current_user
   *   The current user.
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager, AccountInterface $current_user) {
    $this->entityTypeManager = $entityTypeManager;
    $this->currentUser = $current_user;
  }

  /**
   * The is a create method.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager'),
      $container->get('current_user')
    );
  }

  /**
   * The function to check node access.
   */
  public function checkNodeAccess($node) {
    // Get the selected content types and roles from the form.
    $selectedContentTypes = $form_state->getValue('content_types');
    $selectedRoles = $form_state->getValue('roles');

    // Check if the node's content type matches the selected types.
    if (in_array($node->bundle(), $selectedContentTypes)) {
      // Check if the node's author has any of the selected roles.
      $userRoles = $this->currentUser->getRoles();
      if (array_intersect($userRoles, $selectedRoles)) {
        // Grant access.
        return TRUE;
      }
    }

    // Deny access.
    return FALSE;
  }

}

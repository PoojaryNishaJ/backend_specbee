<?php

namespace Drupal\title_view_mode\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\node\Entity\Node;

/**
 * Provides an example block.
 *
 * @Block(
 *   id = "new_block",
 *   admin_label = @Translation("New Custom Block"),
 *   category = @Translation("New Custom Block"),
 * )
 */
class NewCustomBlock extends BlockBase {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a NewCustomBlock object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['node_title'] = [
      '#type' => 'entity_autocomplete',
      '#title' => $this->t('Title'),
      '#target_type' => 'node',
      '#default_value' => Node::load($this->configuration['node_title']),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['node_title'] = $form_state->getValue('node_title');
  }

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    $node_id = $this->configuration['node_title'];
    $node = $this->entityTypeManager->getStorage('node')->load($node_id);
    $build = [];
    if ($node) {
      $build = [
        '#markup' => $node->label(),
      ];
    }
    return $build;
  }

}

<?php

namespace Drupal\title_view_mode\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
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
    $node = \Drupal::entityTypeManager()->getStorage('node')->load($node_id);
    $build = [];
    if ($node) {
      $build = [
        '#markup' => $node->label(),
      ];
    }
    return $build;

  }

}

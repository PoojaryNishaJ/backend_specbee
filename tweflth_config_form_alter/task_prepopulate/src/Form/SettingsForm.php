<?php

namespace Drupal\task_prepopulate\Form;

use Drupal\Core\Entity\EntityTypeManagerinterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Configure Task prepopulate settings for this site.
 */
class SettingsForm extends ConfigFormBase {


  /**
   * The entity type manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerinterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new SettingsForm object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager service.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'task_prepopulate_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames(): array {
    return ['task_prepopulate.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $config = $this->config('task_prepopulate.settings');

    // Get the term ID from the configuration.
    $term_id = $config->get('tags');
    $term = $this->entityTypeManager->getStorage('taxonomy_term')->load($term_id);

    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#default_value' => $config->get('title'),
    ];

    $form['advanced'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Advanced'),
      '#default_value' => $config->get('advanced'),
    ];

    $form['tags'] = [
      '#type' => 'entity_autocomplete',
      '#title' => $this->t('Tags'),
      '#target_type' => 'taxonomy_term',
      '#target_bundles' => 'tags',
      '#default_value' => $term,
    ];
    // Debug: Print the term value.
    // print_r($term);
    // exit();
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {

    $this->config('task_prepopulate.settings')
      ->set('title', $form_state->getValue('title'))
      ->set('advanced', $form_state->getValue('advanced'))
      ->set('tags', $form_state->getValue('tags'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}

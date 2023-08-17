<?php

namespace Drupal\mail_cron_task\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Mail cron task settings for this site.
 */
class SettingsForm extends ConfigFormBase {
  const RESULT = "mail_cron_task.settings";

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'mail_cron_task_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      static::RESULT,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $config = $this->config(static::RESULT);
    $form['subject'] = [
      '#type' => 'textfield',
      '#title' => 'Subject',
      '#default_value' => $config->get("subject"),
    ];
    $form['text'] = [
      '#type' => 'textfield',
      '#title' => 'Text',
      '#default_value' => $config->get("text"),
    ];

    if (\Drupal::moduleHandler()->moduleExists('token')) {
      $form['tokens'] = [
        '#title' => $this->t('Tokens'),
        '#type' => 'container',
      ];
      $form['tokens']['help'] = [
        '#theme' => 'token_tree_link',
        '#token_types' => [
          'node',
        ],
        '#global_types' => FALSE,
        '#dialog' => TRUE,
      ];
    }
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $config = $this->config(static::RESULT);
    $config->set("subject", $form_state->getValue('subject'));
    $config->set("text", $form_state->getValue('text'));
    $config->save();
  }

}

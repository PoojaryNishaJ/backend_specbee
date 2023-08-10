<?php

namespace Drupal\field_formatter_task\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'field formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "field_formatter_task_field_formatter",
 *   label = @Translation("field formatter"),
 *   field_types = {"integer"},
 * )
 */
class FieldFormatterFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'concat' => 'value after dividing by 100 :  ',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $form['concat'] = [
      '#type' => 'textfield',
      '#title' => 'Concatenate with',
      '#default_value' => $this->getSetting('concat'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $summary[] = $this->t("concatenate with : @concat", ["@concat" => $this->getSetting('concat')]);
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $value = $item->value / 100;
      $concat = $this->getSetting('concat');
      $elements[$delta] = [
        '#markup' => '<p>' . $concat . $value . '</p>',
      ];
    }

    return $elements;
  }

}

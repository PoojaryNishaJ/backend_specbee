<?php

namespace Drupal\thirteenth_form_check_box\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a Thirteenth form check box form.
 */
class ExampleForm extends FormBase {

  /**
   * The logger service.
   *
   * @var \Psr\Log\LoggerInterface
   */
  protected $logger;

  /**
   * The messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * Constructs a new ExampleForm object.
   *
   * @param \Psr\Log\LoggerInterface $logger
   *   The logger service.
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger service.
   */
  public function __construct(LoggerInterface $logger, MessengerInterface $messenger) {
    $this->logger = $logger;
    // Inject the messenger service.
    $this->messenger = $messenger;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('logger.factory')->get('default'),
      $container->get('messenger')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'thirteenth_form_check_box_example';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    // $form['#attached']['library'][] = 'thirteenth_form_check_box/js_lib';
    $form['first_name'] = [
      '#type' => 'textfield',
      '#title' => t('First Name'),
      '#required' => TRUE,
    ];
    $form['no_last_name'] = [
      '#type' => 'checkbox',
      '#title' => t('No Last Name'),
      '#attributes' => ['id' => 'no-last-name'],
    ];

    $form['last_name'] = [
      '#type' => 'textfield',
      '#title' => t('Last Name'),
      '#states' => [
        'visible' => [
          ':input[name="no_last_name"]' => ['checked' => FALSE],
        ],
      ],
    ];

    $form['actions'] = [
      '#type' => 'actions',
      'submit' => [
        '#type' => 'submit',
        '#value' => $this->t('Send'),
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {
    // Validation logic can be added here.
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->logger->warning('Form submitted');
    $this->logger->notice('New Form submitted');
    $this->logger->error('Form submitted!!');

    $this->messenger->addMessage('Form submitted');
  }

}

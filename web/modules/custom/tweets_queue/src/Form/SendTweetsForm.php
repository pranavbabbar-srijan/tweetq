<?php
/**
 * @file
 * Contains \Drupal\tweets_queue\Form\tweetsQueueSettingsForm
 */
namespace Drupal\tweets_queue\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Send tweets queue settings for this site.
 */
class SendTweetsForm extends FormBase {
  /** 
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'send_tweets_form';
  }

  /** 
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['message'] = array(
      '#type' => 'textfield',
      '#title' => t('Tweet your message'),
      '#required' => TRUE,
    );

    $form['markup'] = array(
      '#markup' => $this->t('Authenticate twitter credentials working. '),
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Authenticate Now'),
    );

    return $form;
  }

  /** 
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $data = $form_state->getValues();
    $message = $data['message'];
    tweets_queue_compile_tweets($message);
  }
}

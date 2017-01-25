<?php
/**
 * @file
 * Contains \Drupal\tweets_queue\Form\tweetsQueueSettingsForm
 */
namespace Drupal\tweets_queue\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure tweets queue settings for this site.
 */
class TweetsQueueSettingsForm extends ConfigFormBase {
  /** 
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'tweets_queue_client_settings';
  }

  /** 
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'tweets_queue.settings',
    ];
  }

  /** 
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('tweets_queue.settings');
    $client_info = tweets_queue_fetch_client_handler_info();
    if (isset($_REQUEST['set_cron'])) {
      $this->scheduleNextCron($config->get(CRON_TWEET_MIN_INTERVAL), $config->get(CRON_TWEET_MAX_INTERVAL));
    }
    $form[CONSUMER_KEY] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Consumer key'),
      '#default_value' => tweets_queue_get_client_field_info($client_info, CONSUMER_KEY),
      '#description' => t('Consumer Key is used to authenticate requests to the Twitter Platform.'),
      '#required' => TRUE,
    );

    $form[CONSUMER_SECRET_KEY] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Consumer secret key'),
      '#default_value' => tweets_queue_get_client_field_info($client_info, CONSUMER_SECRET_KEY),
      '#description' => t('Consumer secret Key is used to authenticate requests to the Twitter Platform.'),
      '#required' => TRUE,
    );

    $form[ACCESS_TOKEN] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Access token'),
      '#default_value' => tweets_queue_get_client_field_info($client_info, ACCESS_TOKEN),
      '#description' => t('This access token is used to make API requests on your own account\'s behalf.'),
      '#required' => TRUE,
    );

    $form[ACCESS_SECRET_TOKEN] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Access secret token'),
      '#default_value' => tweets_queue_get_client_field_info($client_info, ACCESS_SECRET_TOKEN),
      '#description' => t('This access secret token is used to make API requests on your own account\'s behalf.'),
      '#required' => TRUE,
    );

    return parent::buildForm($form, $form_state);
  }

  /** 
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $tweet_handler_info = array(
      ACCESS_TOKEN => $form_state->getValue(ACCESS_TOKEN),
      ACCESS_SECRET_TOKEN => $form_state->getValue(ACCESS_SECRET_TOKEN),
      CONSUMER_KEY => $form_state->getValue(CONSUMER_KEY),
      CONSUMER_SECRET_KEY => $form_state->getValue(CONSUMER_SECRET_KEY),
    );
    tweets_queue_update_handler_info($tweet_handler_info);
  }

}

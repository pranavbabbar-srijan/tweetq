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

    $form[CRON_TWEET_LAST_RUN] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Last Cron run time'),
      '#default_value' => tweets_queue_get_client_field_info($client_info, CRON_TWEET_LAST_RUN),
      '#description' => t('Specify the cron run last time.'),
      '#required' => FALSE,
    );
    $now = time();

    $next_run = tweets_queue_get_client_field_info($client_info, CRON_TWEET_NEXT_RUN);
    if ($next_run > $now) {
      $time_left = ($next_run - $now)/60;
      $show_time = intval($time_left) . ' Minutes left';
    }
    else {
      $show_time = '0 Minute left';
    }

    $form[CRON_TWEET_NEXT_RUN] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Next Cron run time'),
      '#default_value' => $show_time,
      '#description' => t('Find the next cron run time.'),
      '#required' => FALSE,
    );
    $retweet_interval = tweets_queue_get_client_field_info($client_info, CRON_TWEET_RETWEET_INTERVAL);
    $retweet_interval = ($retweet_interval == 0) ? 300 : $retweet_interval;
    $form[CRON_TWEET_RETWEET_INTERVAL] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Elapse time for retweet'),
      '#default_value' => $retweet_interval,
      '#description' => t('Specify the time interval for retweet in minutes.'),
      '#required' => FALSE,
    );
    $automated_cron_settings = \Drupal::config('automated_cron.settings');
    $cron_run_interval = $automated_cron_settings->get('interval');
    $cron_time = $cron_run_interval/60;
    $form[CRON_TWEET_CURRENT_INTERVAL] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Current cron run schedule interval'),
      '#default_value' => $cron_time,
      '#description' => t('Find the cron run current interval in minutes.'),
      '#required' => FALSE,
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
      CRON_TWEET_RETWEET_INTERVAL => $form_state->getValue(CRON_TWEET_RETWEET_INTERVAL),
    );
    tweets_queue_update_handler_info($tweet_handler_info);
  }

}

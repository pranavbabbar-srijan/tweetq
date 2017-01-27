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
class TweetsQueueAdminSettingsForm extends ConfigFormBase {
  /** 
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'tweets_queue_admin_settings';
  }

  /** 
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'tweets_queue_admin.settings',
    ];
  }

  /** 
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('tweets_queue_admin.settings');

    if (isset($_REQUEST['set_cron'])) {
      $this->scheduleNextCron($config->get(CRON_TWEET_MIN_INTERVAL), $config->get(CRON_TWEET_MAX_INTERVAL));
    }
    $form[CRON_TWEET_ATTEMP] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Tweet attempt: cron run'),
      '#default_value' => $config->get(CRON_TWEET_ATTEMP, 0),
      '#description' => t('Configure how many times to attempt once cron is run and duplicate tweet is found.'),
      '#required' => TRUE,
    );

    $form[CRON_TWEET_IMPORT_FID] = array(
      '#type' => 'textfield',
      '#title' => $this->t('CSV import File id'),
      '#default_value' => $config->get(CRON_TWEET_IMPORT_FID),
      '#description' => t('Specify the tweet import file path'),
      '#required' => FALSE,
      '#disabled' => TRUE,
    );

    $form[CRON_TWEET_IMPORT_ID] = array(
      '#type' => 'textfield',
      '#title' => $this->t('CSV import ID'),
      '#default_value' => $config->get(CRON_TWEET_IMPORT_ID),
      '#description' => t('Specify the tweet import ID for the import'),
      '#required' => FALSE,
    );

    $form[CRON_TWEET_IMPORT_PATH] = array(
      '#type' => 'textfield',
      '#title' => $this->t('CSV import path'),
      '#default_value' => $config->get(CRON_TWEET_IMPORT_PATH),
      '#description' => t('Specify the tweet import file path'),
      '#required' => FALSE,
    );
    $form[CRON_TWEET_MIN_INTERVAL] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Cron run minimum interval'),
      '#default_value' => $config->get(CRON_TWEET_MIN_INTERVAL),
      '#description' => t('Specify the cron run minimum interval in minutes.'),
      '#required' => FALSE,
    );
    $form[CRON_TWEET_MAX_INTERVAL] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Cron run maximun interval'),
      '#default_value' => $config->get(CRON_TWEET_MAX_INTERVAL),
      '#description' => t('Specify the cron run maximun interval in minutes.'),
      '#required' => FALSE,
    );
    $form[CRON_TWEET_NEXT_RUN] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Next Cron run time'),
      '#default_value' => tweets_queue_get_client_field_info($client_info, CRON_TWEET_NEXT_RUN),
      '#description' => t('Specify the cron run next time.'),
      '#required' => FALSE,
    );
    $form[CRON_SCHEDULER_RUN_INTERVAL] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Scheduler interval'),
      '#default_value' => $config->get(CRON_SCHEDULER_RUN_INTERVAL),
      '#description' => t('Specify the scheduler interval in Minutes.'),
      '#required' => FALSE,
    );
    $form[CRON_SCHEDULER_LAST_RUN] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Scheduler last Run'),
      '#default_value' => $config->get(CRON_SCHEDULER_LAST_RUN),
      '#description' => t('Specifiesthe scheduler last run.'),
      '#required' => FALSE,
    );
    $retweet_interval = intval($config->get(CRON_TWEET_RETWEET_INTERVAL));
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

    $form[CRON_TWEET_DEBUG_INFO] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Current cron run debugging'),
      '#default_value' => $config->get(CRON_TWEET_DEBUG_INFO),
      '#description' => t('Will get execution messages when the cron runs.'),
      '#required' => FALSE,
    );
    return parent::buildForm($form, $form_state);
  }

  /** 
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = \Drupal::service('config.factory')->getEditable('tweets_queue_admin.settings');
    $config->set(CRON_TWEET_ATTEMP, $form_state->getValue(CRON_TWEET_ATTEMP))
      ->save();
    $config->set(CRON_TWEET_IMPORT_ID, $form_state->getValue(CRON_TWEET_IMPORT_ID))
      ->save();
    $config->set(CRON_TWEET_IMPORT_PATH, $form_state->getValue(CRON_TWEET_IMPORT_PATH))
      ->save();
    // $config->set(IMPORT_CONFIGURATION, $form_state->getValue(IMPORT_CONFIGURATION))
      // ->save();
    $config->set(CRON_TWEET_MIN_INTERVAL, $form_state->getValue(CRON_TWEET_MIN_INTERVAL))
      ->save();
    $config->set(CRON_TWEET_MAX_INTERVAL, $form_state->getValue(CRON_TWEET_MAX_INTERVAL))
      ->save();
    $config->set(CRON_TWEET_NEXT_RUN, $form_state->getValue(CRON_TWEET_NEXT_RUN))
      ->save();
    $config->set(CRON_SCHEDULER_RUN_INTERVAL, $form_state->getValue(CRON_SCHEDULER_RUN_INTERVAL))
      ->save();
    $config->set(CRON_SCHEDULER_LAST_RUN, $form_state->getValue(CRON_SCHEDULER_LAST_RUN))
      ->save();
    $config->set(CRON_TWEET_RETWEET_INTERVAL, $form_state->getValue(CRON_TWEET_RETWEET_INTERVAL))
      ->save();
    $config->set(CRON_TWEET_DEBUG_INFO, $form_state->getValue(CRON_TWEET_DEBUG_INFO))
      ->save();

    parent::submitForm($form, $form_state);

  }

  public function scheduleNextCron($min_interval = 30, $max_interval = 60, $extra = 0) {
    $cron_interval = rand($min_interval, $max_interval);
    $cron_interval = $cron_interval * 60;
    \Drupal::configFactory()->getEditable('automated_cron.settings')
    ->set('interval', $cron_interval)
    ->save();
  }
}

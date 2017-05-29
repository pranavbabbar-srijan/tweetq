<?php

namespace Drupal\tweets_queue\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Builds a form to upload sample csv.
 */
class TweetsQueueSampleCsvUploadForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return '_form_tweets_queue_sample_csv_upload';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Elements that take a simple default value.
    $fids[0] = tweets_queue_fetch_twitter_statistics_info(TWITTER_SAMPLE_CSV_FILE);
    $fids_other[0] = tweets_queue_fetch_twitter_statistics_info(TWITTER_SAMPLE_CSV_FILE_OTHER);
    $form['header'] = array(
      '#type' => 'markup',
      '#prefix' => '<div class="create-header">',
      '#markup' => t('Import Tweets'),
      '#suffix' => '</div>',
    );

    $form['import_top'] = array(
      '#type' => 'markup',
      '#prefix' => '<div class="create-header">',
      '#markup' => t(''),
    );

    $form['managed_file'] = array(
      '#type' => 'managed_file',
      '#title' => TWITTER_SAMPLE_CSV_IMPORT_TWEET_LABEL,
      '#default_value' => $fids,
      '#disabled' => FALSE,
      '#description' => TWITTER_SAMPLE_CSV_IMPORT_TWEET_LABEL,
      '#upload_location' => TWEET_QUEUE_CSV_FILE_UPLOAD_DIRECTORY,
      '#progress_message' => $this->t('Please wait...'),
      '#upload_validators' => [
        'file_validate_extensions' => [
          'csv',
        ],
        'file_validate_size' => [
          TWITTER_CSV_UPLOAD_MAX_FILE_SIZE
        ]
      ],
      '#required' => TRUE,
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t(TWITTER_IMPORT_TWEET_LABEL),
    );
    $form['import_bottom'] = array(
      '#type' => 'markup',
      '#markup' => t(''),
      '#suffix' => '</div>',
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $fid = reset($form_state->getValue('managed_file'));
    $file = '';
    if ($fid) {
      $file_path = tweets_queue_get_file_real_path($fid);
      $file = \Drupal::service('file_system')->realpath($file_path);
      // Save file information in the handler.
      tweets_queue_update_twitter_statistics(TWITTER_SAMPLE_CSV_FILE,
        array(
          'value' => $fid,
          'data' => serialize(array()),
        )
      );
    }
  }

}

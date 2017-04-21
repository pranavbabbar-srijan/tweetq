<?php

namespace Drupal\tweets_queue\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Url;
use Drupal\Core\Form\FormStateInterface;

/**
 * Builds a form to test disabled elements.
 */
class TweetsQueueCsvUploadForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return '_form_tweets_queue_csv_upload';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Elements that take a simple default value.
    $client_info = tweets_queue_fetch_client_handler_info();
    $fids[0] = tweets_queue_get_client_field_info($client_info, CRON_TWEET_IMPORT_FID);
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
      '#title' => TWITTER_IMPORT_TWEET_LABEL,
      '#disabled' => FALSE,
      '#description' => TWITTER_CSV_UPLOAD_NOTE_LABEL,
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
      '#attributes' => array(
        'class' => array('beautytips'),
        'title' => t(TWITTER_IMPORT_TWEET_TOOLTIP),
      ),
    );

    $fids[0] = tweets_queue_fetch_twitter_statistics_info(TWITTER_SAMPLE_CSV_FILE);
    $file_path = tweets_queue_get_file_real_path($fids);
    if ($file_path) {
      $file_url = file_create_url($file_path);
      $url = Url::fromUri($file_url);
      $external_link = \Drupal::l(t('Download Sample 1'), $url);
      $form['sample_csv_download'] = array(
        '#type' => 'markup',
        '#prefix' => '<div class="download-csv">',
        '#markup' => t(TWITTER_DOWNLOAD_SAMPLE_CSV_LABEL) . $external_link,
        '#suffix' => '</div>',
      );
    }

    $form['import_bottom'] = array(
      '#type' => 'markup',
      '#markup' => t(''),
      '#suffix' => '</div>',
    );

    return $form;
  }

  /**
   * Function to validate the key if already in use.
   *
   * @params
   *  $title - The key value.
   *  $nid - If the node is getting edited.
   */
  public function getFileRealPath($fid) {
    $uri = '';
    if (empty($fid)) {
      return $uri;
    }
    $query = \Drupal::database()->select('file_managed', 'f');
    $query->addField('f', 'uri');
    $query->condition('f.fid', $fid);
    $uri = $query->execute()->fetchField();
    return $uri;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $fid = reset($form_state->getValue('managed_file'));
    $file = '';
    if ($fid) {
      $file_path = $this->getFileRealPath($fid);
      $file = \Drupal::service('file_system')->realpath($file_path);
      $tweet_handler_info = array(
        CRON_TWEET_IMPORT_FID => $fid,
      );
      // Save file information in the handler.
      tweets_queue_update_handler_info($tweet_handler_info);
    }
    if (empty($file)) {
      $client_info = tweets_queue_fetch_client_handler_info();
      $fids = tweets_queue_get_client_field_info($client_info, CRON_TWEET_IMPORT_FID);
      $file_path = $this->getFileRealPath($fid);
      $file = \Drupal::service('file_system')->realpath($file_path);
    }
    if ($file) {
      $this->importCsvData($file);
    }
  }

  public function importCsvData($file) {
    $uid = \Drupal::currentUser()->id();
    $file = fopen($file, 'r');
    $row = 0;
    $import_message = array('total' => 0, 'duplicate' => 0,
      'imported' => 0 , 'valid' => 0, 'invalid' => 0);
    while (($line = fgetcsv($file)) !== FALSE) {
      if ($row == 0) {
        $row++;
        continue;
      }
      $import_message['total'] = $import_message['total'] + 1;
      $message = (isset($line[0])) ? $line[0] : '';
      $hash_tag = (isset($line[1])) ? $line[1] : '';
      $message = tweets_queue_get_urls_present($message);
      $hash_tag = tweets_queue_get_urls_present($hash_tag);
      if (!empty($hash_tag)) {
        $message = $message . ' ' . $hash_tag;
        $hash_tag = '';
      }
      $size = tweets_queue_calculate_tweet_message_size($message, $hash_tag, 'size');
      $twitter_message_info = array(
        'message' => $message,
        'hashtag' => $hash_tag,
        'uid' => $uid,
        'size' => $size,
      );
      $nid = tweets_queue_check_user_message_presence($message, $hash_tag);
      if ($nid) {
        $import_message['duplicate'] = $import_message['duplicate'] + 1;
        continue;
      }
      if ($size < CRON_TWEET_CHARCATER_LIMIT) {
        $import_message['valid'] = $import_message['valid'] + 1;
      }
      else {
        $import_message['invalid'] = $import_message['invalid'] + 1;
      }
      $import_message['imported'] = $import_message['imported'] + 1;
      tweets_queue_insert_message_queue_record($twitter_message_info);
    }
    fclose($file);
    drupal_set_message(t("@total Import completed successfully.<br></br>Total : @total Imported: @imported Valid: @valid
      Invalid : @invalid Duplicate: @duplicate ",
      array(
        '@total' => $import_message['total'],
        '@imported' => $import_message['imported'],
        '@duplicate' => $import_message['duplicate'],
        '@valid' => $import_message['valid'],
        '@invalid' => $import_message['invalid']
        )
      )
    );
    $_SESSION["valid_import"] = $import_message['valid'];
    $_SESSION["invalid_import"] = $import_message['invalid']; 
    $_SESSION["new"] = "New";
  }

}

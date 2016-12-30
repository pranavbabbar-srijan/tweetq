<?php

namespace Drupal\tweets_queue\Form;

use Drupal\Core\Form\FormBase;
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

    $form['managed_file'] = array(
      '#type' => 'managed_file',
      '#title' => 'Import CSV',
      '#default_value' => $fids,
      '#disabled' => FALSE,
      '#upload_location' => TWEET_QUEUE_CSV_FILE_UPLOAD_DIRECTORY,
      '#progress_message' => $this->t('Please wait...'),
      '#upload_validators' => [
        'file_validate_extensions' => [
          'csv',
        ],
        'file_validate_size' => [
          '10485760'
        ]
      ],
    );
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Run Import'),
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
    $config = \Drupal::service('config.factory')->getEditable('tweets_queue_admin.settings');
    $import_id = $config->get(CRON_TWEET_IMPORT_ID);
    $fid = reset($form_state->getValue('managed_file'));
    $file = '';
    if ($fid) {
      $file_path = $this->getFileRealPath($fid);
      $file = \Drupal::service('file_system')->realpath($file_path);

      $tweet_handler_info = array(
        CRON_TWEET_IMPORT_FID => $fid,
      );
      tweets_queue_update_handler_info($tweet_handler_info);
      // $this->setCsvFilePath($file, $import_id);
    }
    if (empty($file)) {
      $client_info = tweets_queue_fetch_client_handler_info();
      $fids = tweets_queue_get_client_field_info($client_info, CRON_TWEET_IMPORT_FID);
      $file_path = $this->getFileRealPath($fid);
      $file = \Drupal::service('file_system')->realpath($file_path);
    }
    if ($file && $import_id) {
      $this->runCsvImport($file, $import_id);
    }
  }

  public function runCsvImport($file, $import_id = 'tweets_queueing') {
    module_load_include('inc', 'migrate_tools', 'migrate_tools.drush');
    module_load_include('inc', 'tweets_queue', 'library/context');
    module_load_include('inc', 'tweets_queue', 'library/drush');
    module_load_include('inc', 'tweets_queue', 'library/output');
    module_load_include('inc', 'tweets_queue', 'library/drupal');

    if ($file && $import_id && function_exists('drush_get_option')) {
      drupal_set_message("Migration successfully completed.");
      $this->setFilePathConfiguration($table = 'config', $import_id, $file);
      drush_migrate_tools_migrate_import($import_id);
    }
  }

  public function setCsvFilePath($file, $name = 'tweets_queueing') {
    $fid = '';
    if ($cache = \Drupal::cache()->get($cid)) {
      $fid = $cache->data;
    }
    $table = 'config';
    return $fid;
  }

  public function updateFilePathConfiguration($table = 'config', $data, $class_name) {
    // Update the entry in the DB to ensure that result caching works.
    \Drupal::database()->update($table)
      ->condition('name', $class_name)
      ->fields(['data' => $data])
      ->execute();
  }

  public function getMigrationClassName($class) {
    $class_name = '';
    if (empty($class)) {
      return $class_name;
    }
    $class_name = 'migrate_plus.migration.' . $class;
    return $class_name;
  }

  public function setFilePathConfiguration($table = 'config', $class = 'tweets_queueing', $file) {
    $class_name = $this->getMigrationClassName($class);

    $query = \Drupal::database()->select($table, 'n');
    $query->fields('n', ['data']);
    $query->condition('n.name', $class_name);
    $data = unserialize($query->execute()->fetchField());

    if(isset($data['source']['path']) && $file) {
      $data['source']['path'] = $file;
      $data = serialize($data);
      $this->updateFilePathConfiguration($table, $data, $class_name);
      $this->updateFilePathConfiguration('config_snapshot', $data, $class_name);
      $this->deleteFilePathConfiguration('cache_config', 'cid', $class_name);
      $this->deleteFilePathConfiguration('cache_discovery', 'cid', 'migration_plugins');
    }
  }

  public function deleteFilePathConfiguration($table, $field_name = 'cid', $field_value) {
    // Delete the entry in the DB to ensure that result caching works.
    \Drupal::database()->delete($table)
        ->condition($field_name, $field_value)
        ->execute();
  }
}

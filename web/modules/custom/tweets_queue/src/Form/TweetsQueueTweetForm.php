<?php
/**
 * @file
 * Contains \Drupal\tweets_queue\Form\TweetsQueueTweetForm
 */
namespace Drupal\tweets_queue\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Builds a form to test disabled elements.
 */
class TweetsQueueTweetForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return '_form_tweets_queue_tweet_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Elements that take a simple default value.
    $client_info = tweets_queue_fetch_client_handler_info();
    $fids[0] = tweets_queue_get_client_field_info($client_info, CRON_TWEET_IMPORT_FID);

    $form['message'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Tweet Message'),
      '#default_value' => '',
      '#description' => t('Twitter tweet message'),
      '#required' => TRUE,
    );
    $form['hashtag'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Hashtag'),
      '#default_value' => '',
      '#description' => t('Twitter hashtag'),
      '#required' => FALSE,
    );
    $form['status'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Published Status'),
      '#default_value' => '',
      '#description' => t('Published status'),
      '#required' => FALSE,
    );
    $form['archived'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Archived'),
      '#default_value' => '',
      '#description' => t('Archived status'),
      '#required' => FALSE,
    );
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Save'),
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $uid = \Drupal::currentUser()->id();
    $nid = intval($form_state->getValue('nid'));
    $message = $form_state->getValue('message');
    $hashtag = $form_state->getValue('hashtag');
    $status = $form_state->getValue('status');
    $archived = $form_state->getValue('archived');
    drupal_set_message(t('Your message @message', array('@message' => $message)));
    drupal_set_message(t('Your message @hashtag', array('@hashtag' => $hashtag)));
    drupal_set_message(t('Your message status @status', array('@status' => $status)));
    drupal_set_message(t('Your message archived @archived', array('@archived' => $archived)));
    if (!$nid) {
      $size = tweets_queue_calculate_tweet_message_size($message, $hashtag, 'size');
      $twitter_message_info = array(
        'message' => $message,
        'hashtag' => $hashtag,
        'uid' => $uid,
        'size' => $size,
      );
      tweets_queue_insert_message_queue_record($twitter_message_info, $status);
    }
  }

  public function importCsvData($file) { 
  }

}

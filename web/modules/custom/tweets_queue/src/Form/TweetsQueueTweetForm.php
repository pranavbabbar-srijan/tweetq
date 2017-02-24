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
    return 'tweets_queue_tweet_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $nid = $_REQUEST['nid'];
    $tweet_info = tweets_queue_fetch_tweet_item($nid);
    $tweet_id = $tweet_info->tweet_id;
    $archived = $tweet_info->archived;
    $message = $tweet_info->message;
    $size = $size = tweets_queue_calculate_tweet_message_size($message, '', 'size');
    $left = 140 - $size;
    $form['nid'] = array(
      '#type' => 'hidden',
      '#title' => t('Node nid'),
      '#required' => TRUE,
      '#value' => $nid,
    );

    $form['message'] = array(
      '#type' => 'textarea',
      '#title' => t('Edit Tweet'),
      '#required' => TRUE,
      '#value' => $message,
      '#attributes' => array (
        'placeholder' => t("What's happening ?")
      ),
    );
    if (!empty($tweet_id) && !$archived) {
      $form['clone'] = array(
        '#type' => 'submit',
        '#value' => t('Clone and Save'),
        '#submit' => array('tweets_queue_clone_and_save_submit'),
        '#weight' => 9,
      );
    }

    if (empty($tweet_id) && !$archived) {
      $form['submit'] = array(
        '#type' => 'submit',
        '#value' => t('Save Tweet'),
        '#weight' => 9,
      );
    }

    $form['cancel'] = array(
      '#type' => 'submit',
      '#submit' => array('tweets_queue_cancel_edit_submit'),
      '#value' => t('Cancel'),
      '#weight' => 9,
    );

    $form['display_box'] = array(
      '#type' => 'textfield',
      '#size' => 3,
      '#maxlength' => 3,
      '#value' => $left,
      '#required' => FALSE,
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $input = $form_state->getUserInput();
    $uid = \Drupal::currentUser()->id();
    $nid = $input['nid'];
    $message = $input['message'];
    if (!$nid) {
      return;
    }
    $message = tweets_queue_get_urls_present($message);
    $size = $size = tweets_queue_calculate_tweet_message_size($message, '', 'size');
    tweets_queue_update_message_queue_priority_info($nid,
      array(
        'message' => $message,
        'size' => $size,
        'changed' => time(),
      ),
      0
    );
    drupal_set_message(t('Tweet have been saved successfully.'));
  }

}

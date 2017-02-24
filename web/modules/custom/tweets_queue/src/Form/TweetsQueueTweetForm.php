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
    $nid = $_REQUEST['nid'];
    $tweet_info = tweets_queue_fetch_tweet_item($nid);
    $message = $tweet_info->message;
    // echo '<pre>', print_r($tweet_info); die();

    $form['nid'] = array(
      '#type' => 'hidden',
      '#title' => t('Node nid'),
      '#required' => TRUE,
      '#value' => $nid,
    );

    $form['message'] = array(
      '#type' => 'textfield',
      '#title' => t('Edit Tweet'),
      '#required' => TRUE,
      '#value' => $message,
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Save Tweet'),
      '#weight' => 9,
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

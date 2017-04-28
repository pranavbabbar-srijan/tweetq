<?php
/**
 * @file
 * Contains \Drupal\tweets_queue\Form\TweetsQueueTweetForm
 */
namespace Drupal\tweets_queue\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Core\Cache\Cache;

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
    $action = (isset($_REQUEST[TWITTER_ACTION_PARAMETER])) ? $_REQUEST[TWITTER_ACTION_PARAMETER] : TWITTER_EDIT_ACTION;

    if ($action == TWITTER_DELETE_ACTION) {
      $this->deleteForm($form, $form_state);
    }

    if ($action == TWITTER_EDIT_ACTION) {
      $this->editForm($form, $form_state);
    }

    return $form;
  }


  /**
   * {@inheritdoc}
   */
  public function editForm(array &$form, FormStateInterface $form_state) {
    $nid = $_REQUEST['nid'];
    $tweet_info = tweets_queue_fetch_tweet_item($nid);
    $tweet_id = $tweet_info->tweet_id;
    $archived = $tweet_info->archived;
    $message = $tweet_info->message;
    $size = tweets_queue_get_message_size($message);
    $left = 140 - $size;
    $form['header'] = array(
      '#type' => 'markup',
      '#prefix' => '<div class="edit-tweet">',
      '#markup' => t('Edit Tweet'),
      '#suffix' => '</div>',
    );
    $form['nid'] = array(
      '#type' => 'hidden',
      '#title' => t('Node nid'),
      '#required' => TRUE,
      '#value' => $nid,
    );
    $form['message-header'] = array(
      '#type' => 'markup',
      '#prefix' => '<div class="message-header">',
      '#markup' => t(''),
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
        '#value' => t('Save'),
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
    $form['message-footer'] = array(
      '#type' => 'markup',
      '#markup' => t(''),
      '#suffix' => '</div>',
      '#weight' => 20,
    );
  }

  /**
   * {@inheritdoc}
   */
  public function deleteForm(array &$form, FormStateInterface $form_state) {
    $nid = $_REQUEST['nid'];
    $tweet_info = tweets_queue_fetch_tweet_item($nid);
    $tweet_id = $tweet_info->tweet_id;
    $archived = $tweet_info->archived;
    $message = $tweet_info->message;
    $size = tweets_queue_get_message_size($message);
    $left = 140 - $size;
    $form['nid'] = array(
      '#type' => 'hidden',
      '#title' => t('Node nid'),
      '#required' => TRUE,
      '#value' => $nid,
    );
    $form['header'] = array(
      '#type' => 'markup',
      '#prefix' => '<div class="permanent-delete">',
      '#markup' => t('This will permanently delete your tweet'),
      '#suffix' => '</div>',
    );
    $form['option'] = array(
      '#type' => 'markup',
      '#prefix' => '<div class="delete-prompt">',
      '#markup' => t('What would you like to do ? '),
      '#suffix' => '</div>'
    );
     $form['clone'] = array(
      '#type' => 'submit',
      '#value' => t('Delete Anyway'),
      '#submit' => array('tweets_queue_delete_submit'),
      '#weight' => 9,
    );
    $form['cancel'] = array(
      '#type' => 'submit',
      '#submit' => array('tweets_queue_cancel_edit_submit'),
      '#value' => t('Cancel'),
      '#weight' => 10,
    );
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
    $size = tweets_queue_get_message_size($message);
    tweets_queue_update_message_queue_priority_info($nid,
      array(
        'message' => $message,
        'size' => $size,
        'changed' => time(),
      ),
      0
    );
    drupal_set_message(t('Tweet have been saved successfully.'));
    tweets_queue_redirect_on_tweet_save($size);
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }

}

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
 * Builds a form to edit tweet message.
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
    $action = (isset($_REQUEST[TWITTER_ACTION_PARAMETER])) ? tweets_queue_get_parameter_data(TWITTER_ACTION_PARAMETER) : TWITTER_EDIT_ACTION;

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
    $nid = tweets_queue_get_parameter_data(TWITTER_FIELD_NID);
    $tweet_info = tweets_queue_fetch_tweet_item($nid);
    $tweet_id = $tweet_info->tweet_id;

    tweets_queue_validate_tweet_access($tweet_info->uid);

    $archived = $tweet_info->archived;
    $message = tweets_queue_decrypt_data($tweet_info->{TWITTER_FIELD_MESSAGE});
    $size = tweets_queue_get_message_size($message);
    $left = CRON_TWEET_CHARCATER_LIMIT - $size;
    $form['header'] = array(
      '#type' => 'markup',
      '#prefix' => '<div class="edit-tweet">',
      '#markup' => t('Edit Tweet'),
      '#suffix' => '</div>',
    );
    $form[TWITTER_FIELD_NID] = array(
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
    $form[TWITTER_FIELD_MESSAGE] = array(
      '#type' => 'textarea',
      '#title' => t('Edit Tweet'),
      '#required' => TRUE,
      '#value' => $message,
      '#attributes' => array (
        'placeholder' => t("What's happening ?")
      ),
    );

    $fid = tweets_queue_get_all_images($nid);
    // echo '<pre>', print_r($fid);
    $form[TWITTER_FORM_FIELD_IMAGES] = array(
      '#type' => 'managed_file',
      '#name' => 'files[]',
      '#multiple' => TRUE,
      '#default_value' => $fid ? $fid : NULL,
      '#upload_location' => 'public://images/',
      '#title' => t('Upload some photos'),
      '#progress_message' => $this->t('Please wait...'),
      '#attributes' => array('multiple' => 'multiple'),
      '#upload_validators' => array(
        'file_validate_extensions' => array('png gif jpg jpeg'),
        'file_validate_size' => array(TWITTER_TWEET_IMAGE_SIZE_LIMIT),
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
    $form['tweet_now'] = array(
      '#type' => 'submit',
      '#submit' => array('::tweets_queue_tweet_now_submit'), 
      '#value' => t('Tweet Now'),
    );



    $form['display_box'] = array(
      '#type' => 'textfield',
      '#size' => 3,
      '#maxlength' => 3,
      '#value' => $left,
      '#required' => FALSE,
    );

    $form[TWITTER_REDIRECT_PATH] = array(
      '#type' => 'hidden',
      '#value' => tweets_queue_get_parameter_data(TWITTER_REDIRECT_PATH),
      '#required' => FALSE,
    );
    $form['message-footer'] = array(
      '#type' => 'markup',
      '#markup' => t(''),
      '#suffix' => '</div>',
      '#weight' => 20,
    );
  }

  public function tweets_queue_tweet_now_submit(array &$form, FormStateInterface $form_state) {
    global $base_url;
    $input = $form_state->getUserInput();

    $data = $form_state->getValues();
    $nid = $input[TWITTER_FIELD_NID];
    $message = $input[TWITTER_FIELD_MESSAGE];
    $images = $data[TWITTER_FORM_FIELD_IMAGES];

    $tweet_info = tweets_queue_fetch_tweet_item($nid);
    tweets_queue_validate_tweet_access($tweet_info->uid);

    $images = array();
    if (is_array($input[TWITTER_FORM_FIELD_IMAGES]) && !empty($input[TWITTER_FORM_FIELD_IMAGES]['fids'])) {
      $images = explode(" ", $input[TWITTER_FORM_FIELD_IMAGES]['fids']);
    }
    if (!$nid) {
      return;
    }
    $size = tweets_queue_get_message_size($message);
    tweets_queue_update_message_queue_priority_info($nid,
      array(
        'message' => $message,
        'size' => $size,
        'changed' => time(),
      ),
      0
    );
    tweets_queue_map_message_image_record($nid, $images);
 
    //drupal_set_message(t('Tweet hannnnnve been saved successfully.'));
    $query = \Drupal::database()->select(TWITTER_MESSAGE_QUEUE_TABLE, 'p');
    $query->fields('p', ['message']);
    $query->execute()->fetchField();

    $cron_run = false;
    tweets_queue_compile_tweets($message, $cron_run, $images, $nid);
    tweets_queue_goto_page($_REQUEST[TWITTER_REDIRECT_PATH]);
    
    }


  /**
   * {@inheritdoc}
   */
  public function deleteForm(array &$form, FormStateInterface $form_state) {
    $nid = tweets_queue_get_parameter_data(TWITTER_FIELD_NID);
    $tweet_info = tweets_queue_fetch_tweet_item($nid);

    tweets_queue_validate_tweet_access($tweet_info->uid);

    $tweet_id = $tweet_info->tweet_id;
    $archived = $tweet_info->archived;
    $message = tweets_queue_decrypt_data($message);
    $size = tweets_queue_get_message_size($message);
    $left = CRON_TWEET_CHARCATER_LIMIT - $size;
    $form[TWITTER_FIELD_NID] = array(
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
    $form[TWITTER_REDIRECT_PATH] = array(
      '#type' => 'hidden',
      '#value' => tweets_queue_get_parameter_data(TWITTER_REDIRECT_PATH),
      '#required' => FALSE,
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
    global $base_url;
    $input = $form_state->getUserInput();
    $nid = $input[TWITTER_FIELD_NID];
    $message = $input[TWITTER_FIELD_MESSAGE];

    $tweet_info = tweets_queue_fetch_tweet_item($nid);
    tweets_queue_validate_tweet_access($tweet_info->uid);

    $images = array();
    if (is_array($input[TWITTER_FORM_FIELD_IMAGES]) && !empty($input[TWITTER_FORM_FIELD_IMAGES]['fids'])) {
      $images = explode(" ", $input[TWITTER_FORM_FIELD_IMAGES]['fids']);
    }
    if (!$nid) {
      return;
    }
    $size = tweets_queue_get_message_size($message);
    tweets_queue_update_message_queue_priority_info($nid,
      array(
        'message' => $message,
        'size' => $size,
        'changed' => time(),
      ),
      0
    );
    tweets_queue_map_message_image_record($nid, $images);
    drupal_set_message(t('Tweet have been saved successfully.'));
    if (isset($input[TWITTER_REDIRECT_PATH]) && !empty($input[TWITTER_REDIRECT_PATH])) {
      header('Location: ' . $base_url . '/' . $input[TWITTER_REDIRECT_PATH]);
      die();
    }
    tweets_queue_redirect_on_tweet_save($size);
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }

}

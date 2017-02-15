<?php
/**
 * @file
 * Contains \Drupal\tweets_queue\Form\tweetsQueueSettingsForm
 */
namespace Drupal\tweets_queue\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Send tweets queue settings for this site.
 */
class SendTweetsForm extends FormBase {
  /** 
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'send_tweets_form';
  }

  /** 
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    tweets_queue_check_logged_user_mapping(FALSE);
    $form['message'] = array(
      '#type' => 'textfield',
      '#title' => t('Create a Tweet'),
      '#required' => TRUE,
    );

    tweets_queue_show_twitter_signin_message($form);
    $form['save'] = array(
      '#type' => 'submit',
      '#value' => t('Save for Later'),
      '#submit' => array('tweets_queue_create_save_tweet_form_submit'),
    );
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Tweet Now'),
    );

    return $form;
  }

  /** 
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $data = $form_state->getValues();
    $message = $data['message'];
    tweets_queue_compile_tweets($message);
  }
}

<?php
/**
 * @file
 * Contains \Drupal\tweets_queue\Form\SendTweetsForm
 */
namespace Drupal\tweets_queue\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Cache\Cache;

/**
 * Create tweet and send on twitter.
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
    $user_roles = \Drupal::currentUser()->getRoles();

    $uid = \Drupal::currentUser()->id();

    // For the first time entry is made in the session for the user about twitter credentials.
    if(!in_array(TWITTER_APPROVED_CLIENT_ROLE, $user_roles)) {
      if (!($_SESSION[$uid][TWITTER_USER_AUTHORIZED] == 1 && !empty($_SESSION[$uid][TWITTER_OWNER_ID]))) {
        return;
      }
    }

    $form['header'] = array(
      '#type' => 'markup',
      '#prefix' => '<div class="create-header">',
      '#markup' => t('Create a tweet'),
      '#suffix' => '</div>',
    );
    $form['message-header'] = array(
      '#type' => 'markup',
      '#prefix' => '<div class="message-header">',
      '#markup' => t(''),
    );
    $form[TWITTER_FORM_FIELD_MESSAGE] = array(
      '#type' => 'textarea',
      '#title' => t('Create a Tweet'),
      '#required' => TRUE,
      '#attributes' => array(
        'placeholder' => t("What's happening ?"),
      ),
    );

    $form[TWITTER_FORM_FIELD_IMAGES] = array(
        '#type' => 'managed_file',
        '#name' => 'files[]',
        '#multiple' => TRUE,
        '#upload_location' => 'public://images/',
        '#title' => t('Upload some photos'),
        '#attributes' => array('multiple' => 'multiple'),
        '#upload_validators' => array(
          'file_validate_extensions' => array('png gif jpg jpeg'),
          'file_validate_size' => array(25600000),
        ),
    );

    $form['save'] = array(
      '#type' => 'submit',
      '#value' => t('Save for Later'),
      '#submit' => array('tweets_queue_create_save_tweet_form_submit'),
      '#attributes' => array(
        'class' => array('beautytips'),
        'title' => t(TWITTER_TWEET_SAVE_LATER_TOOLTIP),
      ),
      '#weight' => 10,
    );

    $form['display_box'] = array(
      '#type' => 'textfield',
      '#size' => 3,
      '#maxlength' => 3,
      '#value' => 140,
      '#required' => FALSE,
    );
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Tweet Now'),
      '#attributes' => array(
        'class' => array('beautytips'),
        'title' => t(TWITTER_TWEET_NOW_TOOLTIP),
      ),
      '#weight' => 9,
    );
     $form['message-footer'] = array(
      '#type' => 'markup',
      '#markup' => t(''),
      '#suffix' => '</div>',
      '#weight' => 20,
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $data = $form_state->getValues();
    
    $message = $data[TWITTER_FORM_FIELD_MESSAGE];
    $images = $data[TWITTER_FORM_FIELD_IMAGES];

    $cron_run = false;
    tweets_queue_compile_tweets($message, $cron_run, $images);
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }
}

<?php
/**
 * @file
 * Contains \Drupal\tweets_queue\Form\SignUpForm
 */
namespace Drupal\tweets_queue\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Cache\Cache;

/**
 * Sign up form.
 */
class SignUpForm extends FormBase {
  /** 
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'signup_form';
  }

  /** 
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    global $base_url;
    $twitter_login_path = $base_url . '/' . TWITTER_SIGN_IN_PATH;
    $url = "<a href='" . $twitter_login_path ."'>" . TWITTER_SIGN_UP_TEXT . "</a>";
    $final_text = '<div>' . $url .
    "</div><span class='note'>Auto fetch your details from Twitter</span></div>";

    $form['header_left'] = array(
      '#type' => 'markup',
      '#prefix' => '<div class="signup">',
      '#markup' => t('Sign Up'),
      '#suffix' => '</div>',
    );

    $form['header_right'] = array(
      '#type' => 'markup',
      '#prefix' => '<div class="signup">',
      '#markup' => $final_text,
      '#suffix' => '</div>',
    );

    $form['message-header'] = array(
      '#type' => 'markup',
      '#prefix' => '<div class="message-header">',
      '#markup' => t(''),
    );
    $form['full_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Full Name'),
      '#required' => TRUE,
    );

    $form['email'] = array(
      '#type' => 'textfield',
      '#title' => t('Email'),
      '#required' => TRUE,
    );

    $form['password'] = array(
      '#type' => 'textfield',
      '#title' => t('Password'),
      '#required' => TRUE,
    );

    $form['website'] = array(
      '#type' => 'textfield',
      '#title' => t('Website'),
      '#required' => TRUE,
    );

    $form['organization'] = array(
      '#type' => 'textfield',
      '#title' => t('Organization Name'),
      '#required' => TRUE,
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Continue'),
      '#weight' => 9,
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

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }
}

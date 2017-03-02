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
      '#attributes' => array (
        'placeholder' => t("Required")
      ),
    );

    $form['email'] = array(
      '#type' => 'email',
      '#title' => t('Email'),
      '#required' => TRUE,
      '#attributes' => array (
        'placeholder' => t("Required")
      ),
    );

    $form['user_password'] = array(
      '#type' => 'password',
      '#title' => t('Password'),
      '#required' => TRUE,
      '#attributes' => array (
        'placeholder' => t("Required")
      ),
    );

    $form['website'] = array(
      '#type' => 'url',
      '#title' => t('Website'),
      '#required' => FALSE,
      '#attributes' => array (
        'placeholder' => t("Optional")
      ),
    );

    $form['organization'] = array(
      '#type' => 'textfield',
      '#title' => t('Organization Name'),
      '#required' => FALSE,
      '#attributes' => array (
        'placeholder' => t("Optional")
      ),
    );

    $form['#validate'][] = 'tweets_queue_user_signup_validate';
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
    $full_name = $data['full_name'];
    $username = strtolower(str_ireplace(" ", "", $full_name)) . "_" . time();
    $email = $data['email'];
    $password = $data['user_password'];
    $website = $data['website'];
    $organization = $data['organization'];
    $uid = tweets_queue_check_email_presence($email);
    //Mandatory settings
    $user = \Drupal\user\Entity\User::create();
    $user->setPassword($password);
    $user->enforceIsNew();
    $user->setEmail($email);
    $user->setUsername($username);
    $user->set("field_twitter_owner_id", '');
    $user->set("field_full_name", $full_name);
    $user->set("field_twitter_data", serialize(array()));
    //Optional settings
    $user->activate();
    $res = $user->save();
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }
}

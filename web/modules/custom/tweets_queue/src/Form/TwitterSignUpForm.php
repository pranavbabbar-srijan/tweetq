<?php
/**
 * @file
 * Contains \Drupal\tweets_queue\Form\TwitterSignUpForm
 */
namespace Drupal\tweets_queue\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Cache\Cache;

/**
 * Sign up form.
 */
class TwitterSignUpForm extends FormBase {
  /** 
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'twitter_signup_form';
  }

  /** 
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    global $base_url;

    $form['header'] = array(
      '#type' => 'markup',
      '#prefix' => '<div class="signup">',
      '#markup' => t('Registration'),
      '#suffix' => '</div>',
    );

    $form['message-header'] = array(
      '#type' => 'markup',
      '#prefix' => '<div class="message-header">',
      '#markup' => t(''),
    );

    $form[SIGNUP_FIELD_FULL_NAME] = array(
      '#type' => 'textfield',
      '#title' => t('Full Name'),
      '#required' => TRUE,
      '#attributes' => array (
        'placeholder' => t("Required")
      ),
    );

    $form[SIGNUP_FIELD_EMAIL] = array(
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

    $form[SIGNUP_FIELD_WEBSITE] = array(
      '#type' => 'url',
      '#title' => t('Website'),
      '#required' => FALSE,
      '#attributes' => array (
        'placeholder' => t("Optional")
      ),
    );

    $form[SIGNUP_FIELD_ORGANIZATION] = array(
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
    $full_name = $data[SIGNUP_FIELD_FULL_NAME];
    $username = strtolower(str_ireplace(" ", "", $full_name)) . "_" . time();
    $email = $data[SIGNUP_FIELD_EMAIL];
    $password = $data['user_password'];
    $website = $data[SIGNUP_FIELD_WEBSITE];
    $organization = $data[SIGNUP_FIELD_ORGANIZATION];
    $uid = tweets_queue_check_email_presence($email);
    //Mandatory settings
    $user = \Drupal\user\Entity\User::create();
    $user->setPassword($password);
    $user->enforceIsNew();
    $user->setEmail($email);
    $user->setUsername($username);
    $user->set(SIGNUP_FIELD_TWITTER_OWNER_ID, '');
    $user->set(SIGNUP_FIELD_FULL_NAME, $full_name);
    $user->set(SIGNUP_FIELD_WEBSITE, $website);
    $user->set(SIGNUP_FIELD_ORGANIZATION, $organization);
    $user->set(SIGNUP_FIELD_TWITTER_DATA, serialize(array()));
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

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
    $uid = \Drupal::currentUser()->id();
    $user = \Drupal\user\Entity\User::load($uid);
    $full_name = $user->get(SIGNUP_FIELD_FULL_NAME)->value;
    $email = $user->get('mail')->value;
    $full_name = $user->get(SIGNUP_FIELD_FULL_NAME)->value;
    $website = $user->get(SIGNUP_FIELD_WEBSITE)->value;
    $organization = $user->get(SIGNUP_FIELD_ORGANIZATION)->value;

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
      '#value' => $full_name,
      '#attributes' => array (
        'placeholder' => t("Required")
      ),
    );

    $form[SIGNUP_FIELD_EMAIL] = array(
      '#type' => 'email',
      '#title' => t('Email'),
      '#required' => TRUE,
      '#value' => $email,
      '#attributes' => array (
        'placeholder' => t("Required"),
        'readonly' => 'readonly',
      ),
    );

    // $form['user_password'] = array(
    //   '#type' => 'password',
    //   '#title' => t('Password'),
    //   '#required' => TRUE,
    //   '#attributes' => array (
    //     'placeholder' => t("Required")
    //   ),
    // );

    $form[SIGNUP_FIELD_WEBSITE] = array(
      '#type' => 'textfield',
      '#title' => t('Website'),
      '#required' => FALSE,
      '#value' => $website,
      '#attributes' => array (
        'placeholder' => t("Optional")
      ),
    );

    $form[SIGNUP_FIELD_ORGANIZATION] = array(
      '#type' => 'textfield',
      '#title' => t('Organization Name'),
      '#required' => FALSE,
      '#value' => $organization,
      '#attributes' => array (
        'placeholder' => t("Optional")
      ),
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Submit'),
      '#weight' => 9,
    );

    return $form;
  }

  /** 
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $data = $form_state->getValues();
    $uid = \Drupal::currentUser()->id();
    $user = \Drupal\user\Entity\User::load($uid);

    $full_name = $data[SIGNUP_FIELD_FULL_NAME];
    $password = $data[SIGNUP_FIELD_PASSWORD];
    $website = $data[SIGNUP_FIELD_WEBSITE];
    $organization = $data[SIGNUP_FIELD_ORGANIZATION];

    //Mandatory settings
    $user->setPassword($password);

    $user->set(SIGNUP_FIELD_FULL_NAME, $full_name);
    $user->set(SIGNUP_FIELD_WEBSITE, $website);
    $user->set(SIGNUP_FIELD_ORGANIZATION, $organization);
    //Optional settings
    $res = $user->save();
    tweets_queue_goto_dashboard();
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }
}

<?php
/**
 * @file
 * Contains \Drupal\tweets_queue\Form\SignUpForm
 */
namespace Drupal\tweets_queue\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Url;
use Drupal\Core\Link;

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
    unset($form['SIGNUP_FIELD_EMAIL']['#attributes']['autofocus']);
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
      '#prefix' => '<div  id= "signup-form" class="message-header">',
      '#markup' => t(''),
    );
    $form[SIGNUP_FIELD_FULL_NAME] = array(
      '#type' => 'textfield',
      '#title' => t('Full Name'),
      '#attributes' => array (
        'placeholder' => t("Required"),
        'autocomplete' => 'off'
      ),
    );

    $form[SIGNUP_FIELD_EMAIL] = array(
      '#type' => 'textfield',
      '#title' => t('Email'),
      '#attributes' => array (
        'placeholder' => t("Required"),
        'autocomplete' => 'off'
      ),
    );

    $form[SIGNUP_FIELD_PASSWORD] = array(
      '#type' => 'password',
      '#title' => t('Password'),
      '#attributes' => array (
        'placeholder' => t("Required")
      ),
    );

    $form[SIGNUP_FIELD_WEBSITE] = array(
      '#type' => 'textfield',
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

    $form['SIGNUP_FIELD_ORGANIZATION'] = array(
      '#prefix' => '<span id="result">',
      '#type' => 'hidden',
      '#title' => t('Password validation'),
      '#required' => FALSE,
      '#suffix' => '</span>',
    );

    $form['#validate'][] = 'tweets_queue_user_signup_validate';
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Submit'),
      '#weight' => 9,
    );

    $form['message-footer'] = array(
      '#type' => 'markup',
      '#suffix' => '</div>',
      '#markup' => t(''),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    global $base_url;

    $data = $form_state->getValues();
    $full_name = $data[SIGNUP_FIELD_FULL_NAME];
    $username = strtolower(str_ireplace(" ", "", $full_name)) . "_" . time();
    $email = $data[SIGNUP_FIELD_EMAIL];
    $password = $data[SIGNUP_FIELD_PASSWORD];
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
    $field_user_hash_key = hash('sha256', $email);
    $user->set(SIGNUP_FIELD_HASH_KEY, $field_user_hash_key);
    $user->activate();
    $user->status = 0;
    $res = $user->save();
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }
}

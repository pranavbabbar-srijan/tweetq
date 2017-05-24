<?php
/**
 * @file
 * Contains \Drupal\tweets_queue\Form\ProfileSettingForm
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
class ProfileSettingForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ProfileSettingForm';
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

    $mobile = '';
    $job_title = '';

    $form['header_left'] = array(
      '#type' => 'markup',
      '#prefix' => '<div class="profile-setting">',
      '#markup' => t('Profile & Settings'),
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
      '#prefix' => '<div  id= "profile-settings-form" class="message-header">',
      '#markup' => t('Profile'),
    );
    $form[SIGNUP_FIELD_FULL_NAME] = array(
      '#type' => 'textfield',
      '#title' => t('Full Name'),
      '#value' => $full_name,
      '#attributes' => array (
        'readonly' => 'readonly',
      ),
    );

    $twitter_username = '';
    $form['twitter_screen'] = array(
      '#type' => 'textfield',
      '#title' => t('Twitter Username'),
      '#value' => $twitter_username,
      '#attributes' => array (
        'readonly' => 'readonly',
      ),
    );

    $form[SIGNUP_FIELD_EMAIL] = array(
      '#type' => 'textfield',
      '#title' => t('Email'),
      '#value' => $email,
      '#attributes' => array (
        'readonly' => 'readonly',
      ),
    );

    $form['change' . SIGNUP_FIELD_PASSWORD] = array(
      '#type' => 'password',
      '#title' => t('Password'),
      '#required' => FALSE,
      '#attributes' => array (
        'autocomplete' => 'off'
      ),
    );

    $form['change_password'] = array(
      '#type' => 'markup',
      '#prefix' => '<div id="change-password">',
      '#markup' => t('Change'),
      '#suffix' => '</div>',
    );

    $form[SIGNUP_FIELD_MOBILE_NUMBER] = array(
      '#type' => 'textfield',
      '#title' => t('Mobile Number'),
      '#value' => $mobile,
      '#required' => FALSE,
      '#attributes' => array (
        'placeholder' => t("9999999999"),
        'autocomplete' => 'off'
      ),
    );

    $form[SIGNUP_FIELD_JOB_TITLE] = array(
      '#type' => 'textfield',
      '#title' => t('Job Title'),
      '#value' => $job_title,
      '#required' => FALSE,
      '#attributes' => array (
        'autocomplete' => 'off'
      ),
    );

    $form[SIGNUP_FIELD_ORGANIZATION] = array(
      '#type' => 'textfield',
      '#title' => t('Organization Name'),
      '#required' => FALSE,
      '#attributes' => array (
        'autocomplete' => 'off'
      ),
    );

    $form[SIGNUP_FIELD_WEBSITE] = array(
      '#type' => 'textfield',
      '#title' => t('Website'),
      '#value' => $website,
      '#required' => FALSE,
      '#attributes' => array (
        'autocomplete' => 'off'
      ),
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Update Profile'),
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
    $data = $form_state->getValues();
    $uid = \Drupal::currentUser()->id();
    $user = \Drupal\user\Entity\User::load($uid);

    // $full_name = $data[SIGNUP_FIELD_FULL_NAME];
    // $password = $data[SIGNUP_FIELD_PASSWORD];
    $website = $data[SIGNUP_FIELD_WEBSITE];
    $organization = $data[SIGNUP_FIELD_ORGANIZATION];
    $mobile = $data[SIGNUP_FIELD_MOBILE_NUMBER];
    $job_title = $data[SIGNUP_FIELD_JOB_TITLE];
    // $mail = $user->get('mail')->value;
    
    //Mandatory settings
    $user->setPassword($password);
    $user->set(SIGNUP_FIELD_FULL_NAME, $full_name);
    $user->set(SIGNUP_FIELD_WEBSITE, $website);
    $user->set(SIGNUP_FIELD_ORGANIZATION, $organization);
    //Optional settings
    $res = $user->save();
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }
}

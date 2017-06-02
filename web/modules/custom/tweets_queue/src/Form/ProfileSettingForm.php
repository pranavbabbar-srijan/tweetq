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

    $twitter_profile_info = tweets_queue_fetch_twitter_statistics_info(TWITTER_HANDLER_PROFILE);
    $user_twitter_profile_info = unserialize($twitter_profile_info);
    $twitter_handle = $user_twitter_profile_info->screen_name;
    $twitter_handle = (!empty($twitter_handle)) ? '@' . $twitter_handle : '';


    $uid = \Drupal::currentUser()->id();
    $user = \Drupal\user\Entity\User::load($uid);
    $full_name = $user->get(SIGNUP_FIELD_FULL_NAME)->value;
    $email = $user->get('mail')->value;
    $full_name = $user->get(SIGNUP_FIELD_FULL_NAME)->value;
    $website = $user->get(SIGNUP_FIELD_WEBSITE)->value;
    $organization = $user->get(SIGNUP_FIELD_ORGANIZATION)->value;
    $verified_class = 'profile-information-complete';

    $mobile = $user->get(SIGNUP_FIELD_MOBILE_NUMBER)->value;
    $job_title = $user->get(SIGNUP_FIELD_JOB_TITLE)->value;

    $form['header_left'] = array(
      '#type' => 'markup',
      '#prefix' => '<div class="profile-setting">',
      '#markup' => t(TWITTER_PROFILE_SETTING_LABEL),
      '#suffix' => '</div>',
    );

    $form['message-header'] = array(
      '#type' => 'markup',
      '#prefix' => '<div  id= "profile-settings-form" class="message-header">',
    );

    $form['message-header-title'] = array(
      '#type' => 'markup',
      '#prefix' => '<div class="message-header-title">',
      '#markup' => t('Profile'),
      '#suffix' => '</div>',
    );

    $form[SIGNUP_FIELD_FULL_NAME] = array(
      '#type' => 'textfield',
      '#title' => t('Full Name'),
      '#default_value' => $full_name,
      '#attributes' => array (
        'readonly' => 'readonly',
        'class' => (!empty($full_name)) ? array($verified_class) : array(''),
      ),
    );

    $twitter_username = '';
    $form['twitter_screen'] = array(
      '#type' => 'textfield',
      '#title' => t('Twitter Username'),
      '#default_value' => (!empty($twitter_handle)) ? $twitter_handle : '',
      '#attributes' => array (
        'readonly' => 'readonly',
        'class' => (!empty($twitter_handle)) ? array($verified_class) : array(''),
      ),
    );

    $form[SIGNUP_FIELD_EMAIL] = array(
      '#type' => 'textfield',
      '#title' => t('Email'),
      '#default_value' => $email,
      '#attributes' => array (
        'readonly' => 'readonly',
        'class' => (!empty($twitter_username)) ? array($verified_class) : array(''),
      ),
    );


    $form['change_password_prefix'] = array(
      '#type' => 'markup',
      '#markup' => t(''),
      '#prefix' => '<div id="change-password">',
    );

    $form['change' . SIGNUP_FIELD_PASSWORD] = array(
      '#type' => 'password',
      '#title' => t('Password'),
      '#required' => FALSE,
      '#default_value' => '',
      '#attributes' => array (
        'autocomplete' => 'off'
      ),
    );

    $form['change_password'] = array(
      '#type' => 'markup',
      '#markup' => t('<span class="change">Change</span>'),
      '#suffix' => '</div>',
    );

    $form[SIGNUP_FIELD_MOBILE_NUMBER] = array(
      '#type' => 'textfield',
      '#title' => t('Mobile Number'),
      '#default_value' => $mobile,
      '#required' => FALSE,
      '#attributes' => array (
        'placeholder' => t("9999999999"),
        'autocomplete' => 'off'
      ),
    );

    $form[SIGNUP_FIELD_JOB_TITLE] = array(
      '#type' => 'textfield',
      '#title' => t('Job Title'),
      '#default_value' => $job_title,
      '#required' => FALSE,
      '#attributes' => array (
        'autocomplete' => 'off'
      ),
    );

    $form[SIGNUP_FIELD_ORGANIZATION] = array(
      '#type' => 'textfield',
      '#title' => t('Organization Name'),
      '#default_value' => $organization,
      '#required' => FALSE,
      '#attributes' => array (
        'autocomplete' => 'off'
      ),
    );

    $form[SIGNUP_FIELD_WEBSITE] = array(
      '#type' => 'textfield',
      '#title' => t('Organization Name'),
      '#default_value' => $website,
      '#required' => FALSE,
      '#attributes' => array (
        'autocomplete' => 'off'
      ),
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Update Profile'),
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

    $website = $data[SIGNUP_FIELD_WEBSITE];
    $organization = $data[SIGNUP_FIELD_ORGANIZATION];
    $mobile = $data[SIGNUP_FIELD_MOBILE_NUMBER];
    $job_title = $data[SIGNUP_FIELD_JOB_TITLE];
    
    //Mandatory settings
    $user->set(SIGNUP_FIELD_WEBSITE, $website);
    $user->set(SIGNUP_FIELD_ORGANIZATION, $organization);
    $user->set(SIGNUP_FIELD_MOBILE_NUMBER, $mobile);
    $user->set(SIGNUP_FIELD_JOB_TITLE, $job_title);
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

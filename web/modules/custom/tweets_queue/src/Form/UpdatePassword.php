<?php

namespace Drupal\tweets_queue\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class UpdatePassword.
 *
 * @package Drupal\tweets_queue\Form
 */
class UpdatePassword extends FormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'tweets_queue_update_password.update',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'update_password';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $id = tweets_queue_get_parameter_data('id');
    $hash_key = tweets_queue_get_parameter_data('hash_key');
    $hash_key1 = tweets_queue_get_parameter_data('hash_key1');
    $valid = tweets_queue_validate_password_hash_key($id, $hash_key, $hash_key1);
    if (!$valid) {
      return;
    }
    $form['password'] = array(
     '#type' => 'password',
     '#title' => $this->t('New Password'),
     '#maxlength' => 64,
     '#attributes' => array (
        'placeholder' => t("Required"),
        'autocomplete' => 'off'
      ),
     '#size' => 64,
   );
    $form['reset_password'] = array(
     '#type' => 'password',
     '#title' => $this->t('Confirm Password'),
     '#maxlength' => 64,
     '#attributes' => array (
        'placeholder' => t("Required"),
        'autocomplete' => 'off'
      ),
     '#size' => 64,
   );
   $form['actions']['#type'] = 'actions';
   $form['actions']['submit'] = array(
     '#type' => 'submit',
     '#value' => $this->t('Reset'),
     '#button_type' => 'primary',
   );
   return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $current_path = \Drupal::service('path.current')->getPath();
    $path_args = array_filter(explode('/', $current_path));
    $email = $path_args[2];
    $hash = $path_args[3];
    // Using this email and hash key check whether this exists in DB or not.
    // If exists then form will be submitted other throw one error message.
    // Invalid email or hash key as per query results.
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $current_path = \Drupal::service('path.current')->getPath();
    $path_args = array_filter(explode('/', $current_path));
    $email = $path_args[2];
    $password = md5($form['password']['#value']);
    // After successful submission update the password for the respective email address.
    // after that redirect user to login page.
    echo $password;
    die;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }

}
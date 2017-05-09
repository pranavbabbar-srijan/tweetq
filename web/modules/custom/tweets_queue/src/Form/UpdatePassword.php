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
      '#required' => TRUE,
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
      '#required' => TRUE,
      '#size' => 64,
    );
    $form['id'] = array(
      '#type' => 'hidden',
      '#value' => $id,
      '#title' => $this->t('ID'),
    );
    $form['hash_key'] = array(
      '#type' => 'hidden',
      '#value' => $hash_key,
      '#title' => $this->t('ID'),
    );
    $form['hash_key1'] = array(
      '#type' => 'hidden',
      '#value' => $hash_key1,
      '#title' => $this->t('ID'),
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
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    global $base_url;
    $data = $form_state->getValues();
    $password = $data['password'];
    $reset_password = $data['reset_password'];
    $id = $data['id'];
    $hash_key = $data['hash_key'];
    $hash_key1 = $data['hash_key1'];
    $valid = tweets_queue_validate_password_hash_key($id, $hash_key, $hash_key1);
    if (!$valid) {
      return;
    }

    if ($password != $reset_password) {
      drupal_set_message(t('New Password and Confirm Password must be same'));
      return;
    }
    $hash_key_info = tweets_queue_fetch_password_hash_key_info($id);
    if (is_object($hash_key_info)) {
      $uid = $hash_key_info->uid;
      tweets_queue_change_password($uid, $password);
      drupal_set_message(t("Password successfuly changed."));
      header('Location: ' . $base_url);
      die();
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }

}
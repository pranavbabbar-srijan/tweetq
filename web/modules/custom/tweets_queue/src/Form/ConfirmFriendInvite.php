<?php

namespace Drupal\tweets_queue\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ConfirmFriendInvite.
 *
 * @package Drupal\tweets_queue\Form
 */
class ConfirmFriendInvite extends FormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'tweets_queue_confirm_friend_invite.update',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'confirm_friend_invite';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $id = tweets_queue_get_parameter_data('id');
    $hash_key = tweets_queue_get_parameter_data('hash_key');
    $hash_key1 = tweets_queue_get_parameter_data('hash_key1');
    $valid = tweets_queue_validate_friend_invite_hash_key($id, $hash_key, $hash_key1);
    if (!$valid) {
      return;
    }

    $form['message_header'] = array(
      '#type' => 'markup',
      '#prefix' => '<div class="password-header">',
      '#markup' => t('Friend Invitation'),
      '#suffix' => '</div>',
    );
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
      '#value' => $this->t('Confirm'),
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
    $data = $form_state->getValues();
    $id = $data['id'];
    $hash_key = $data['hash_key'];
    $hash_key1 = $data['hash_key1'];
    $valid = tweets_queue_validate_friend_invite_hash_key($id, $hash_key, $hash_key1);
    if (!$valid) {
      drupal_set_message(t('failed verification'));
      return;
    }
    $friend_invited_info = tweets_queue_fetch_friend_invite_hash_key_info($id);
    $friend_invited_info->password = $data['password'];
    tweets_queue_register_friend_invited_user($friend_invited_info);
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }

}
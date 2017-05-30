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
    drupal_set_message(t('Do confirmation stuff'));
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

  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }

}
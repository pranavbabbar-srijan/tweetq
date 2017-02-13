<?php
/**
 * @file
 * Contains \Drupal\tweets_queue\Form\tweetsQueueSettingsForm
 */
namespace Drupal\tweets_queue\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Send tweets queue settings for this site.
 */
class AuthorizeTwitterLogin extends FormBase {
  /** 
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'authorize_twitter_form';
  }

  /** 
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    tweets_queue_authenticate_twitter_user();
  }

  /** 
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
  }
}

<?php
/**
 * @file
 * Contains \Drupal\tweets_queue\Form\InviteSettingForm
 */
namespace Drupal\tweets_queue\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Url;
use Drupal\Core\Link;

/**
 * Invitation setting form.
 */
class InviteSettingForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'invite_setting_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    global $base_url;

    $form['header_left'] = array(
      '#type' => 'markup',
      '#prefix' => '<div class="profile-account-setting">',
      '#markup' => t(TWITTER_PROFILE_SETTING_LABEL),
      '#suffix' => '</div>',
    );

    $form['message-header'] = array(
      '#type' => 'markup',
      '#prefix' => '<div  id= "profile-account-settings-form" class="message-header">',
      '#markup' => t('Profile'),
    );
    $form['invite_friend_list'] = array(
      '#type' => 'textfield',
      '#title' => t('Invite friends to join Barbet'),
      '#required' => FALSE,
      '#default_value' => '',
      '#attributes' => array (
        'autocomplete' => 'off',
        'placeholder' => t("Email address separated by comma"),
      ),
    );

    $form['invite_friend'] = array(
      '#type' => 'markup',
      '#prefix' => '<div id="invite-friend">',
      '#markup' => t('Invite'),
      '#suffix' => '</div>',
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
    
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }
}

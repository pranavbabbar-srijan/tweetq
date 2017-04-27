<?php

namespace Drupal\tweets_queue\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Cache\Cache;
use Drupal\user\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * An example controller.
 */
class TweetsQueueTweetController extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public function content() {
    $build = array(
      '#type' => 'markup',
      '#markup' => t(''),
    );
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function userHistory() {
    $uid = \Drupal::currentUser()->id();
    $user_history_key = tweets_queue_populate_statistics_key($uid, TWITTER_USER_HISTORY_MARK);
    tweets_queue_update_twitter_statistics($user_history_key,
      array(
        'value' => time(),
        'data' => serialize(array()),
      )
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }

  public function verify($email, $hash) {
    global $base_url;
    $query = \Drupal::database()->select('users_field_data', 'ufd');
    $query->fields('ufd',['uid']);
    $query->leftJoin('user__field_user_hash_key', 'uhk', 'ufd.uid = uhk.entity_id');
    $query->condition('ufd.mail', $email , '=');
    $query->condition('uhk.field_user_hash_key_value', $hash , '=');
    $user_id = $query->execute()->fetchField();
    if ($user_id) {
    $query = \Drupal::database()->update('users_field_data')
    ->fields(['status' => 1])
    ->condition('uid', $user_id)
    ->execute();
    $redirect_path = TWITTER_USER_DASHBOARD;
    if ($account->redirectPath) {
    $redirect_path = $account->redirectPath;
    }
    $response = new RedirectResponse($base_url . '/' . $redirect_path);
    $response->send();
  }
}
}
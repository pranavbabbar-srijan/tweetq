<?php

namespace Drupal\tweets_queue\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Cache\Cache;

/**
 * An example controller.
 */
class TweetsQueueTweetController extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public function validateEmail() {
    $email = $_REQUEST['email'];
    $uid = tweets_queue_check_email_presence($email);
    switch ($uid) {
      case '':
        die("");
        break;
      default:
        die("exist");
        break;
    }
  }

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

}

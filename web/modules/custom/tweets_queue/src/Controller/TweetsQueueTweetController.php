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
  public function validateEmail() {
    $email = tweets_queue_get_parameter_data('email');
    if (\Drupal::service('email.validator')->isValid($email)) {
      $uid = tweets_queue_check_email_presence($email);  
      if ($uid) {
        die("exist");
      }
    }
    die("");
  }

  /**
   * {@inheritdoc}
   */
  public function sendToken() {
    $email = tweets_queue_get_parameter_data('email');
    if (!\Drupal::service('email.validator')->isValid($email)) {
      die(t("Please enter a valid email ID"));
    }
    $uid = tweets_queue_check_email_presence($email);
    if (!$uid) {
      die(t("This Email ID is not registered with us. Kindly enter your registered Email ID"));
    }
    $uid = tweets_queue_check_email_presence($email, 1);
    if (!$uid) {
      die(t('Your accout is either de-active or blocked. Please check your mail.'));
    }
    $created = time();
    $hash_key = hash('sha256', $email);
    $hash_key1 = hash('sha256', $created);
    $password_message_info = array(
      'uid' => $uid,
      'email' => $email,
      'hash_key' => $hash_key,
      'created' => $created
    );
    $id = tweets_queue_insert_password_hash_key_record($password_message_info);
    //Perform send mail operation and other stuff.
    tweets_queue_forgot_password_send_mail($email, $hash_key, $id, $hash_key1);
    die("done");
  }

  /**
   * {@inheritdoc}
   */
  public function sendFriendInviteToken() {
    $uid = \Drupal::currentUser()->id();
    $email = tweets_queue_get_parameter_data('email');
    if (!\Drupal::service('email.validator')->isValid($email)) {
      die(t("Please enter a valid email ID"));
    }

    $created = time();
    $hash_key = hash('sha256', $email);
    $hash_key1 = hash('sha256', $created);
    $friend_invite_info = array(
      'uid' => $uid,
      'email' => $email,
      'hash_key' => $hash_key,
      'created' => $created,
      'status' => 0
    );
    $invited_id = tweets_queue_check_invited_friend_email_presence($email);
    if ($invited_id) {
      die(t("Already invited @email", array('@email' => $email)));
      return;
    }
    $id = tweets_queue_insert_friend_invite_hash_key_record($friend_invite_info);
    //Perform send mail operation and other stuff.
    tweets_queue_invite_volunteer_send_mail($email, $hash_key, $id, $hash_key1);
    die("done");
  }

  /**
   * {@inheritdoc}
   */
  public function inviteFriends() {
    $uid = \Drupal::currentUser()->id();
    $email = tweets_queue_get_parameter_data('email');
    if (!\Drupal::service('email.validator')->isValid($email)) {
      die(t("Please enter a valid email ID"));
    }

    //Perform send mail operation and other stuff.
    tweets_queue_invite_friends_send_mail($email);
    $twitter_history_info = array(
     // 'nid' => $message_data->nid,
      'uid' => $uid,
      'created' => time(),
      'type' => 'Invitation',
      'message' => 'Invitation send to' . ' ' . $email,
    );
    tweets_queue_update_twittter_tweet_history($uid, $twitter_history_info);
    die("done");
  }

  /**
   * {@inheritdoc}
   */
  public function validateUserLogin() {
    $email = tweets_queue_get_parameter_data('email');
    $password = tweets_queue_get_parameter_data('password');
    $email = trim($email);
    if (!\Drupal::service('email.validator')->isValid($email)) {
      die("invalid_email");
    }
    $uid = tweets_queue_check_email_presence($email);
    if (!$uid) {
      die("not_registered");
    }
    if ($user = user_load_by_mail($email)) {
      // Set the username for further validation.
      $name = $user->getAccountName();
      $uid = \Drupal::service('user.auth')->authenticate($name, $password);
      if ($uid) {
          die("exist");
      }
    }
    die("no");
  }

  /**
   * {@inheritdoc}
   */
  public function changePassword() {
    $uid = \Drupal::currentUser()->id();
    if (!$uid) {
      die("access_denied");
    }
    $password = tweets_queue_get_parameter_data('password');

    if (empty($password)) {
      die("empty_password");
    }
    // if (!preg_match('/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{6,12}$/',$password)) {
    //   die("weak_password");
    // }
    tweets_queue_change_password($uid, $password);
    $twitter_history_info = array(
     // 'nid' => $message_data->nid,
      'uid' => $uid,
      'created' => time(),
      'type' => 'Password',
      'message' => 'Password has been changed',
    );
    tweets_queue_update_twittter_tweet_history($uid, $twitter_history_info);
    die("done");
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
    tweets_queue_goto_page_after_verify();
    // drupal_set_message('Your account has been activated, you can now login');
  }
}

  public function deleteTweets() {
    $logged_uid = \Drupal::currentUser()->id();
    $var = $_REQUEST[nid];
    $deleted = array();

    foreach ($var as $key => $value) {
    $tweet_info = tweets_queue_fetch_tweet_item($value);
      if ($tweet_info->uid == $logged_uid) {
      tweets_queue_update_message_queue_priority_info($value,
        array(
        'status' => TWITTER_DELETED_TWEET,
        'changed' => time()
        ),
        0
      );
      $deleted[] = $value;
      tweet_queue_delete_messages($value);
      }
    }
    $selected = implode(',', $deleted);
    $twitter_history_info = array(
      'nid' => $value,
      'uid' => $logged_uid,
      'created' => time(),
      'type' => 'Delete',
      'message' => 'Tweets have been successfully deleted',
    );
    tweets_queue_update_twittter_tweet_history($value, $twitter_history_info);
    drupal_set_message('Tweets have been successfully deleted');
    die($selected);
  }

  /**
  * This function shows an upload csv file of users
  */
  public function importCsvLogs() {
    $uid = \Drupal::currentUser()->id();
    $query = \Drupal::database()->select(TWITTER_TWEETS_IMPORTS_LOGS_TABLE, 'h');
    $query->fields('h');
    $query->condition('h.uid', $uid);
    $result = $query->execute()->fetchAll();  
    $output = array();
    foreach ($result as $pos => $data) {
      $total++;
      $output[] = $data;
    }
    return $output;
  }

  /**
  * This function goto than login page when users got an access denied error message.
  */
  
  public function accessDenied() {
    tweets_queue_goto_page();
  }
}

<?php
/**
 * @file
 * Contains \Drupal\tweets_queue\Plugin\Block\NonTwitterUsersLeftSideBarBlock.
 */
namespace Drupal\tweets_queue\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;

/**
 * Provides a 'twitter' block.
 *
 * @Block(
 *   id = "non_twitter_users_left_side_bar_block",
 *   admin_label = @Translation("Non twitter Users Left side bar block"),
 *   category = @Translation("Non Twitter users left side bar block")
 * )
 */
class NonTwitterUsersLeftSideBarBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    global $base_url;
    $user_roles = \Drupal::currentUser()->getRoles();
    if(in_array(TWITTER_APPROVED_CLIENT_ROLE, $user_roles)) {
      return array(
        '#type' => 'markup',
        '#markup' => '',
      );
    }

    $picture = '';
    $twitter_handle = '';
    $name = '';
    $uid = ($uid == '') ? \Drupal::currentUser()->id() : $uid;
    $user = \Drupal\user\Entity\User::load($uid);
    $name = $user->get(SIGNUP_FIELD_FULL_NAME)->value;
    $profile_img = "<img src='" . $picture . "'></img>";
    $twitter_profile_output = "<div class='non-twitter-profile'>
      <span class='img'>" . $profile_img . "</span>
      <span class='name'>" . $name . "</span>
      <span class='twitter_handle'>". $twitter_handle . "</span>
    </div>" ;

    $create_tweet_output = "<div class='create_tweets'>
      <span class='text'>" . TWITTER_CREATE_TWEET_LABEL . "</span></div>" ;
    $import_tweets_output = "<div class='import_tweets'>
      <span class='text'>" . TWITTER_IMPORT_TWEET_LABEL . "</span></div>" ;

    $valid_tweets_output = "<div class='valid_tweets'>
      <span class='text'>" . TWITTER_VALID_TWEET_LABEL . "</span></div>" ;
    $invalid_tweets_output = "<div class='invalid_tweets'>
      <span class='text'>" . TWITTER_INVALID_TWEET_LABEL . "</span></div>" ;
    $archived_tweets_output = "<div class='archived_tweets'>
      <span class='text'>" . TWITTER_ARCHIVED_TWEET_LABEL . "</span></div>" ;
    $settings_output = "<div class='settings'>
      <span class='text'>" . TWITTER_SETTINGS_LABEL . "</span></div>" ;

    $output = "<div id='non-twitter-profile'>" . $twitter_profile_output .
      $create_tweet_output . $import_tweets_output . $valid_tweets_output .
      $invalid_tweets_output . $archived_tweets_output . "</div>";

    return array(
      '#type' => 'markup',
      '#markup' => $output,
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }
}

<?php
/**
 * @file
 * Contains \Drupal\tweets_queue\Plugin\Block\UsersLeftSideBarBlock.
 */
namespace Drupal\tweets_queue\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;

/**
 * Provides a 'twitter' block.
 *
 * @Block(
 *   id = "users_left_side_bar_block",
 *   admin_label = @Translation("Users Left side bar block"),
 *   category = @Translation("Twitter users left side bar block")
 * )
 */
class UsersLeftSideBarBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    global $base_url;
    $current_path = \Drupal::service('path.current')->getPath();
    $twitter_profile_info = tweets_queue_fetch_twitter_statistics_info(TWITTER_HANDLER_PROFILE);
    $user_twitter_profile_info = unserialize($twitter_profile_info);
    $picture = '';
    $name = $user_twitter_profile_info->name;
    $twitter_handle = $user_twitter_profile_info->screen_name;
    $twitter_handle = (!empty($twitter_handle)) ? '@' . $twitter_handle : '';
    $valid_tweets = tweets_queue_get_users_total_tweets_count(USERS_VALID_TWEET);
    $invalid_tweets = tweets_queue_get_users_total_tweets_count(USERS_INVALID_TWEET);
    $archived_tweets = tweets_queue_get_users_total_tweets_count(USERS_ARCHIVED_TWEET);

    $picture = $user_twitter_profile_info->profile_image_url;
    $profile_img = "<img src='" . $picture . "'></img>";
    $twitter_profile_output = "<div class='profile'>
      <span class='img'>" . $profile_img . "</span>
      <span class='name'>" . $name . "</span>
      <span class='twitter_handle'>". $twitter_handle . "</span>
    </div>" ;

    $class = tweets_queue_match_current_path($current_path, TWITTER_CREATE_TWEET_PATH);
    $create_tweet_link = "<a " . $class . " href='" . $base_url .'/' . TWITTER_CREATE_TWEET_PATH . "'>" .
      TWITTER_CREATE_TWEET_LABEL ."</a>";


    $class = tweets_queue_match_current_path($current_path, TWITTER_IMPORT_TWEET_PATH);
    $import_tweet_link = "<a " . $class . " href='" . $base_url .'/' . TWITTER_IMPORT_TWEET_PATH . "'>" .
      TWITTER_IMPORT_TWEET_LABEL ."</a>";

    $class = tweets_queue_match_current_path($current_path, TWITTER_VALID_TWEET_PATH);
    $valid_tweets_output = "<div class='valid_tweets $class'>
        <span class='text'>" . TWITTER_VALID_TWEET_LABEL . " " . "New" . " " . "</span>" .
        "<span class='value'>" . $valid_tweets . "</span>
      </div>" ;
    $valid_tweet_link = "<a " . $class . " href='" . $base_url .'/' . TWITTER_VALID_TWEET_PATH . "'>" .
      TWITTER_VALID_TWEET_LABEL ."</a>";

    $class = tweets_queue_match_current_path($current_path, TWITTER_INVALID_TWEET_PATH);
    $invalid_tweets_output = "<div class='valid_tweets $class'>
        <span class='text'>" . TWITTER_INVALID_TWEET_LABEL . " " . "New" . " " . "</span>" .
        "<span class='value'>" . $invalid_tweets . "</span>
      </div>" ;
    $invalid_tweet_link = "<a " . $class . " href='" . $base_url .'/' . TWITTER_INVALID_TWEET_PATH . "'>" .
      TWITTER_INVALID_TWEET_LABEL ."</a>";

    $class = tweets_queue_match_current_path($current_path, TWITTER_ARCHIVED_TWEET_PATH);
     $archived_tweets_output = "<div class='archived_tweets $class'>
        <span class='text'>" . TWITTER_ARCHIVED_TWEET_LABEL . " " . "New" . " " . "</span>" .
        "<span class='value'>" . $archived_tweets . "</span>
      </div>" ;
    $archived_tweet_link = "<a " . $class . " href='" . $base_url .'/' . TWITTER_ARCHIVED_TWEET_PATH . "'>" .
      TWITTER_ARCHIVED_TWEET_LABEL ."</a>";

    $create_tweet_output = "<div class='create_tweets'>
      <span class='text'>" . $create_tweet_link . "</span></div>" ;
    $import_tweets_output = "<div class='import_tweets'>
      <span class='text'>" . $import_tweet_link . "</span></div>" ;

    // $valid_tweets_output = "<div class='valid_tweets'>
    //   <span class='text'>" . $valid_tweet_link . "</span></div>" ;
    // $invalid_tweets_output = "<div class='invalid_tweets'>
    //   <span class='text'>" . $invalid_tweet_link . "</span></div>" ;
    // $archived_tweets_output = "<div class='archived_tweets'>
    //   <span class='text'>" . $archived_tweet_link . "</span></div>" ;
    $settings_output = "<div class='settings'>
      <span class='text'>" . TWITTER_SETTINGS_LABEL . "</span></div>" ;

    $output = "<div>" . $twitter_profile_output .
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

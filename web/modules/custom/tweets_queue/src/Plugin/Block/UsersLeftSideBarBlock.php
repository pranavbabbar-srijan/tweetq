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

    $picture = $user_twitter_profile_info->profile_image_url;
    $picture = tweets_queue_process_twitter_picture_url($picture);
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
    
    $import_csv_logs = "<a " . $class . " href='" . $base_url .'/' . TWITTER_IMPORT_CSV_LOG . "'>" .
      'logs' ."</a>";

    $class = tweets_queue_match_current_path($current_path, TWITTER_VALID_TWEET_PATH);
    $valid_tweet_link = "<a " . $class . " href='" . $base_url .'/' . TWITTER_VALID_TWEET_PATH . "'>" .
      TWITTER_VALID_TWEET_LABEL ."</a>";
    $class = tweets_queue_match_current_path($current_path, TWITTER_INVALID_TWEET_PATH);
    $invalid_tweet_link = "<a " . $class . " href='" . $base_url .'/' . TWITTER_INVALID_TWEET_PATH . "'>" .
      TWITTER_INVALID_TWEET_LABEL ."</a>";

    $class = tweets_queue_match_current_path($current_path, TWITTER_ARCHIVED_TWEET_PATH);
    $archived_tweet_link = "<a " . $class . " href='" . $base_url .'/' . TWITTER_ARCHIVED_TWEET_PATH . "'>" .
      TWITTER_ARCHIVED_TWEET_LABEL ."</a>";

    $class = tweets_queue_match_current_path($current_path, TWITTER_PROFILE_SETTING_PATH);
    $uid = \Drupal::currentUser()->id();
    $settings_link = "<a " . $class . " href='" . $base_url .'/user/' . $uid . '/edit' . "'>" .
      TWITTER_SETTING_LABEL ."</a>";

    $class = tweets_queue_match_current_path($current_path, TWITTER_TOTAL_TWEET_PATH);
    $total_twitt_link = "<a " . $class . " href='" . $base_url .'/' . TWITTER_TOTAL_TWEET_PATH . "'>" .
      TWITTER_TOTAL_TWEET_LABEL ."</a>";
    

    $create_tweet_output = "<div class='create_tweets'>
      <span class='text'>" . $create_tweet_link . "</span></div>" ;

    $import_tweets_output = "<div class='import_tweets'>
      <span class='text'>" . $import_tweet_link . "</span>" ;

    $import_csv_logs_output = "<div class='import_tweets_logs'>
      <span class='text'>" . $import_csv_logs . "</span></div></div>";


    $my_tweets_prefix = "<span class='mobile-display total_twitt_mobile'>" . $total_twitt_link . "</span><div id='my_tweets'> 
    <span class='text'>My Tweets</span>";

    $total_twitt_output = "<div class='archived_tweets'>
      <span class='text'>" . $total_twitt_link . "</span></div>";

    $valid_tweets_output = "<div class='valid_tweets'>
      <span class='text'>" . $valid_tweet_link . "</span>
      <span class='value'>" . $_SESSION["new"] . "<b>" . $_SESSION["valid_import"] . "</b></span></div>" ;

    $invalid_tweets_output = "<div class='invalid_tweets'>
      <span class='text'>" . $invalid_tweet_link . "</span>
      <span class='value'>" . $_SESSION["new"] . "<b>"  . $_SESSION["invalid_import"] . "</b></span></div>" ;

    $archived_tweets_output = "<div class='archived_tweets'>
      <span class='text'>" . $archived_tweet_link . "</span></div>" ;
    $my_tweets_suffix = "</div>";
   // $settings_output = "<div class='profile_settings'>
     // <span class='text'>" . $settings_link . "</span></div>" ;

    $output = "<div>" . $twitter_profile_output .
      $create_tweet_output . $import_tweets_output. $import_csv_logs_output . $my_tweets_prefix . $total_twitt_output . $valid_tweets_output . $invalid_tweets_output . $archived_tweets_output. $my_tweets_suffix . $settings_output . "</div>";
      unset($_SESSION["valid_import"]);
      unset($_SESSION["invalid_import"]);
      unset($_SESSION["new"]);

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

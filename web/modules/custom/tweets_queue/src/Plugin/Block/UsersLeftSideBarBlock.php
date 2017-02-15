<?php
/**
 * @file
 * Contains \Drupal\tweets_queue\Plugin\Block\UsersLeftSideBarBlock.
 */
namespace Drupal\tweets_queue\Plugin\Block;
use Drupal\Core\Block\BlockBase;

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

    $picture = '';
    $name = "lorem ipsum";
    $twitter_handle = "@loremipsum";
    $profile_img = "<img src='" . $picture . "'></img>";
    $twitter_profile_output = "<div class='profile'>
      <span class='img'>" . $profile_img . "</span>
      <span class='name'>" . $name . "</span>
      <span class='twitter_handle'>". $twitter_handle . "</span>
    </div>" ;

    $create_tweet_link = "<a href='" . $base_url .'/' . TWITTER_CREATE_TWEET_PATH . "'>" .
      TWITTER_CREATE_TWEET_LABEL ."</a>";
    $import_tweet_link = "<a href='" . $base_url .'/' . TWITTER_IMPORT_TWEET_PATH . "'>" .
      TWITTER_IMPORT_TWEET_LABEL ."</a>";

    $valid_tweet_link = "<a href='" . $base_url .'/' . TWITTER_VALID_TWEET_PATH . "'>" .
      TWITTER_VALID_TWEET_LABEL ."</a>";
    $invalid_tweet_link = "<a href='" . $base_url .'/' . TWITTER_INVALID_TWEET_PATH . "'>" .
      TWITTER_INVALID_TWEET_LABEL ."</a>";
    $archived_tweet_link = "<a href='" . $base_url .'/' . TWITTER_ARCHIVED_TWEET_PATH . "'>" .
      TWITTER_ARCHIVED_TWEET_LABEL ."</a>";

    $create_tweet_output = "<div class='create_tweets'>
      <span class='text'>" . $create_tweet_link . "</span></div>" ;
    $import_tweets_output = "<div class='import_tweets'>
      <span class='text'>" . $import_tweet_link . "</span></div>" ;

    $valid_tweets_output = "<div class='valid_tweets'>
      <span class='text'>" . $valid_tweet_link . "</span></div>" ;
    $invalid_tweets_output = "<div class='invalid_tweets'>
      <span class='text'>" . $invalid_tweet_link . "</span></div>" ;
    $archived_tweets_output = "<div class='archived_tweets'>
      <span class='text'>" . $archived_tweet_link . "</span></div>" ;
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
}
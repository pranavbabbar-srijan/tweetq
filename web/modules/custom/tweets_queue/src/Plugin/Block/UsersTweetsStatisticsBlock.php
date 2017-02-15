<?php
/**
 * @file
 * Contains \Drupal\tweets_queue\Plugin\Block\UsersTweetsStatisticsBlock.
 */
namespace Drupal\tweets_queue\Plugin\Block;
use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'twitter' block.
 *
 * @Block(
 *   id = "users_tweets_statistics_block",
 *   admin_label = @Translation("Users Tweets statistics block"),
 *   category = @Translation("Twitter users staticstics block")
 * )
 */
class UsersTweetsStatisticsBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    global $base_url;
    $valid_tweets = 120;
    $invalid_tweets = 291;
    $archived_tweets = 291;

    $valid_tweets_output = "<div class='valid_tweets'>
        <span class='text'>" . TWITTER_VALID_TWEET_LABEL . "</span>" .
        "<span class='value'>" . $valid_tweets . "</span>
      </div>" ;
    $valid_tweet_link = "<a href='" . $base_url .'/' . TWITTER_VALID_TWEET_PATH . "'>" .
      $valid_tweets_output ."</a>";

    $invalid_tweets_output = "<div class='invalid_tweets'>
        <span class='text'>" . TWITTER_INVALID_TWEET_LABEL . "</span>" .
        "<span class='value'>" . $invalid_tweets . "</span>
      </div>" ;
    $invalid_tweet_link = "<a href='" . $base_url .'/' . TWITTER_INVALID_TWEET_PATH . "'>" .
      $invalid_tweets_output ."</a>";

    $archived_tweets_output = "<div class='archived_tweets'>
        <span class='text'>" . TWITTER_ARCHIVED_TWEET_LABEL . "</span>" .
        "<span class='value'>" . $archived_tweets . "</span>
      </div>" ;
    $archived_tweet_link = "<a href='" . $base_url .'/' . TWITTER_ARCHIVED_TWEET_PATH . "'>" .
      $archived_tweets_output ."</a>";

    $total_tweets = $valid_tweets + $invalid_tweets + $archived_tweets;

    $total_tweets_output = "<div class='total_tweets'>
        <span class='text'>" . TWITTER_TOTAL_TWEET_LABEL . "</span>" .
        "<span class='value'>" . $total_tweets . "</span>
      </div>" ;
    $total_tweet_link = "<a href='" . $base_url .'/' . TWITTER_TOTAL_TWEET_PATH . "'>" .
      $total_tweets_output ."</a>";

    $output = "<div>" . $total_tweet_link . $valid_tweet_link .
      $invalid_tweet_link . $archived_tweet_link . "</div>";

    return array(
      '#type' => 'markup',
      '#markup' => $output,
    );
  }
}
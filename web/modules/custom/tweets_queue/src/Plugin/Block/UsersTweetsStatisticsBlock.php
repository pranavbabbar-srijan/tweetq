<?php
/**
 * @file
 * Contains \Drupal\tweets_queue\Plugin\Block\UsersTweetsStatisticsBlock.
 */
namespace Drupal\tweets_queue\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;
use Drupal\Core\Cache\Cache;

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
    $valid_tweets = tweets_queue_get_users_total_tweets_count(USERS_VALID_TWEET);
    $invalid_tweets = tweets_queue_get_users_total_tweets_count(USERS_INVALID_TWEET);
    $archived_tweets = tweets_queue_get_users_total_tweets_count(USERS_ARCHIVED_TWEET);

    $valid_tweets_output = "<div class='valid_tweets'>
        <span class='text'>" . TWITTER_VALID_TWEET_LABEL . "</span>" .
        "<span class='value'>" . $valid_tweets . "</span>
      </div>" ;
    $valid_tweet_url = Url::fromRoute(TWITTER_VALID_TWEETS_ROUTE_NAME,
      [],
      ['attributes' => ['class' => 'valid_tweets']]
    );
    $valid_tweet_link = \Drupal::l(t($valid_tweets_output), $valid_tweet_url);

    $invalid_tweets_output = "<div class='valid_tweets'>
        <span class='text'>" . TWITTER_INVALID_TWEET_LABEL . "</span>" .
        "<span class='value'>" . $invalid_tweets . "</span>
      </div>" ;
    $invalid_tweet_url = Url::fromRoute(TWITTER_INVALID_TWEETS_ROUTE_NAME,
      [],
      ['attributes' => ['class' => 'invalid_tweets']]
    );
    $invalid_tweet_link = \Drupal::l(t($invalid_tweets_output), $invalid_tweet_url);

    $archived_tweets_output = "<div class='archived_tweets'>
        <span class='text'>" . TWITTER_ARCHIVED_TWEET_LABEL . "</span>" .
        "<span class='value'>" . $archived_tweets . "</span>
      </div>" ;
    $archived_tweet_url = Url::fromRoute(TWITTER_ARCHIVED_TWEETS_ROUTE_NAME,
      [],
      ['attributes' => ['class' => 'archived_tweets']]
    );
    $archived_tweet_link = \Drupal::l(t($archived_tweets_output), $archived_tweet_url);

    $total_tweets = $valid_tweets + $invalid_tweets + $archived_tweets;

    $total_tweets_output = "<div class='total_tweets'>
        <span class='text'>" . TWITTER_TOTAL_TWEET_LABEL . "</span>" .
        "<span class='value'>" . $total_tweets . "</span>
      </div>" ;
    $all_tweet_url = Url::fromRoute(TWITTER_ALL_TWEETS_ROUTE_NAME,
      [],
      ['attributes' => ['class' => 'total_tweets']]
    );
    $total_tweet_link = \Drupal::l(t($total_tweets_output), $all_tweet_url);

    $output = "<div>" . $total_tweet_link . $valid_tweet_link .
      $invalid_tweet_link . $archived_tweet_link . "</div>";

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
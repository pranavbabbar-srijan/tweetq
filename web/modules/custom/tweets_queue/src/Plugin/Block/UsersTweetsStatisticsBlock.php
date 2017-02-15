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
    $valid_tweets = 120;
    $invalid_tweets = 291;
    $archived_tweets = 291;
    $valid_tweets_output = "<div class='valid_tweets'>
        <span class='text'>Valid Tweets</span>" .
        "<span class='value'>" . $valid_tweets . "</span>
      </div>" ;
    $invalid_tweets_output = "<div class='invalid_tweets'>
        <span class='text'>Invalid Tweets</span>" .
        "<span class='value'>" . $invalid_tweets . "</span>
      </div>" ;
    $archived_tweets_output = "<div class='archived_tweets'>
        <span class='text'>Archived Tweets</span>" .
        "<span class='value'>" . $archived_tweets . "</span>
      </div>" ;

    $total_tweets = $valid_tweets + $invalid_tweets + $archived_tweets;

    $total_tweets_output = "<div class='total_tweets'>
        <span class='text'>Total Tweets</span>" .
        "<span class='value'>" . $total_tweets . "</span>
      </div>" ;

    $output = "<div>" . $total_tweets_output . $valid_tweets_output .
      $invalid_tweets_output . $archived_tweets_output . "</div>";

    return array(
      '#type' => 'markup',
      '#markup' => $output,
    );
  }
}
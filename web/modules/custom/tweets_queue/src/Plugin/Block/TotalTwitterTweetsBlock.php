<?php
/**
 * @file
 * Contains \Drupal\tweets_queue\Plugin\Block\TotalTwitterTweetsBlock.
 */
namespace Drupal\tweets_queue\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;

/**
 * Provides a 'twitter' block.
 *
 * @Block(
 *   id = "total_twitter_tweets_block",
 *   admin_label = @Translation("Twitter tweets block"),
 *   category = @Translation("Twitter tweets count block")
 * )
 */
class TotalTwitterTweetsBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
  	$total = tweets_queue_fetch_twitter_statistics_info('tweets_count');
  	$total_data = tweets_queue_number_shorten($total, 1);
  	$output = "<div><div class='count'>" . $total_data . '</div>';
    // $title_total = t('Total Tweets @total', array('@total' => $total));
    // $output .= "<div class='label' title='" . $title_total . "'>" . t('Tweets') . '</div></div>';
  	$output .= "<div class='label'>" . t('Tweets') . '</div></div>';
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
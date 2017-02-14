<?php
/**
 * @file
 * Contains \Drupal\tweets_queue\Plugin\Block\TotalTwitterUsersBlock.
 */
namespace Drupal\tweets_queue\Plugin\Block;
use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'twitter' block.
 *
 * @Block(
 *   id = "total_twitter_users_block",
 *   admin_label = @Translation("Twitter users block"),
 *   category = @Translation("Twitter users count block")
 * )
 */
class TotalTwitterUsersBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
  	$total = tweets_queue_fetch_twitter_statistics_info('users_count');
  	$total_data = tweets_queue_number_shorten($total, 1);
  	$output = "<div><div class='count'>" . $total_data . '</div>';
  	$output .= "<div class='label'>" . t('Users') . '</div></div>';
  	return array(
      '#type' => 'markup',
      '#markup' => $output,
    );
  }
}
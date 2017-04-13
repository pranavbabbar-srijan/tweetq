<?php
/**
 * @file
 * Contains \Drupal\tweets_queue\Plugin\Block\RedirectUserBlock.
 */
namespace Drupal\tweets_queue\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;

/**
 * Provides a 'twitter' block.
 *
 * @Block(
 *   id = "redirect_user_block",
 *   admin_label = @Translation("Redirect user block"),
 *   category = @Translation("Twitter redirect user block")
 * )
 */
class RedirectUserBlock extends BlockBase {
  /**
   *
   * {@inheritdoc}
   */
  public function build() {
    $path = \Drupal::request()->getpathInfo();
    $arg  = explode('/',$path);
    if ($arg[1] == 'user' && $arg[2] != '' && $arg[3] != 'edit') {
      tweets_queue_goto_dashboard();
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }
}
<?php
/**
 * @file
 * Contains \Drupal\tweets_queue\Plugin\Block\SignInWithTwitterBlock.
 */
namespace Drupal\tweets_queue\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;

/**
 * Provides a 'twitter' block.
 *
 * @Block(
 *   id = "sign_in_with_twitter_block",
 *   admin_label = @Translation("Sign in with twitter block"),
 *   category = @Translation("Sign in with twitter block")
 * )
 */
class SignInWithTwitterBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    global $base_url;
    $output = tweets_queue_show_twitter_signin_block();
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
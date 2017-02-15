<?php
/**
 * @file
 * Contains \Drupal\tweets_queue\Plugin\Block\UsersDashboardHeaderBlock.
 */
namespace Drupal\tweets_queue\Plugin\Block;
use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'twitter' block.
 *
 * @Block(
 *   id = "users_dashboard_header_block",
 *   admin_label = @Translation("Users Dashboard header block"),
 *   category = @Translation("Twitter users dashboard header block")
 * )
 */
class UsersDashboardHeaderBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    $name = "lorem ipsum";
    $profile_img = "<img src=''></img>";
    $twitter_profile_output = "<div class='profile'>
      <span class='img'>" . $profile_img . "</span>
      <span class='name'>" . $name . "</span>
    </div>" ;

    $message_history_count = 2;
    $message_history_count_output = "<div>
      <span class='count'>" . $message_history_count . "</span>
    </div>";
    $message_history_data = " <div>
      <span class='message_history_count'>You have 2 Notifications</span>
    </div>
    <div>
      <span class='state'>Retweeted</span>
      <span class='time'>20 min ago</span>
      <span class='message'>lorem ipsum lorem ipsum lorem ipsum #srijan @srijan</span>
    </div>
    <div>
      <span class='state'>New Tweet</span>
      <span class='time'>18 min ago</span>
      <span class='message'>lorem ipsum lorem ipsum lorem ipsum #srijan @srijanfoundation</span>
    </div>";

    $output = "<div class='notifications'>" . $message_history_count_output . 
      $message_history_data . $twitter_profile_output . "</div>";

    return array(
      '#type' => 'markup',
      '#markup' => $output,
    );
  }
}
<?php
/**
 * @file
 * Contains \Drupal\tweets_queue\Plugin\Block\UsersDashboardHeaderProfileBlock.
 */
namespace Drupal\tweets_queue\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;

/**
 * Provides a 'twitter' block.
 *
 * @Block(
 *   id = "users_dashboard_header_profile_block",
 *   admin_label = @Translation("Users Dashboard header non twitter  profile block"),
 *   category = @Translation("Twitter users dashboard non twitter header profile block")
 * )
 */
class UsersDashboardHeaderProfileBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    if(in_array(TWITTER_APPROVED_CLIENT_ROLE, $user_roles)) {
      return array(
        '#type' => 'markup',
        '#markup' => '',
      );
    }
    $name = '';
    $uid = ($uid == '') ? \Drupal::currentUser()->id() : $uid;
    $user = \Drupal\user\Entity\User::load($uid);
    $name = $user->get(SIGNUP_FIELD_FULL_NAME)->value;
    $profile_img = "<img src=''></img>";

    $twitter_profile_output = "<div class='profile'>
        <div><span class='img'>" . $profile_img . "</span>
        <span class='name'>" . $name . "</span></div>
      </div>" ;
    $message_history_count = 2;
    $message_history_count_output = "<div>
        <span class='count'> </span>
      </div>";
    $message_history_data = "";

    $output = "<div class='notifications'>" . $message_history_count_output . 
      $message_history_data . "</div>" . $twitter_profile_output;
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
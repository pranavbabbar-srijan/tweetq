<?php
/**
 * @file
 * Contains \Drupal\tweets_queue\Plugin\Block\UsersDashboardHeaderBlock.
 */
namespace Drupal\tweets_queue\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;

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
    $tweets_history = tweets_queue_fetch_user_tweets_history();
    $message_history_count = count($tweets_history);
    // echo '<pre>', print_r($data); die();

    $twitter_profile_info = tweets_queue_fetch_twitter_statistics_info(TWITTER_HANDLER_PROFILE);
    $user_twitter_profile_info = unserialize($twitter_profile_info);
    if (empty($twitter_profile_info)) {
      $uid = ($uid == '') ? \Drupal::currentUser()->id() : $uid;
      $user = \Drupal\user\Entity\User::load($uid);
      $name = $user->get(SIGNUP_FIELD_FULL_NAME)->value;
      $picture = '';
      $picture = $user_twitter_profile_info->profile_image_url;
      $profile_img = "<img src='http://abs.twimg.com/sticky/default_profile_images/default_profile_0_normal.png'></img>";
    }
    else {
      $picture = '';
  -   $name = $user_twitter_profile_info->name;
      $picture = '';
      $picture = $user_twitter_profile_info->profile_image_url;
      $profile_img = "<img src='" . $picture . "'></img>";
    }



    $my_profile_link = "<a class ='profile-my-profile' href='" . $base_url .'/' . "'>" .
      'My Profile' ."</a>";
    $setting_link = "<a class ='profile-settings' href='" . $base_url .'/' . "'>" .
      'Settings' ."</a>";
    $logout_link = "<a class ='profile-logout' href='" . $base_url .'/user/logout' . "'>" .
      'Logout' ."</a>";
    $profile_link_output = "<div class='profile-links'> " .
    $my_profile_link . $setting_link . $logout_link . "</div>" ;

    $twitter_profile_output = "<div class='profile'>
      <a href=''>" . "<div><span class='img'>" . $profile_img . "</span>
      <span class='name'>" . $name . "</span></div> " . $profile_link_output . "</a>
      </div>" ;


    $message_history_count_output = "<div>
      <span class='count'>" . $message_history_count . "</span>
    </div>";

    $message_history_data = "<div class='notification-message-list'>";
    $message_history_data .= " <div>
      <span class='message_history_count'>You have " . $message_history_count_output . " Notifications</span>
    </div>";
    foreach ($tweets_history as $data) {
      $retweet_label = ($data->retweeted) ? 'Retweeted' : 'New Tweet';
      $message = tweets_queue_perform_hashtag_highlight($data->message);
      $created = $data->created;
      $tweeted_at = tweets_queue_format_tweet_time($created);
      $message_history_data .= t("<div>
        <span class='state'>@retweet_label</span>
        <span class='time'>@tweeted_at</span>
        <span class='message'>@message</span>
        </div>",
      array(
        '@retweet_label' => $retweet_label,
        '@tweeted_at' => $tweeted_at,
        '@message' => $message
        )
      );
    }
    $message_history_data .= "</div>";
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

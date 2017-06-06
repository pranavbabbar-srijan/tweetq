<?php
/**
 * @file
 * Contains \Drupal\tweets_queue\Plugin\Block\AllUsersTweetsHistoryBlock.
 */
namespace Drupal\tweets_queue\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;
use Drupal\Core\Cache\Cache;

/**
 * Provides a 'twitter' block.
 *
 * @Block(
 *   id = "all_users_tweets_history_block",
 *   admin_label = @Translation("All Users tweets history block"),
 *   category = @Translation("All users tweets history block")
 * )
 */
class AllUsersTweetsHistoryBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    global $base_url;
    $header = array(t('Cron Id'), t('Cron Run Time'), t('Twitter Name'), t('Tweet Message'), t('Tweet Time'), t('Status'));

    $nid = tweets_queue_get_parameter_data(TWITTER_FIELD_NID);
    $uid = tweets_queue_get_parameter_data(TWITTER_FIELD_UID);
    $cron_id = tweets_queue_get_parameter_data('cron_id');
    $active = ($nid) ? TWITTER_FIELD_NID : ($uid ? TWITTER_FIELD_UID : ($cron_id ? 'cron_id' : ''));

    $user_roles = \Drupal::currentUser()->getRoles();
    if(!in_array(TWITTER_ADMINISTRATOR_ROLE, $user_roles)) {
      $uid = \Drupal::currentUser()->id();
    }

    $query = \Drupal::database()->select(TWITTER_TWEETS_HISTORY_TABLE, 'p');
    $query->fields('p', [TWITTER_FIELD_NID, TWITTER_FIELD_UID, TWITTER_FIELD_STATUS, TWITTER_FIELD_RETWEETED, TWITTER_FIELD_CODE]);
    if ($nid) {
      $query->condition('p.' . TWITTER_FIELD_NID, $nid);
    }
    if ($uid) {
      $query->condition('p.' . TWITTER_FIELD_UID, $uid);
    }
    $query->addField('p', TWITTER_FIELD_MESSAGE, 'error');
    $query->addField('p', TWITTER_FIELD_CREATED, 'tweet_created_time');

    $query->leftjoin(TWITTER_AUTH_MAP_TABLE, 'a', 'p.uid=a.uid');
    $query->leftjoin(twitter_statistics, 's', "s.name= concat('thp-',a.twitter_owner_id)");
    $query->addField('s', 'value', 'screen_name');

    $query->leftjoin(TWITTER_CRON_HISTORY_TABLE, 'c', 'p.cron_id=c.id');
    if ($cron_id) {
      $query->condition('c.id', $cron_id);
    }
    $query->fields('c', ['id']);
    $query->addField('c', 'created', 'cron_time');

    $query->leftjoin(TWITTER_MESSAGE_QUEUE_TABLE, 'm', 'p.nid = m.nid');

    $query->addField('m', TWITTER_FIELD_MESSAGE, TWITTER_FIELD_MESSAGE);
    $query->orderBy('p.created', 'DESC');

    $table_sort = $query->extend('Drupal\Core\Database\Query\TableSortExtender')->orderByHeader($header);
    $pager = $table_sort->extend('Drupal\Core\Database\Query\PagerSelectExtender')->limit(TWITTER_TWEETS_LISTING_ROW_LIMIT);
    $result = $pager->execute();

    $data = array();
    $total = 0;
    foreach($result as $row) {
      $total++;
      $cron_time = ($row->cron_time) ? date(TWITTER_TWEET_DATE_FORMAT, $row->cron_time) : '';
      $tweet_time = ($row->tweet_created_time) ? date(TWITTER_TWEET_DATE_FORMAT, $row->tweet_created_time) : '';

      $message = tweets_queue_decrypt_data($row->{TWITTER_FIELD_MESSAGE});
      $message = tweets_queue_perform_hashtag_highlight($message);

      $message_url_link = $this->makeLink(TWITTER_HISTORY_ROUTE_NAME, TWITTER_FIELD_NID, $message, $row->{TWITTER_FIELD_NID}, $active);
      $user_url_link = $this->makeLink(TWITTER_HISTORY_ROUTE_NAME, TWITTER_FIELD_UID, $row->screen_name, $row->{TWITTER_FIELD_UID}, $active);
      $cron_url_link = $this->makeLink(TWITTER_HISTORY_ROUTE_NAME, 'cron_id', $row->id, $row->id, $active);

      $error = trim(t($row->error));
      if (empty($error)) {
        $error = ($row->{TWITTER_FIELD_RETWEETED}) ? t('Retweet') : t("Tweet");
      }

      $rows[] = array($cron_url_link, $cron_time, $user_url_link, $message_url_link, $tweet_time, $error);
    }

    $tweet_url = Url::fromRoute(TWITTER_HISTORY_ROUTE_NAME,
        [],
        ['attributes' => ['class' => 'tweets-history']]
    );
    $tweet_url_link = \Drupal::l(t('Tweets History'), $tweet_url);

    if ($total) {
      $build = array(
        '#markup' => $tweet_url_link
      );

      $build['all_tweets'] = array(
        '#header' => $header,
        '#theme' => 'table',
        '#rows' => $rows
      );
      $build['pager'] = array(
       '#type' => 'pager'
      );

      return $build;
    }
    if (!$total) {
      return array(
        '#type' => 'markup',
        '#markup' => t('No history found'),
      );
    }
  }

  public function makeLink($route_name, $field_name, $field_value, $label, $active) {
    $output = $field_value;
    if ($field_name == $active) {
      return $field_value;
    }
    $url = Url::fromRoute(TWITTER_HISTORY_ROUTE_NAME,
        [$field_name => $label]
      );
    $url_link = \Drupal::l($field_value, $url);
    return $url_link;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }
}

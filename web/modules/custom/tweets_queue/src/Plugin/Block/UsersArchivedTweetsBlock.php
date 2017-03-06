<?php
/**
 * @file
 * Contains \Drupal\tweets_queue\Plugin\Block\UsersArchivedTweetsBlock.
 */
namespace Drupal\tweets_queue\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;
use Drupal\Core\Cache\Cache;

/**
 * Provides a 'twitter' block.
 *
 * @Block(
 *   id = "users_archived_tweets_block",
 *   admin_label = @Translation("Users archived tweets block"),
 *   category = @Translation("Twitter users archived tweets block")
 * )
 */
class UsersArchivedTweetsBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    global $base_url;
    $uid = \Drupal::currentUser()->id();
    
    $header = array(t('Message'), t('Size'), t('Created'), t('Tweet Date'),
      t('Last Updated'), t('Retweeted'), t('Modify'));
    
    $query = \Drupal::database()->select(TWITTER_MESSAGE_QUEUE_TABLE, 'p');
    $query->fields('p', ['nid', 'message', 'size', 'created' ,'changed', 'tweeted', 'first_run', 'last_run']);
    $query->condition('p.archived', 1, '=');
    $query->condition('p.status', TWITTER_PUBLISHED_TWEET, '=');
    $query->condition('p.tweet_id', '', '!=');
    $query->condition('p.uid', $uid);
    $query->orderBy('p.nid', 'DESC');

    $table_sort = $query->extend('Drupal\Core\Database\Query\TableSortExtender')->orderByHeader($header);
    $pager = $table_sort->extend('Drupal\Core\Database\Query\PagerSelectExtender')->limit(10);
    $result = $pager->execute();

    $data = array();
    $total = 0;
    foreach($result as $row) {
      $total++;
      $rows[] = $this->compileData($row);
    }

    if ($total) {
      $build = array(
        '#markup' => ''
      );

      $build['header'] = array(
        '#theme' => 'item_list',
        '#items' => $header,
        '#attributes' => array('class' => array('header')),
      );

      $build['archived_tweets'] = array(
        '#theme' => 'item_list',
        '#items' => $rows
      );
      $build['pager'] = array(
       '#type' => 'pager'
      );
      return $build;
    }
    if (!$total) {
      return array(
        '#type' => 'markup',
        '#markup' => tweets_queue_no_tweets_found_message(),
      );
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }

  private function compileData($row) {
    $delete_url = Url::fromRoute(TWITTER_TWEET_FORM_ROUTE_NAME,
      ['nid' => $row->nid, 'action' => 'delete'],
      ['attributes' => ['class' => 'delete']]
    );
    $delete_url_link = \Drupal::l(t('Delete'), $delete_url);
    $data = array();
    $data['message'] = $row->message;
    $data['size'] = $row->size;
    $data['created'] = date(TWITTER_DATE_FORMAT, $row->created);
    $data['tweet_data'] = date(TWITTER_DATE_FORMAT, $row->first_run);
    $data['changed'] = date(TWITTER_DATE_FORMAT, $row->changed);
    $data['retweeted'] = t('@times times', array('@times' => $row->tweeted));
    $data['delete_link'] = $delete_url_link ;
    return array('data' => $data);
  }
}
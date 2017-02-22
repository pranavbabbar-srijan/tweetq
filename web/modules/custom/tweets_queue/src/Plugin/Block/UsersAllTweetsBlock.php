<?php
/**
 * @file
 * Contains \Drupal\tweets_queue\Plugin\Block\UsersAllTweetsBlock.
 */
namespace Drupal\tweets_queue\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;

/**
 * Provides a 'twitter' block.
 *
 * @Block(
 *   id = "users_all_tweets_block",
 *   admin_label = @Translation("Users all tweets block"),
 *   category = @Translation("Twitter users all tweets block")
 * )
 */
class UsersAllTweetsBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    global $base_url;
    $uid = \Drupal::currentUser()->id();
    
    $header = array(t('Message'), t('Size'), t('Created'), t('Tweet Date'),
      t('Last Updated'), t('Retweeted'), t('Delete'));
    
    $query = \Drupal::database()->select(TWITTER_MESSAGE_QUEUE_TABLE, 'p');
    $query->fields('p', ['nid', 'message', 'size', 'created' ,'changed']);
    $query->condition('p.uid', $uid);

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

      $build['all_tweets'] = array(
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
        '#markup' => t('No tweets found.'),
      );
    }
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
    $data['tweet_data'] = date(TWITTER_DATE_FORMAT, $row->created);//@TODO
    $data['changed'] = date(TWITTER_DATE_FORMAT, $row->changed);
    $data['retweeted'] = t('24 times');
    $data['delete_link'] = $delete_url_link ;
    return array('data' => $data);
  }
}
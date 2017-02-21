<?php
/**
 * @file
 * Contains \Drupal\tweets_queue\Plugin\Block\UsersArchivedTweetsBlock.
 */
namespace Drupal\tweets_queue\Plugin\Block;
use Drupal\Core\Block\BlockBase;

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
      t('Last Updated'), t('Retweeted'), t('Delete'));
    
    $query = \Drupal::database()->select(TWITTER_MESSAGE_QUEUE_TABLE, 'p');
    $query->fields('p', ['nid', 'message', 'size', 'created' ,'changed']);
    // Only bring active handlers.
    $query->condition('p.archived', 1, '=');
    $query->condition('p.tweet_id', '', '!=');
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

      $build['valid_tweets'] = array(
        '#theme' => 'table',
        '#header' => $header,
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
        '#markup' => t('No tweets found.'),
      );
    }
  }

  private function compileData($row) {
    $data = array();
    $data['message'] = $row->message;
    $data['size'] = $row->size;
    $data['created'] = $row->created;
    $data['changed'] = $row->changed;
    return array('data' => $data);
  }
}
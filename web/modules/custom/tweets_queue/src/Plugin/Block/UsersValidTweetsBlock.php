<?php
/**
 * @file
 * Contains \Drupal\tweets_queue\Plugin\Block\UsersValidTweetsBlock.
 */
namespace Drupal\tweets_queue\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;

/**
 * Provides a 'twitter' block.
 *
 * @Block(
 *   id = "users_valid_tweets_block",
 *   admin_label = @Translation("Users valid tweets block"),
 *   category = @Translation("Twitter users valid tweets block")
 * )
 */
class UsersValidTweetsBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    global $base_url;
    $uid = \Drupal::currentUser()->id();
    
    $header = array(t('Message'), t('Size'), t('Created'), t('Last Updated'), t('Edit'));
    
    $query = \Drupal::database()->select(TWITTER_MESSAGE_QUEUE_TABLE, 'p');
    $query->fields('p', ['nid', 'message', 'size', 'created' ,'changed']);
    $query->condition('p.size', 140, '<=');
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

      $new_tweet_url = Url::fromRoute(TWITTER_NEW_TWEET_ROUTE_NAME, [],
        ['attributes' => ['class' => 'new_tweets']]
      );
      $new_tweet_url_link = \Drupal::l(t("New Tweets(1)"), $new_tweet_url);

      $tweeted_tweet_url = Url::fromRoute(TWITTER_TWEETED_TWEET_ROUTE_NAME, [],
        ['attributes' => ['class' => 'tweeted_tweets']]
      );
      $tweeted_url_link = \Drupal::l(t("Tweeted(14)"), $tweeted_tweet_url);

      $build['new_tweets'] = array(
        '#markup' => $new_tweet_url_link
      );

      $build['tweets_tweets'] = array(
        '#markup' => $tweeted_url_link
      );

      $build['header'] = array(
        '#theme' => 'item_list',
        '#items' => $header,
        '#attributes' => array('class' => array('header')),
      );

      $build['valid_tweets'] = array(
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
    $edit_url = Url::fromRoute(TWITTER_TWEET_FORM_ROUTE_NAME,
      ['nid' => $row->nid, 'action' => 'edit'],
      ['attributes' => ['class' => 'edit']]
    );
    $delete_url = Url::fromRoute(TWITTER_TWEET_FORM_ROUTE_NAME,
      ['nid' => $row->nid, 'action' => 'delete'],
      ['attributes' => ['class' => 'delete']]
    );

    $edit_url_link = \Drupal::l(t("Edit"), $edit_url);
    $delete_url_link = \Drupal::l(t('Delete'), $delete_url);

    $data = array();
    $data['message'] = $row->message;
    $data['size'] = $row->size;
    $data['created'] = date(TWITTER_DATE_FORMAT, $row->created);
    $data['changed'] = date(TWITTER_DATE_FORMAT, $row->changed);
    $data['edit_link'] = $edit_url_link ;
    $data['delete_link'] = $delete_url_link ;
    return array('data' => $data);
  }
}
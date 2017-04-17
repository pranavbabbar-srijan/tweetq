<?php
/**
 * @file
 * Contains \Drupal\tweets_queue\Plugin\Block\UsersAllTweetsBlock.
 */
namespace Drupal\tweets_queue\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;
use Drupal\Core\Cache\Cache;

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
    
    $current_filter = (isset($_GET['filter'])) ? $_GET['filter'] : TWITTER_DEFAULT_SORT_FIELD;

    $current_filter_order = (isset($_GET['order'])) ? $_GET['order'] : TWITTER_DEFAULT_SORT_ORDER;
    $new_filter_order = (isset($_GET['order'])) ? ($_GET['order'] == 'DESC' ? 'ASC' : 'DESC') : TWITTER_DEFAULT_NEW_SORT_ORDER;

    $created_sort_link = tweets_queue_generate_filter(TWITTER_ALL_TWEETS_ROUTE_NAME,
      TWITTER_FIELD_CREATED, $current_filter, $new_filter_order);
    $tweet_date_sort_link = tweets_queue_generate_filter(TWITTER_ALL_TWEETS_ROUTE_NAME,
      TWITTER_FIELD_FIRST_RUN, $current_filter, $new_filter_order);

    $changed_sort_link = tweets_queue_generate_filter(TWITTER_ALL_TWEETS_ROUTE_NAME,
      TWITTER_FIELD_CHANGED, $current_filter, $new_filter_order);

    $tweeted_sort_link = tweets_queue_generate_filter(TWITTER_ALL_TWEETS_ROUTE_NAME,
      TWITTER_FIELD_TWEETED, $current_filter, $new_filter_order);

     $header = array(t(TWITTER_FIELD_MESSAGE_LABEL), t(TWITTER_FIELD_SIZE_LABEL), $created_sort_link, $tweet_date_sort_link,
      $changed_sort_link, $tweeted_sort_link, t(TWITTER_FIELD_EDIT_LABEL));

    $query = \Drupal::database()->select(TWITTER_MESSAGE_QUEUE_TABLE, 'p');
    $query->fields('p', [TWITTER_FIELD_NID,TWITTER_FIELD_MESSAGE, TWITTER_FIELD_SIZE,
      TWITTER_FIELD_CREATED ,TWITTER_FIELD_CHANGED, TWITTER_FIELD_TWEETED, TWITTER_FIELD_FIRST_RUN, TWITTER_FIELD_LAST_RUN]);
    $query->condition('p.uid', $uid);
    $query->orderBy('p.' . $current_filter, $current_filter_order);

    $table_sort = $query->extend('Drupal\Core\Database\Query\TableSortExtender')->orderByHeader($header);
    $pager = $table_sort->extend('Drupal\Core\Database\Query\PagerSelectExtender')->limit(TWITTER_TWEETS_LISTING_ROW_LIMIT);
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
        '#markup' => tweets_queue_no_tweets_found_message(),
      );
    }
  }

  private function compileData($row) {
    $delete_url = Url::fromRoute(TWITTER_TWEET_FORM_ROUTE_NAME,
      ['nid' => $row->nid, 'action' => 'delete'],
      ['attributes' => ['class' => 'delete colorbox cboxElement']]
    );
    $edit_url = Url::fromRoute(TWITTER_TWEET_FORM_ROUTE_NAME,
      ['nid' => $row->nid, 'action' => 'edit'],
      ['attributes' => ['class' => 'edit']]
    );
    $edit_url_link = \Drupal::l(t("Edit"), $edit_url);
    $delete_url_link = \Drupal::l(t('Delete'), $delete_url);
    $data = array();
    $data['message'] = tweets_queue_perform_hashtag_highlight($row->{TWITTER_FIELD_MESSAGE});
    $data['size'] = $row->{TWITTER_FIELD_SIZE};
    $data['created'] = date(TWITTER_DATE_FORMAT, $row->{TWITTER_FIELD_CREATED});


    $tweet_date = ($row->{TWITTER_FIELD_FIRST_RUN}) ? date(TWITTER_DATE_FORMAT, $row->{TWITTER_FIELD_FIRST_RUN}) : '-';
    $data['tweet_data'] = $tweet_date;
    // $data['tweet_data'] = date(TWITTER_DATE_FORMAT, ($row->{TWITTER_FIELD_FIRST_RUN}
    //   ? $row->{TWITTER_FIELD_FIRST_RUN} : $row->{TWITTER_FIELD_CREATED}));


    $changed = ($row->{TWITTER_FIELD_CHANGED}) ? date(TWITTER_DATE_FORMAT, $row->{TWITTER_FIELD_CHANGED}) : '-';
    $data['changed'] = $changed;
    // $data['changed'] = date(TWITTER_DATE_FORMAT, $row->{TWITTER_FIELD_CHANGED});
    $data['retweeted'] = t('@times', array('@times' => $row->tweeted));
    $data['edit_link'] = $edit_url_link ;
    $data['delete_link'] = $delete_url_link ;
    return array('data' => $data);
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }
}
<?php
/**
 * @file
 * Contains \Drupal\tweets_queue\Plugin\Block\UsersInValidTweetsBlock.
 */
namespace Drupal\tweets_queue\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;
use Drupal\Core\Cache\Cache;

/**
 * Provides a 'twitter' block.
 *
 * @Block(
 *   id = "users_in_valid_tweets_block",
 *   admin_label = @Translation("Users invalid tweets block"),
 *   category = @Translation("Twitter users invalid tweets block")
 * )
 */
class UsersInValidTweetsBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    global $base_url;
    $uid = \Drupal::currentUser()->id();
    
    $current_filter = (isset($_GET['filter'])) ? $_GET['filter'] : TWITTER_DEFAULT_SORT_FIELD;
    $current_filter_order = (isset($_GET['order'])) ? $_GET['order'] : TWITTER_DEFAULT_SORT_ORDER;
    $new_filter_order = (isset($_GET['order'])) ? ($_GET['order'] == 'DESC' ? 'ASC' : 'DESC') : TWITTER_DEFAULT_NEW_SORT_ORDER;

    $created_sort_link = tweets_queue_generate_filter(TWITTER_INVALID_TWEETS_ROUTE_NAME,
      TWITTER_FIELD_CREATED, $current_filter, $new_filter_order);

    $changed_sort_link = tweets_queue_generate_filter(TWITTER_INVALID_TWEETS_ROUTE_NAME,
      TWITTER_FIELD_CHANGED, $current_filter, $new_filter_order);

    $header = array(t(TWITTER_FIELD_MESSAGE_LABEL), t(TWITTER_FIELD_SIZE_LABEL), $created_sort_link, $changed_sort_link, t(TWITTER_FIELD_EDIT_LABEL), t('<span class="custom-checkbox"><input type="checkbox" name="all-selected-deleted" ><label></label></span>'));
    
    $query = \Drupal::database()->select(TWITTER_MESSAGE_QUEUE_TABLE, 'p');
    $query->fields('p', ['nid', TWITTER_FIELD_MESSAGE, TWITTER_FIELD_SIZE, TWITTER_FIELD_CREATED ,TWITTER_FIELD_CHANGED]);
    $query->condition('p.status', TWITTER_PUBLISHED_TWEET, '=');
    $query->condition('p.size', 140, '>');
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

      $build['submit'] = array(
        '#prefix' => '<div id="delete-selected">',
        '#type' => 'submit',
        '#value' => t('Delete Selected'),
        '#suffix' => '</div>',
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
    $row->message = tweets_queue_decrypt_data($row->{TWITTER_FIELD_MESSAGE});
    $edit_url = Url::fromRoute(TWITTER_TWEET_FORM_ROUTE_NAME,
      ['nid' => $row->nid, 'action' => 'edit', TWITTER_REDIRECT_PATH => TWITTER_INVALID_TWEET_PATH],
      ['attributes' => ['class' => 'edit beautytips', 'title' => t(TWITTER_EDIT_TOOLTIP)]]
    );
    $delete_url = Url::fromRoute(TWITTER_TWEET_FORM_DELETE_ROUTE_NAME,
      ['nid' => $row->nid, 'action' => 'delete', TWITTER_REDIRECT_PATH => TWITTER_INVALID_TWEET_PATH],
      ['attributes' => ['class' => 'delete colorbox cboxElement beautytips', 'title' => t(TWITTER_DELETE_TOOLTIP)]]
    );
    $edit_url_link = \Drupal::l(t('Edit'), $edit_url);

    $delete_url_link = \Drupal::l(t('Delete'), $delete_url);
    $data = array();
    $data['multiple_delete'] = t('<span class="custom-checkbox"><input name="multiple-deletion" id="' . $row->nid . '" type="checkbox" value = "' . $row->nid .'"><label></label></span>');
    $data['delete_url_multiple_link'] = $delete_url_multiple_link ;
    $data['message'] = tweets_queue_perform_hashtag_highlight($row->{TWITTER_FIELD_MESSAGE});
    $data['size'] = $row->{TWITTER_FIELD_SIZE};
    $data['created'] = date(TWITTER_DATE_FORMAT, $row->{TWITTER_FIELD_CREATED});

    $changed = ($row->{TWITTER_FIELD_CHANGED}) ? date(TWITTER_DATE_FORMAT, $row->{TWITTER_FIELD_CHANGED}) : '-';
    $data['changed'] = $changed;
    // $data['changed'] = date(TWITTER_DATE_FORMAT, $row->{TWITTER_FIELD_CHANGED});
    $data['edit_link'] = $edit_url_link ;
    $data['delete_link'] = $delete_url_link ;
    return array('data' => $data);
  }
}
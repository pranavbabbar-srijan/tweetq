<?php
/**
 * @file
 * Contains \Drupal\tweets_queue\Plugin\Block\SignInWithTwitterBlock.
 */
namespace Drupal\tweets_queue\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;

/**
 * Provides a 'twitter' block.
 *
 * @Block(
 *   id = "import_csv_log_block",
 *   admin_label = @Translation("Import Csv log"),
 *   category = @Translation("Import Csv log")
 * )
 */
class ImportCsvBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    $import_csv_log = tweets_queue_fetch_import_csv_logs();

      $total_tweets_header = "<div class='totaltweetsheader'>Total Tweets</div>";
      $valid_tweets_header = "<div class='validtweetsheader'>Valid Tweets</div>";
      $invalid_tweets_header = "<div class='invalidtweetsheader'>Invalid Tweets</div>";
      $duplicate_tweets_header = "<div class='duplicatetweetsheader'>Duplicate Tweets</div>";
      $skipped_tweets_header = "<div class='skippedtweetsheader'>Skipped Tweets</div>";
      $created_tweets_header = "<div class='createdtweetsheader'>Updated On</div>";
      $div = "<div>";
      $output = "<div id='import-csv-log-header'>" . $total_tweets_header .
      $valid_tweets_header . $invalid_tweets_header . $duplicate_tweets_header .
      $skipped_tweets_header . $created_tweets_header . "</div>";

      foreach ($import_csv_log as $data) {
      $type = $data->type;
      $total_tweets = $data->total_tweets;
      $valid_tweets = $data->valid_tweets;
      $invalid_tweets = $data->invalid_tweets;
      $duplicate_tweets = $data->duplicate_tweets;
      $skipped_tweets = $data->skipped_tweets;
      $created = $data->created;
      $output .= t("<div class='import_log_items'>
        <span class='totaltweetsimportlogs'>@total_tweets</span>
        <span class='validtweetsimportlogs'>@valid_tweets</span>
        <span class='invalidtweetsimportlogs'>@invalid_tweets</span>
        <span class='duplicatetweetsimportlogs'>@duplicate_tweets</span>
        <span class='skippedtweetsimportlogs'>@skipped_tweets</span>
        <span class='createdimportlogs'>@created</span>
        </div>",
      array( 		
        '@total_tweets' => $total_tweets,
        '@valid_tweets' => $valid_tweets,
        '@invalid_tweets' => $invalid_tweets,
        '@duplicate_tweets' => $duplicate_tweets,
        '@skipped_tweets' => $skipped_tweets,
        '@created' => $createdimportlogs,
        )
      );

     }
   	 return array(
      '#type' => 'markup',
      '#markup' => $output,
     );
     $div = "</div>";
    // $build['archived_tweets'] = array(
    //     '#theme' => 'item_list',
    //     '#items' => $output,
    //   );
    //   $build['pager'] = array(
    //    '#type' => 'pager'
    //   );
    //   return $build;
   
  }
}
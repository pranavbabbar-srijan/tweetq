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
    echo "<pre>";
    print_r($import_csv_log);
  }
}
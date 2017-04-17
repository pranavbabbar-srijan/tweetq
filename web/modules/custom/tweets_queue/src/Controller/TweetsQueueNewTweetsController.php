<?php

namespace Drupal\tweets_queue\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * An example controller.
 */
class TweetsQueueNewTweetsController extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public function content() {
    $build = array(
      '#type' => 'markup',
      '#markup' => t(''),
    );
    return $build;
  }

}

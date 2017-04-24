<?php

/**
 * @file
 * Contains \Drupal\node\beautytips_manager\BeautytipsManagerController.
 */

namespace Drupal\beautytips_manager\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Component\Utility\Html;
use Drupal\Core\Url;

class BeautytipsManagerController extends ControllerBase {

  /**
   * Custom tips administration.
   */
  public function customTipsOverview() {
    $rows = array();
    $header = array(t('Element'), t('Style'), t('Status'), t('Visibility'), t('Pages'), t('operations') ,'');
    $tips = beautytips_manager_get_custom_tips();
    if (count($tips)) {
      $visibility = array(t('Show on every page except the listed pages.'), t('Show on only the listed pages.'));
      foreach ($tips as $tip) {
        $tip->pages = Html::escape($tip->pages);
        $pages = ($tip->pages != substr($tip->pages, 0, 40)) ? substr($tip->pages, 0, 40) . '...' : substr($tip->pages, 0, 40);
        $rows[$tip->id]['element'] = Html::escape($tip->element);
        $rows[$tip->id]['style'] = $tip->style;
        $rows[$tip->id]['enabled'] = $tip->enabled ? t('Enabled') : t('Disabled');
        $rows[$tip->id]['visibility'] = $visibility[$tip->visibility];
        $rows[$tip->id]['pages'] = $pages;
        $rows[$tip->id]['edit'] = \Drupal::l(t('edit'), Url::fromUserInput("/admin/config/user-interface/beautytips/custom-tips/$tip->id/edit"));
        $rows[$tip->id]['delete'] = \Drupal::l(t('delete'), Url::fromUserInput("/admin/config/user-interface/beautytips/custom-tips/$tip->id/delete"));
      }
    }
    else {
      return array(
        '#type' => 'markup',
        '#markup' => t('There are no custom beautytips yet.'),
      );
    }
    return array(
      '#theme' => 'table',
      '#header' => $header,
      '#rows' => $rows,
    );
  }

  /**
   * Custom styles administration.
   */
  public function customStylesOverview() {
    $options = $rows = array();
    $header = array(t('Name'), t('operations'), '');
    $styles = beautytips_manager_get_custom_styles();
    if (count($styles)) {
      foreach ($styles as $style) {
        $name = Html::escape($style->name);
        unset($style->name);
        $rows[$style->id]['name'] = new \Drupal\Component\Render\FormattableMarkup("<span class='bt-style-$name'>%name</span>", array('%name' => $name));
        // $rows[$style->id]['name'] = '<span class="bt-style-' . $name . '">' . $name . '</span>';
        $rows[$style->id]['edit'] = \Drupal::l(t('edit'), Url::fromUserInput("/admin/config/user-interface/beautytips/custom-styles/$style->id/edit"));
        if ($name != \Drupal::config('beautytips.basic')->get('beautytips_default_style')) {
          $rows[$style->id]['delete'] = \Drupal::l(t('delete'), Url::fromUserInput("/admin/config/user-interface/beautytips/custom-styles/$style->id/delete"));
        }
        else {
          $rows[$style->id]['delete'] = t('Default style');
        }

        $options[][$name] = array(
          'cssSelect' => 'td .bt-style-' . $name,
          'text' => t('<h2>Default Text</h2><p>Nam magna enim, accumsan eu, blandit sed, blandit a, eros.  Nam ante nulla, interdum vel, tristique ac, condimentum non, tellus.</p><p>Nulla facilisi. Nam magna enim, accumsan eu, blandit sed, blandit a, eros.</p>'),
          'trigger' => 'hover',
          'style' => $name,
          //'shrinkToFit' => TRUE,
        );
      }
    }
    else {
      return array(
        '#type' => 'markup',
        '#markup' => t('There are no custom beautytip styles yet.'),
      );
    }

    $table = array(
      '#theme' => 'table',
      '#header' => $header,
      '#rows' => $rows,
    );
    beautytips_add_beautytips($table, array($name => $options));
    return $table;
  }
}

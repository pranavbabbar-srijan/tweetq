<?php
/**
 * @file
 * Contains \Drupal\beautytips\Form\BeautytipsConfigForm.
 */
namespace Drupal\beautytips\Form;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Beautytips admin settings form
 */
class BeautytipsConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormID() {
    return 'beautytips_admin';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = \Drupal::config('beautytips.basic');

    $form['beautytips_always_add'] = array(
      '#title' => t('Add beautytips js to every page'),
      '#description' => t('This allows you to give the class \'beautytips\' to any element on a page and the title attribute will popup as a beautytip.<br /> i.e. <i> &lt;p class="beautytips" title="type the text you want beautytips to display here"&gt .....&lt/p&gt</i>'),
      '#type' => 'checkbox',
      '#default_value' => $config->get('beautytips_always_add'),
      '#weight' => -1,
    );
    $selectors = $config->get('beautytips_added_selectors_array');
    $form['beautytips_added_selectors_array'] = array(
      '#title' => t('Add beautytips to the following selectors'),
      '#description' => t("Separate selectors with a comma.  Beautytips will be added to each of these on every page.  The element's title attribute will be the text used. (OPTIONAL)"),
      '#type' => 'textfield',
      '#default_value' => is_array($selectors) ? implode(", ", $selectors) : '',
      '#weight' => -1,
    );
    $form['beautytips_ltr'] = array(
      '#title' => t('Support Left to Right display'),
      '#description' => t('Only check this if this is an ltr site.  This adds css to support it.'),
      '#type' => 'checkbox',
      '#default_value' => $config->get('beautytips_ltr'),
    );
    $form['beautytips_default_styles'] = array(
      '#type' => 'details',
      '#title' => 'Styling Options',
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
    );
    $styles = beautytips_get_styles(TRUE);
    $style_options = [];
    if (count($styles)) {
      unset($styles['default']);
      foreach ($styles as $name => $style) {
        $bt_style_options[$name]['cssSelect'] = '#edit-beautytips-default-style-' . str_replace('_', '-', $name);
        $bt_style_options[$name]['text'] = 'Aenean risus purus, pharetra in, blandit quis, gravida a, turpis.  Aenean risus purus, pharetra in, blandit quis, gravida a, turpis.  Aenean risus purus, pharetra in, blandit quis, gravida a, turpis.';
        $bt_style_options[$name]['width'] = isset($style['width']) ? $style['width'] : '300px';
        $bt_style_options[$name]['style'] = $name;
        $style_options[$name] = $name;
      }
    }
    $bt_style_options['default_hover'] = array(
      'cssSelect' => '#beautytips-site-wide-popup',
      'text' => 'Sed justo nibh, ultrices ut gravida et, laoreet et elit. Nullam consequat lacus et dui dignissim venenatis. Curabitur quis urna eget mi interdum viverra quis eu enim. Ut sit amet nunc augue. Morbi fermentum ultricies velit sed aliquam. Etiam dui tortor, auctor sed tempus ac, auctor sed sapien.',
      'positions' => array('right'),
    );
    // TODO: Determine what to do if default style has been removed.
    $form['beautytips_default_styles']['beautytips_default_style'] = array(
      '#type' => 'radios',
      '#title' => t('Choose a default style'),
      '#description' => t('Mouse over the radio buttons to see a preview.'),
      '#prefix' => '<div id="beauty-default-styles">',
      '#suffix' => '</div>',
      '#options' => $style_options,
      '#default_value' => $config->get('beautytips_default_style'),
    );
    $style_options = array(
      'fill' => t('background color (string - html color)'),
      'strokeWidth' => t('width of border (integer)'),
      'strokeStyle' => t('color of border (string - html color)'),
      'width' => t('width of popup (number in px)'),
      'padding' => t('space between content and border (number in px)'),
      'cornerRadius' => t('Controls roundness of corners (integer)'),
      'spikeGirth' => t('thickness of spike (integer)'),
      'spikeLength' => t('length of spike (integer)'),
      'shadowBlur' => t('Size of popup shadow (integer)'),
      'shadowColor' => t('Color of popup shadow (string - html color)'),
    );
    $form['beautytips_default_styles']['custom_styles'] = array(
      '#type' => 'details',
      '#title' => t('Custom Style Options'),
      '#description' => t('<b>Set a custom style.</b><br /> Note: These will use the default style that is selected as a base <br /> but will overide elements such as background color, border color etc.   <br /><i>Leave these empty unless you know what you are doing.</i><div id="beautytips-popup-changes"><div id="beauty-click-text"><p>Double Click here to view popup with custom changes</p></div></div>'),
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
      '#attributes' => array('class' => array('bt-custom-styles')),
      '#prefix' => '<div id="beautytips-site-wide-popup"><div id="beauty-text"><p>Hover here to see the current site-wide beautytips</p></div></div>',
    );
    $custom_style = $config->get('beautytips_custom_style');
    foreach ($style_options as $option => $description) {
      $form['beautytips_default_styles']['custom_styles']['bt-options-box-' . $option] = array(
        '#title' => $option,
        '#description' => $description,
        '#type' => 'textfield',
        '#default_value' => isset($custom_style[$option]) ? $custom_style[$option] : '',
      );
    }
    $form['beautytips_default_styles']['custom_styles']['bt-options-box-shadow'] = array(
      '#title' => 'shadow',
      '#description' => t('Whether or not the popup has a shadow'),
      '#type' => 'radios',
      '#options' => array('default' => t('Default'), 'shadow' => t('Shadow On'), 'no_shadow' => t('Shadow Off')),
      '#attributes' => array('class' => array('beautytips-options-shadow')),
      '#default_value' => isset($custom_style['shadow']) ? $custom_style['shadow'] : 'default',
    );
    $form['beautytips_default_styles']['custom_styles']['bt-options-cssClass'] = array(
      '#title' => 'cssClass',
      '#description' => t('The class that will be applied to the box wrapper div (of the TIP)'),
      '#type' => 'textfield',
      '#default_value' => isset($custom_style['cssClass']) ? $custom_style['cssClass'] : '',
    );
    $css_style_options = array('color', 'fontFamily', 'fontWeight', 'fontSize');
    $form['beautytips_default_styles']['custom_styles']['css-styles'] = array(
      '#type' => 'details',
      '#title' => t('Font Styling'),
      '#description' => t('Enter css options for changing the font style'),
      '#attributes' => array('class' => array('beautytips-css-styling')),
      '#collapsible' => FALSE,
    );
    foreach ($css_style_options as $option) {
      $form['beautytips_default_styles']['custom_styles']['css-styles']['bt-options-css-' . $option] = array(
        '#title' => $option,
        '#type' => 'textfield',
        '#default_value' => isset($custom_style['cssStyles'][$option]) ? $custom_style['cssStyles'][$option] : '',
      );
    }
    $form['#attached'] = [
      'library' => ['beautytips/beautytips.beautytips'],
    ];
    beautytips_add_beautytips($form, $bt_style_options);

    if (\Drupal::moduleHandler()->moduleExists('beautytips_ui')) {
      beautytips_ui_admin_settings($form);
    }

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $integer_fields = array('bt-options-box-strokeWidth', 'bt-options-box-cornerRadius', 'bt-options-box-spikeGirth', 'bt-options-box-spikeLength', 'bt-options-box-shadowBlur');
    $pixel_fields = array('bt-options-box-width', 'bt-options-box-padding', 'bt-options-css-fontSize');

    foreach ($integer_fields as $name) {
      if ($values[$name]) {
        if (!is_numeric($values[$name])) {
          $form_state->setErrorByName($name, t('You need to enter a numeric value for <em>@name</em>', array('@name' => str_replace(array('bt-options-box-', 'bt-options-css-'), '', $name))));
        }
        else {
          $form_state->setValue($name, round($values[$name]));
        }
      }
    }

    foreach ($pixel_fields as $name) {
      if ($values[$name]) {
        $unit = substr($values[$name], -2, 2);
        $value = str_replace(array('px', ' ', 'em'), '', $values[$name]);
        if (!is_numeric($value) || (!$value && $value != 0) || !in_array($unit, array('px', 'em'))) {
          $form_state->setErrorByName($name, t('You need to enter a numeric value for <em>@name</em>, followed by <em>px</em>', array('@name' => str_replace(array('bt-options-box-', 'bt-options-css-'), '', $name))));
        }
      }
    }
    parent::validateForm($form, $form_state);
  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = \Drupal::configFactory()->getEditable('beautytips.basic');
    $values = $form_state->getValues();
    if (count($values)) {
      $custom_style = array();
      $css_style = array();
      foreach ($values as $option => $value) {
        if (strpos($option, 'bt-options-box-') === 0) {
          $option = str_replace('bt-options-box-', '', $option);
          $custom_style[$option] = $value;
        }
        else if ($option == 'bt-options-cssClass') {
          $option = str_replace('bt-options-', '', $option);
          $custom_style[$option] = $value;
        }
        else if (strpos($option, 'bt-options-css-') === 0) {
          $option = str_replace('bt-options-css-', '', $option);
          if ($value) {
            $css_style[$option] = $value;
          }
        }
      }

      // Store the defaults - they will be passed to javascript
      $style = beautytips_get_style($values['beautytips_default_style']);
      if (count($custom_style)) {
        foreach ($custom_style as $option => $value) {
          if ($option == 'shadow') {
            if ($value != 'default') {
              $style['shadow'] = $value == 'shadow' ? TRUE : FALSE;
            }
          }
          else if (!empty($value) || $value == '0') {
            $style[$option] = is_numeric($value) ? (int) $value : (string) $value;
          }
        }
      }
      if (count($css_style)) {
        foreach ($css_style as $option => $value) {
          if (!empty($value)) {
            $style['cssStyles'][$option] = (string) $value;
          }
        }
        if (!empty($css_style)) {
          $custom_style['cssStyles'] = $css_style;
        }
      }
      $config->set('beautytips_defaults', $style);
      $config->set('beautytips_custom_style', $custom_style);
      $config->set('beautytips_default_style', $values['beautytips_default_style']);
      $config->set('beautytips_always_add', $values['beautytips_always_add']);
      $config->set('beautytips_ltr', $values['beautytips_ltr']);
      Cache::invalidateTags(['beautytips']);

      // Store array of selectors that bt will be added to on every page
      $selectors = explode(",", $values['beautytips_added_selectors_array']);
      if (count($selectors)) {
        foreach ($selectors as $key => $selector) {
          $selectors[$key] = trim($selector);
        }
      }
      $config->set('beautytips_added_selectors_array', $selectors);
    }
    if (\Drupal::moduleHandler()->moduleExists('beautytips_ui')) {
      beautytips_ui_admin_submit($form, $form_state);
    }
    $config->save();
    parent::submitForm($form, $form_state);
  }
}
?>

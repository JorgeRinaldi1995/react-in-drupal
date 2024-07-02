<?php

namespace Drupal\cart_module\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'add_to_cart_button' formatter.
 *
 * @FieldFormatter(
 *   id = "add_to_cart_button",
 *   label = @Translation("Add to Cart Button"),
 *   field_types = {
 *     "string"
 *   }
 * )
 */
class AddToCartButtonFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'button_text' => 'Add to Cart',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = [];

    $elements['button_text'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Button text'),
      '#default_value' => $this->getSetting('button_text'),
      '#required' => TRUE,
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];

    $summary[] = $this->t('Button text: @button_text', ['@button_text' => $this->getSetting('button_text')]);

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $elements[$delta] = [
        '#type' => 'markup',
        '#markup' => $this->buildAddToCartButton($item->getEntity()->id(), $this->getSetting('button_text')),
      ];
    }

    return $elements;
  }

  /**
   * Builds the "Add to Cart" button HTML.
   *
   * @param int $product_id
   *   The product node ID.
   * @param string $button_text
   *   The text to display on the button.
   *
   * @return string
   *   The HTML markup for the button.
   */
  protected function buildAddToCartButton($product_id, $button_text) {
    return '<a href="/cart/add/' . $product_id . '" class="button">' . $button_text . '</a>';
  }
}

<?php

namespace Drupal\cart_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;

class ProductQuantityForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'product_quantity_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, Node $node = null) {
    if ($node->bundle() != 'product') {
      return $form;
    }

    $form['quantity'] = [
      '#type' => 'number',
      '#title' => $this->t('Quantity'),
      '#default_value' => 1,
      '#min' => 1,
      '#ajax' => [
        'callback' => '::updatePrice',
        'wrapper' => 'price-wrapper',
      ],
    ];

    $price = $node->get('field_price')->value;
    $form['price'] = [
      '#type' => 'markup',
      '#markup' => '<div id="price-wrapper">' . $this->t('Total Price: @price', ['@price' => $price]) . '</div>',
    ];

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Add to cart'),
    ];

    return $form;
  }

  /**
   * Ajax callback to update the price based on quantity.
   */
  public function updatePrice(array &$form, FormStateInterface $form_state) {
    $quantity = $form_state->getValue('quantity');
    $price = $form['#node']->get('field_price')->value;
    $total_price = $quantity * $price;

    $form['price']['#markup'] = '<div id="price-wrapper">' . $this->t('Total Price: @price', ['@price' => $total_price]) . '</div>';

    return $form['price'];
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $quantity = $form_state->getValue('quantity');
    $node = $form['#node'];
    // Add the product to the cart with the specified quantity.
    // This part should interact with your CartService to add the product to the cart.
  }
}

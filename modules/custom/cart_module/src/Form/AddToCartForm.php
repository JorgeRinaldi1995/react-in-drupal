<?php

namespace Drupal\cart_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\cart_module\Service\CartService;

class AddToCartForm extends FormBase {
  
  protected $cartService;
  
  public function __construct(CartService $cartService) {
    $this->cartService = $cartService;
  }
  
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('cart_module.cart_service')
    );
  }
  
  public function getFormId() {
    return 'add_to_cart_form';
  }
  
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['quantity'] = [
      '#type' => 'number',
      '#title' => $this->t('Quantity'),
      '#default_value' => 1,
      '#min' => 1,
    ];
    
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Add to cart'),
    ];
    
    return $form;
  }
  
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $quantity = $form_state->getValue('quantity');
    $this->cartService->addToCart($quantity);
    $this->messenger()->addMessage($this->t('Product added to cart'));
  }
}

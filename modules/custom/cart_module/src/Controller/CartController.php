<?php

namespace Drupal\cart_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Drupal\cart_module\Service\CartService;

class CartController extends ControllerBase {
  
  protected $cartService;
  
  public function __construct(CartService $cartService) {
    $this->cartService = $cartService;
  }
  
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('cart_module.cart_service')
    );
  }
  
  public function addToCart($product_id) {
    $this->cartService->addToCart($product_id, 1); // Default to adding 1 quantity
    $this->messenger()->addMessage($this->t('Product added to cart.'));
    return $this->redirect('<front>');
  }

  public function viewCart() {
    $items = $this->cartService->getCartItems();
    return [
      '#theme' => 'cart_page',
      '#items' => $items,
    ];
  }
}

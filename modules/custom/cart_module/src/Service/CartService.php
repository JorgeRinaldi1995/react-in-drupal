<?php

namespace Drupal\cart_module\Service;

use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService {
  
  protected $currentUser;
  protected $session;
  
  public function __construct(AccountProxyInterface $current_user, SessionInterface $session) {
    $this->currentUser = $current_user;
    $this->session = $session;
  }
  
  public function addToCart($product_id, $quantity) {
    $cart = $this->session->get('cart', []);
    $cart[] = ['product_id' => $product_id, 'quantity' => $quantity];
    $this->session->set('cart', $cart);
  }
  
  public function getCartItems() {
    return $this->session->get('cart', []);
  }
}

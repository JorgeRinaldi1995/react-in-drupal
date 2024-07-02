<?php

namespace Drupal\react_theme_module\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'React' Block.
 *
 * @Block(
 *   id = "react_block",
 *   admin_label = @Translation("React block"),
 *   category = @Translation("Custom")
 * )
 */
class ReactBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#markup' => '<div id="react-app"></div>',
      '#attached' => [
        'library' => [
          'custom_theme/global-styling',
        ],
      ],
    ];
  }
}

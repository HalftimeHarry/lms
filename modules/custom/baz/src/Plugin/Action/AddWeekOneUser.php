<?php

namespace Drupal\baz\Plugin\Action;

use Drupal\Core\Plugin;
use Drupal\Core\Action\ActionBase;

/**
 * Makes a user example.
 *
 * @Action(
 *   id = "baz_action",
 *   label = @Translation("Make selected content example"),
 *   type = "user"
 * )
 */
class AddWeekOneUser extends ActionBase {

  /**
   * {@inheritdoc}
   */
  public function access($entity = NULL) {
   /* example stuff */
    $entity->save();
  }

}
<?php
namespace Drupal\rsvplist\Plugin\Block;

use Drupal\Console\Bootstrap\Drupal;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\Annotation\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\KernelTests\Core\Database\NextIdTest;
use Drupal\node\Entity\Node;
use Drupal\rsvplist\Form\RSVPForm;

/**
 * @Block(
 *  id="rsviplist_bloc",
 *  admin_label=@Translation ("RVP Form Block")
 *)
 */
class RSVPBlock extends BlockBase
{
  /**
   * {@inheritDoc}
   */
  public function build():array
  {
     return \Drupal::formBuilder()->getForm('Drupal\rsvplist\Form\RSVPForm');
  }

  public function blockAccess(AccountInterface $account)
  {
    /**@var Node $node */
    $node = \Drupal::routeMatch()->getParameter('node');

    if ($node && is_numeric($node->id()) && \Drupal::service('rsvplist.enabler')->isEnabled($node->id())) {
      return AccessResult::allowedIfHasPermission($account, 'rsvplist view form');
    }
    return AccessResult::forbidden();
  }
}

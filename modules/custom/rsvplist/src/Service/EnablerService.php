<?php
/**
 * @file
 * Contains Drupal\rsvplist\Service\EnablerService
 */
namespace Drupal\rsvplist\Service;
use Drupal\Core\Database\Connection;

/**
 * Defines a service for managing RSVP list enabler for nodes
 */
class EnablerService
{
  private Connection $connexion;

  /**
   *
   */
  public function __construct(\Drupal\Core\Database\Connection $connection)
  {
    $this->connexion = $connection;
  }

  function isEnabled($nid): bool
  {
    $query = $this->connexion->select('rsvplist_enabled', 'r')
      ->fields('r', ['nid'])->condition('nid', $nid);
    $t = $query->execute()->fetch();
    return (bool) $t;
  }

  function Enable($nid){
    $query = $this->connexion->insert('rsvplist_enabled');
    $query->fields(['nid' => $nid])->execute();
  }

  function  disable($nid){
    $query = $this->connexion->delete('rsvplist_enabled');
    $query->condition('nid', $nid)->execute();
  }
}

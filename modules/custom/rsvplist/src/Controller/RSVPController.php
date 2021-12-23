<?php
namespace Drupal\rsvplist\Controller;

use Drupal\Core\Controller\ControllerBase;

class RSVPController extends ControllerBase
{
  public function report():array{

$entries = $this->load();

    $content ['message']=[
      '#markup' => $this->t('Below is a list of all Event RSVPs including name, email and the title of Event they will be attending.')
    ];
    $content['list'] = [
      '#type' => 'table',
      '#header' => [t('Event'), t('name'), t('Email')],
      '#empty' => t('No entry available')
    ];
    foreach ($entries as $entry){
      $row = [
        ['#markup' => $entry->title, '#title_display' => 'invisible'],
        ['#markup' => $entry->name, '#title_display' => 'invisible'],
        ['#markup' => $entry->email, '#title_display' => 'invisible'],
      ];
      $content['list'][] = $row;
    }



    return $content;
  }

  private function load(){
    $query = \Drupal::database()->select('rsvplist', 'r');
    $query->innerJoin('users_field_data', 'u', 'r.uid = u.uid' );
    $query->innerJoin('node_field_data', 'n', 'n.nid = r.nid');
      $query->fields('u', ['name'])
      ->fields('n', ['title'])
      ->fields('r', ['email']);
    return $query->execute()->fetchAll();
  }
}

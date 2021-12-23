<?php

namespace Drupal\rsvplist\Form;

use Drupal\Console\Bootstrap\Drupal;
use Drupal\contact\Entity\Message;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\user\Entity\User;

class RSVPForm extends FormBase
{
  /**
   * @inheritDoc
   * @return string
   */
  public function getFormId(): string
  {
    return 'rsvplist_email_form';
  }
  /**
   * @inerhitDoc
   */
  public function buildForm(array $form, FormStateInterface $form_state): array
  {
    $node = \Drupal::routeMatch()->getParameter('node');

    $form['email'] = [
      '#type' =>'textfield',
      '#title' => t('Email'),
      '#description' => t('W\'ll send update to the mail address your provide.'),
      '#required' => true,
    ];
    $form['nid'] = [
      '#type' => 'hidden',
      '#value' => $node? $node->id(): ''
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Send'
    ];
    return  $form;
  }

  /**
   * @param array $form
   * @param FormStateInterface $form_state
   */
  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    $value = $form_state->getValue('email');

    if(!\Drupal::service('email.validator')->isValid($value)){
      $form_state->setErrorByName('email', t('The email address %email is not valid.', ['%email' => $value]));

    }
  }

  /**
   * @inerhitDoc
   * @throws \Exception
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $fields = array(
      'uid' => \Drupal::currentUser()->id(),
      'nid' => $form_state->getValue('nid'),
      'email' => $form_state->getValue('email'),
      'created' => time()
    );
    \Drupal::database()
      ->insert('rsvplist')
      ->fields($fields)
      ->execute();

    \Drupal::messenger()->addMessage('Thank for your RSVP, you are on the list of event.', \Drupal\Core\Messenger\Messenger::TYPE_STATUS);


  }
}

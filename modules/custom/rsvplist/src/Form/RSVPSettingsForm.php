<?php

namespace Drupal\rsvplist\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class RSVPSettingsForm extends ConfigFormBase
{
  const CONFIG_NAME = 'rsvplist_admin.settings';

  /**
   * {@inheritDoc}
   */
  protected function getEditableConfigNames():array {
    return [
      self::CONFIG_NAME
    ];
  }

  /**
   * {@inheritDoc}
   */
  public function getFormId(): string
  {
    return 'rsvplist_admin';
  }

  /**
   * {@inheritDoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state):array
  {
    $config = $this->config(self::CONFIG_NAME);

    $form['content_types'] = [
      '#type' => 'checkboxes',
      '#title' => t('The content types to enable RSVP for'),
      '#description' => 'On the specified node types, an RSVP option will be avaible and can be enabled while the node is being edited.',
      '#options' => node_type_get_names(),
      '#default_value' => $config->get('content_types', []),
    ];

    return parent::buildForm($form, $form_state); // TODO: Change the autogenerated stub
  }

  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $config = $this->config(self::CONFIG_NAME);
    $config->set('content_types', $form_state->getValue('content_types'));
    $config->save();
    parent::submitForm($form, $form_state); // TODO: Change the autogenerated stub
  }

}

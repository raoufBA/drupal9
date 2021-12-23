<?php

namespace Drupal\my_module\Controller;

use Drupal\Core\Controller\ControllerBase;

class MyModuleController extends  ControllerBase
{
  function content()
  {
    return [
      '#type' => 'markup',
      '#markup' => 'My first page and content item'
    ];
  }
}

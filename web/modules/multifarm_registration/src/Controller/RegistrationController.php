<?php

namespace Drupal\multifarm_registration\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends ControllerBase {
    public function register() {
        $form = \Drupal::formBuilder()->getForm('Drupal\multifarm_registration\Form\RegistrationForm');
        return $form;
      }
}



<?php

namespace Drupal\multifarm_registration\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class RegistrationForm extends FormBase {

  public function getFormId() {
    return 'multifarm_registration_registration_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['username'] = [
      '#type' => 'textfield',
      '#title' => $this->t('username'),
      '#size' => 60,
      '#maxlength' => 128,
      '#required' => TRUE,
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#required' => true,
    ];

    $form['password'] = [
      '#type' => 'password',
      '#title' => $this->t('password'),
      '#size' => 60,
      '#maxlength' => 128,
      '#required' => TRUE,
    ];

    $form['name'] = [
    '#type' => 'textfield',
    '#title' => $this->t('Name'),
    '#size' => 60,
    '#maxlength' => 128,
    '#required' => TRUE,
    ];

    $form['description'] = [
    '#type' => 'textarea',
    '#title' => $this->t('Description'),
    '#rows' => 5,
    ];

    $form['submit'] = [
    '#type' => 'submit',
    '#value' => $this->t('Save'),
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    
    $taxonomy_term = \Drupal\taxonomy\Entity\Term::create([
    'vid' => 'farm',
    'name' => $values['name'],
    'description' => $values['description'],
    ]);
    $taxonomy_term->save();

    $term_id = $taxonomy_term->id();

    $user = \Drupal\user\Entity\User::create();
    $user->setUsername($values['username']);
    $user->setEmail($values['email']);
    $user->setPassword($values['password']);
    $user->set('farm', $term_id);
    $user->enforceIsNew();
    $user->activate();
    $user->addRole('farm_manager');
    $user->save();
    
  }

}


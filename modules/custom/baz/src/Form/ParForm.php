<?php

namespace Drupal\baz\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\Query\QueryFactory;
use Drupal\baz\Form\FieldItemBase;

/**
 * Class ParForm.
 *
 * @package Drupal\baz\Form
 */
class ParForm extends FormBase {

   /**
   * Drupal\Core\Entity\Query\QueryFactory definition.
   *
   * @var Drupal\Core\Entity\Query\QueryFactory
   */
  protected $entity_query;
  
   
  public function __construct(QueryFactory $entity_query) {
    $this->entity_query = $entity_query;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity.query')
    );
  }
  
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'baz_form';
  }
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

  $form['team_name'] = [
        '#type' => 'select',
        '#title' => $this->t('Select Team or Reset Weeks'),
        '#options' => [
                    'ARI' => $this->t('ARI'),
                    'ATL' => $this->t('ATL'),
                    'BAL' => $this->t('BAL'),
                    'BUF' => $this->t('BUF'),
                    'CAR' => $this->t('CAR'),
                    'CHI' => $this->t('CHI'),
                    'CIN' => $this->t('CIN'),
                    'CLE' => $this->t('CLE'),
                    'DAL' => $this->t('DAL'),
                    'DEN' => $this->t('DEN'),
                    'DET' => $this->t('DET'),
                    'GNB' => $this->t('GNB'),
                    'HOU' => $this->t('HOU'),
                    'IND' => $this->t('IND'),
                    'JAX' => $this->t('JAX'),
                    'KAN' => $this->t('KAN'),
                    'LAC' => $this->t('LAC'),
                    'LAR' => $this->t('LAR'),
                    'MIA' => $this->t('MIA'),
                    'MIN' => $this->t('MIN'),
                    'NWE' => $this->t('NWE'),
                    'NOR' => $this->t('NOR'),
                    'NYG' => $this->t('NYG'),
                    'NYJ' => $this->t('NYJ'),
                    'OAK' => $this->t('OAK'),
                    'PHI' => $this->t('PHI'),
                    'PIT' => $this->t('PIT'),
                    'SFO' => $this->t('SFO'),
                    'TAM' => $this->t('TAM'),
                    'TEN' => $this->t('TEN'),
                    'WAS' => $this->t('WAS'),
                    'Week 1' => $this->t('Week 1'),
                    'Week 2' => $this->t('Week 2'),
                    'Week 3' => $this->t('Week 3'),
                    'Week 4' => $this->t('Week 4'),
                    'Week 5' => $this->t('Week 5'),
                    'Week 6' => $this->t('Week 6'),
                    'Week 7' => $this->t('Week 7'),
                    'Week 8' => $this->t('Week 8'),
                    'Week 9' => $this->t('Week 9'),
                    'Week 10' => $this->t('Week 10'),
                    'Week 11' => $this->t('Week 11'),
                    'Week 12' => $this->t('Week 12'),
                    'Week 13' => $this->t('Week 13'),
                    'Week 14' => $this->t('Week 14'),
                    'Week 15' => $this->t('Week 15'),
                    'Week 16' => $this->t('Week 16'),
                    'Week 17' => $this->t('Week 17'),
                    'Wildcard' => $this->t('Wildcard'),
                    'Divisional' => $this->t('Divisional'),
                    'Confrance' => $this->t('Confrance'),
                    'Superbowl' => $this->t('Superbowl'),
               ],
 ];
 
   $form['week'] = [
        '#type' => 'select',
        '#title' => $this->t('Select a Week'),
        '#options' => [
                    'week_0' => $this->t('Select a Week'),
                    'week_1' => $this->t('Week 1'),
                    'week_2' => $this->t('Week 2'),
                    'week_3' => $this->t('Week 3'),
                    'week_4' => $this->t('Week 4'),
                    'week_5' => $this->t('Week 5'),
                    'week_6' => $this->t('Week 6'),
                    'week_7' => $this->t('Week 7'),
                    'week_8' => $this->t('Week 8'),
                    'week_9' => $this->t('Week 9'),
                    'week_10' => $this->t('Week 10'),
                    'week_11' => $this->t('Week 11'),
                    'week_12' => $this->t('Week 12'),
                    'week_13' => $this->t('Week 13'),
                    'week_14' => $this->t('Week 14'),
                    'week_15' => $this->t('Week 15'),
                    'week_16' => $this->t('Week 16'),
                    'week_17' => $this->t('Week 17'),
                    'wild' => $this->t('Wildcard'),
                    'div' => $this->t('Divisional'),
                    'con' => $this->t('Confrance'),
                    'sb' => $this->t('Superbowl'),
               ],
 ];
        
  $query = $this->entity_query->get('user');
        $uid = $query->execute();
        $users = user_load_multiple(array_keys($uid['user']));
        $options = [];
        foreach ($users as $user) {
          $nmid = $user->uid->value;
          $nm = $user->name->value;
          $nm11 = $user->get('field_week_11')->value;
          $nm12 = $user->get('field_week_12')->value;
          
       $options[$nmid] = ['par_name' => $nm, 'wk_11' => $nm11, 'wk_12' => $nm12];
       
 }
        
 $header = [
    'par_name' => $this->t('Participant'),
    'wk_11' => $this->t('Week 11'),
    'wk_12' => $this->t('Week 12')
  ];

       
  $form['table'] = array(
    '#type' => 'tableselect',
    '#header' => $header,
    '#options' => $options,
    '#multiple' => TRUE,
    '#empty' => $this->t('No users found'),
  );

     $form['actions'] = array('#type' => 'actions');
     $form['actions']['submit'] = array(
           '#type' => 'submit',
           '#value' => t('Save changes'),
  );
        return $form;
  }
    
    public function validateForm(array &$form, FormStateInterface $form_state) {
    // Validate submitted form data.
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $sel = $form_state->getValue('table');
    $tm = $form_state->getValue('team_name');
    $wk = $form_state->getValue('week');
    //these are only the users selected    
    $selected = array_filter($sel);
       foreach ($selected as $value) {
        if ($wk==='week_1') {
         $user = \Drupal\user\Entity\User::load($value);
         $user->set("field_week_1", $tm);
         $user->save();
        } 
        if ($wk==='week_2') {
         $user = \Drupal\user\Entity\User::load($value);
         $user->set("field_week_2", $tm);
         $user->save();
        } 
        if ($wk==='week_3') {
         $user = \Drupal\user\Entity\User::load($value);
         $user->set("field_week_3", $tm);
         $user->save();
        } 
        if ($wk==='week_4') {
         $user = \Drupal\user\Entity\User::load($value);
         $user->set("field_week_4", $tm);
         $user->save();
        } 
        if ($wk==='week_5') {
         $user = \Drupal\user\Entity\User::load($value);
         $user->set("field_week_5", $tm);
         $user->save();
        } 
        if ($wk==='week_6') {
         $user = \Drupal\user\Entity\User::load($value);
         $user->set("field_week_6", $tm);
         $user->save();
        } 
        if ($wk==='week_7') {
         $user = \Drupal\user\Entity\User::load($value);
         $user->set("field_week_7", $tm);
         $user->save();
        } 
        if ($wk==='week_8') {
         $user = \Drupal\user\Entity\User::load($value);
         $user->set("field_week_8", $tm);
         $user->save();
        } 
        if ($wk==='week_9') {
         $user = \Drupal\user\Entity\User::load($value);
         $user->set("field_week_9", $tm);
         $user->save();
        } 
        if ($wk==='week_10') {
         $user = \Drupal\user\Entity\User::load($value);
         $user->set("field_week_10", $tm);
         $user->save();
        } 
        if ($wk==='week_11') {
         $user = \Drupal\user\Entity\User::load($value);
         $user->set("field_week_11", $tm);
         $user->save();
        } 
        if ($wk==='week_12') {
         $user = \Drupal\user\Entity\User::load($value);
         $user->set("field_week_12", $tm);
         $user->save();
        } 
        if ($wk==='week_13') {
         $user = \Drupal\user\Entity\User::load($value);
         $user->set("field_week_13", $tm);
         $user->save();
        } 
        if ($wk==='week_14') {
         $user = \Drupal\user\Entity\User::load($value);
         $user->set("field_week_14", $tm);
         $user->save();
        } 
        if ($wk==='week_15') {
         $user = \Drupal\user\Entity\User::load($value);
         $user->set("field_week_15", $tm);
         $user->save();
        } 
        if ($wk==='week_16') {
         $user = \Drupal\user\Entity\User::load($value);
         $user->set("field_week_16", $tm);
         $user->save();
        } 
        if ($wk==='week_17') {
         $user = \Drupal\user\Entity\User::load($value);
         $user->set("field_week_17", $tm);
         $user->save();
        } 
        if ($wk==='wild') {
         $user = \Drupal\user\Entity\User::load($value);
         $user->set("field_wildcard", $tm);
         $user->save();
        } 
        if ($wk==='div') {
         $user = \Drupal\user\Entity\User::load($value);
         $user->set("field_divisional", $tm);
         $user->save();
        } 
        if ($wk==='con') {
         $user = \Drupal\user\Entity\User::load($value);
         $user->set("field_confrance", $tm);
         $user->save();
        } 
        if ($wk==='sb') {
         $user = \Drupal\user\Entity\User::load($value);
         $user->set("field_superbowl", $tm);
         $user->save();
        } 
        else  {
         drupal_set_message('You must select a week');
        } 

  }
 }
}


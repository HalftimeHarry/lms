<?php

namespace Drupal\pla\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\pla\TeamListService;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Entity\Query\QueryFactory;
use Drupal\Core\Session\AccountInterface;

/**
 * Class MasterForm.
 *
 * @package Drupal\pla\Form
 */
class MasterForm extends FormBase {
    /**
   *
   * @var Drupal\Core\Session\AccountInterface
   */
  protected $current_user;

  /**
   * Drupal\pla\TeamListService definition.
   *
   * @var \Drupal\pla\TeamListService
   */
  protected $pla_teamlist;
  /**
   * Drupal\Core\Entity\EntityTypeManager definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entity_type_manager;
  /**
   * Drupal\Core\Entity\Query\QueryFactory definition.
   *
   * @var \Drupal\Core\Entity\Query\QueryFactory
   */
  protected $entity_query;
  public function __construct(AccountInterface $current_user, TeamListService $pla_teamlist, EntityTypeManager $entity_type_manager, QueryFactory $entity_query) {
    $this-> current_user = $current_user;
    $this-> pla_teamlist = $pla_teamlist;
    $this-> entity_type_manager = $entity_type_manager;
    $this-> entity_query = $entity_query;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('current_user'),
      $container->get('pla.teamlist'),
      $container->get('entity_type.manager'),
      $container->get('entity.query')
    );
  }


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'master_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
     
   $teamlist = $this->pla_teamlist->getTeams();
              
    $unm = $this->current_user->getDisplayName();
    $query = $this->entity_query->get('node')
        ->condition('status', 1)
        ->condition('title', $unm, 'CONTAINS')
        ->condition('type', 'lives');
        $nids = $query->execute();
        $nodes = node_load_multiple($nids);
        dpm($nids);
        
     $op = [];
        foreach ($nodes as $life) {
          $nid = $life->nid->value;
          $nm = $life->title->value;
       $op[$nid] = ['life_name' => $nm];
 }
 
         
 $header = [
    'life_name' => $this->t('Choose Life')
  ];
 
     $form['selected_life'] = [
    '#type' => 'tableselect',
    '#header' => $header,
    '#options' => $op,
    '#multiple' => FALSE,
    '#empty' => $this->t('No users found'),
   ];
  
    $form['selected_team'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Choose a team'),
      '#header' => $header,
      '#options' => $teamlist,
      '#multiple' => TRUE,
      '#empty' => $this->t('No users found'),
    ];

    $form['submit'] = [
        '#type' => 'submit',
        '#value' => t('Submit'),
    ];

    return $form;
  }

  /**
    * {@inheritdoc}
    */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Display result.
    foreach ($form_state->getValues() as $key => $value) {
        drupal_set_message($key . ': ' . $value);
    }

  }

}

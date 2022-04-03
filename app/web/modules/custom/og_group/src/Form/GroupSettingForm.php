<?php
namespace Drupal\og_group\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\EntityFieldManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class GroupSettingForm extends FormBase {

  protected $entity_type_manager;
  protected $entityFieldManager;

  public function __construct(EntityTypeManagerInterface $entity_type_manager, EntityFieldManager $entityFieldManager) {
    $this->entity_type_manager = $entity_type_manager;
    $this->entityFieldManager = $entityFieldManager;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager'),
      $container->get('entity_field.manager')
    );
  }


  public function getFormId() {
    return 'og_group_add';
  }

  public function buildForm(array $form, FormStateInterface $form_state){

    // $og_group = $this->entity_type_manager->getStorage('og_group');

    $og_group = $this->entity_type_manager->getStorage('node_type')->load('og_group');

    $fields = $this->entityFieldManager->getFieldDefinitions('node', 'og_group');

    $query = \Drupal::entityQuery('taxonomy_term');
    $query->condition('vid', "payment_type");
    $tids = $query->execute();
    // print_r($tids);

    $payment_type = $this->entity_type_manager->getStorage('taxonomy_term')->loadMultiple($tids);
    // print_r($payment_type);
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
    ];
    return $form;

  }

  public function submitForm(&$form, FormStateInterface $form_state){

  }

}
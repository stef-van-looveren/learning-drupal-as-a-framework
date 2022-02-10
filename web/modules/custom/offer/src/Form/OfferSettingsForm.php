<?php
/**
 * @file
 * Contains \Drupal\offer\Form\OfferSettingsForm.
 */

namespace Drupal\offer\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class OfferSettingsForm.
 *
 * @package Drupal\offer\Form
 *
 * @ingroup offer
 */
class OfferSettingsForm extends FormBase {
  /**
   * Returns a unique string identifying the form.
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'offer_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Empty implementation of the abstract submit class.
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['offer_settings']['#markup'] = 'Settings form for offer. We don\'t need additional entity settings. Manage field settings with the tabs above.';
    return $form;
  }

}

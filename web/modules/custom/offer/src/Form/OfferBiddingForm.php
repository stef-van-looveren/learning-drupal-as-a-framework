<?php
namespace Drupal\offer\Form;

use Drupal\bid\Entity\Bid;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\offer\Entity\Offer;

class OfferBiddingForm extends FormBase {

  /**
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'offer_bid_form';
  }

  /**
   * Form constructor.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   * @param \Drupal\offer\Entity\Offer $offer
   *   The offer entity we're viewing
   *
   * @return array
   *   The form structure.
   */
  public function buildForm(array $form, FormStateInterface $form_state, $offer = NULL) {

    $form['#cache'] = ['max-age' => 0];

    switch($offer->get('field_offer_type')->getString()) {
      case 'with_minimum':
        $price = $offer->get('field_price')->getString();
        break;
      case 'no_minimum':
        $price = '0';
        break;
    }

    $form['offer_id'] = [
      '#type' => 'hidden',
      '#value' => $offer->id(),
      '#access' => FALSE
    ];

    $OfferHasBid = $offer->getOfferHighestBid();
    if($OfferHasBid) {
      $price = $OfferHasBid + 1;
    }

    $form['price'] = [
      '#markup' => '<h2>' . $this->t('Start bidding at @price$', ['@price' => $price])
    ];

    $form['bid'] = [
      '#type' => 'textfield',
      '#attributes' => array(
        ' type' => 'number', // this validates it as a number in front-end
        ' min' => $price
      ),
      '#title' => $this->t('Your bid'),
      '#description' => $this->t('Prices in $.'),
      '#required' => TRUE,
    ];

    // Group submit handlers in an actions element with a key of "actions".
    $form['actions'] = [
      '#type' => 'actions',
    ];

    $currentUserHasBid = $offer->CurrentUserHasBids();
    $callToAction = $currentUserHasBid ? $this->t('Raise my bid') : $this->t('Submit');

    // Add a submit button that handles the submission of the form.
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $callToAction,
    ];

    return $form;

  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);

    // Load the offer and make sure no higher bids were done
    // in the meantime!
    $offer_id = $form_state->getValue('offer_id');
    $offer = Offer::load($offer_id);
    $OfferHasBid = $offer->getOfferHighestBid();
    switch($offer->get('field_offer_type')->getString()) {
      case 'with_minimum':
        $minium_price = isset($OfferHasBid) ? $OfferHasBid : $offer->get('field_price')->getString();
        break;
      case 'no_minimum';
        $minium_price = isset($OfferHasBid) ? $OfferHasBid : 0;
        break;
    }
    if($minium_price >= $form_state->getValue('bid')) {
      $form_state->setErrorByName('bid', t('Minimum bid needs to be @price', ['@price' => (@$minium_price + 1) . '$' ]));;
    }

    // Server side validation for numeric field
    if (!is_numeric($form_state->getValue('bid'))) {
      $form_state->setErrorByName('bid', t('Bid input needs to be numeric!'));
    }
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Save as new revision of existing bid if user already has bids
    // Save as new bid if not
    $offer = Offer::load($form_state->getValue('offer_id'));
    if($offer->CurrentUserHasBids()) {
      $bid = $offer->currentUserBid();
      $bid->set('bid', $form_state->getValue('bid'));
      $bid->set('offer_id', ['target_id' => $form_state->getValue('offer_id')]);
      $bid->set('user_id', ['target_id' => \Drupal::currentUser()->id()]);
      $bid->setNewRevision(TRUE);
      $bid->setRevisionLogMessage('Bid raised for offer ' . $form_state->getValue('offer_id'));
      $bid->setRevisionCreationTime(\Drupal::time()->getRequestTime());
      $bid->setRevisionUserId(\Drupal::currentUser()->id());
    } else {
      $bid = Bid::create([
        'bid' => $form_state->getValue('bid'),
        'user_id' => ['target_id' => \Drupal::currentUser()->id()],
        'offer_id' => $form_state->getValue('offer_id')
      ]);
    }
    $violations = $bid->validate();
    $validation = $violations->count();
    if($validation === 0) {
      $bid->save();
      Cache::invalidateTags($offer->getCacheTags());
      \Drupal::messenger()->addMessage($this->t('Your bid was successfully submitted'));
    } else {
      \Drupal::messenger()->addWarning($violations[0]->getMessage());
    }

  }
}

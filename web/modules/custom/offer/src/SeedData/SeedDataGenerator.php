<?php

namespace Drupal\offer\SeedData;

use Drupal\user\Entity\User;
use Drupal\offer\Entity\Offer;
use Drupal\bid\Entity\Bid;
use Drupal\media\Entity\Media;
use Drupal\Core\Cache\Cache;
use Drush\Drush;

/**
 * Class SeedGenerator
 * @package Drupal\offer
 */
Class SeedDataGenerator {

  /**
   * Function to create the Seed data
   * @param string $entity
   *  The type of entity that needs to be created.
   * @return integer $count
   *  The number of entities created.
   */
  public function Generate($entity) {

    $count = 0;

    $directory = 'public://user';

    switch ($entity) {

      case 'user':
        // USER SEEDS

        // test user 1
        $user = User::create();
        $user->setUsername('test');
        $user->setPassword('test');
        $user->setEmail('test@mail.com');
        $user->activate();
        $user->enforceIsNew();
        if($user->save()) {
          $count += 1;
        }
        Drush::output()->writeln('<comment>Creating user test</comment>' );
        // dummy user 1
        $profilepic = 'https://stefvanlooveren.me/seeds/0_nnYie3yap6MX3Ods.jpg';
        $file = system_retrieve_file($profilepic, $directory . rand() . '.jpg', true);

        $user = User::create();
        $user->setUsername('Amber Knight');
        $user->setPassword('test');
        $user->setEmail('test2@mail.com');
        $user->set('field_profile_image', ['target_id' => $file->id()]);
        $user->activate();
        $user->enforceIsNew();
        if($user->save()) {
          $count += 1;
        }
        Drush::output()->writeln('<comment>Creating user Amber</comment>' );
        // dummy user 2
        $profilepic = 'https://stefvanlooveren.me/seeds/205e460b479e2e5b48aec07710c08d50.png';
        $file = system_retrieve_file($profilepic, $directory . rand() . '.jpg', true);
        $user = User::create();
        $user->setUsername('Eric Wang');
        $user->setPassword('test');
        $user->setEmail('test3@mail.com');
        $user->set('field_profile_image', ['target_id' => $file->id()]);
        $user->activate();
        $user->enforceIsNew();
        if($user->save()) {
          $count += 1;
        }
        Drush::output()->writeln('<comment>Creating user Eric</comment>' );
        // dummy user 3
        $profilepic = 'https://stefvanlooveren.me/seeds/profile-photos-2.jpg';
        $file = system_retrieve_file($profilepic, $directory . rand() . '.jpg', true);

        $user = User::create();
        $user->setUsername('Kim Barkeley');
        $user->setPassword('test');
        $user->setEmail('test4@mail.com');
        $user->set('field_profile_image', ['target_id' => $file->id()]);
        $user->activate();
        $user->enforceIsNew();
        if($user->save()) {
          $count += 1;
        }
        Drush::output()->writeln('<comment>Creating dummy user Kim</comment>' );

        return $count;
        break;
      case 'offer':
        $offers = $this->getOfferList();
        foreach($offers as $offerListItem) {
          $offer = Offer::create();
          $offer->set('title', $offerListItem['title']);
          $offer->set('field_description', ['value' => $offerListItem['field_description'], 'format' => 'html']);
          $offer->set('field_offer_type', $offerListItem['field_offer_type']);
          $offer->set('field_price', $offerListItem['field_price']);
          $directory = 'public://';
          $url = $offerListItem['field_image'];
          $file = system_retrieve_file($url, $directory . rand() . '.jpg', true);
          $drupalMedia = Media::create([
            'bundle' => 'image',
            'uid' => '0',
            'field_media_image' => [
              'target_id' => $file->id(),
            ],
          ]);
          $drupalMedia->setPublished(TRUE)
            ->save();
          $offer->set('field_image', ['target_id' => $drupalMedia->id()]);
          $user = user_load_by_name($offerListItem['username']);
          $uid = $user->id();
          $offer->set('user_id', $uid);
          $offer->set('moderation_state', $offerListItem['moderation_state']);
          if($offer->save()) {
            $count += 1;
          }
          Drush::output()->writeln('<comment>Creating offer '. $offerListItem['title'] .'</comment>' );
        }
        return $count;
        break;
      case 'bid':
        $bids = $this->getBidList();
        foreach($bids as $bidListItem) {
          $bid = Bid::create();
          $bid->set('user_id', $bidListItem['user_id']);
          $bid->set('offer_id', $bidListItem['offer_id']);
          $bid->set('bid', $bidListItem['bid']);
          if($bid->save()) {
            $count += 1;
          }
          Drush::output()->writeln('<comment>Creating bid of '. $bidListItem['bid'] .'$</comment>' );
          // also save a revision for the 1650 bid to the bike
          if($bidListItem['bid'] == 1650) {
            $query = \Drupal::entityQuery('bid')
              ->condition('user_id', $bidListItem['user_id'])
              ->condition('offer_id', $bidListItem['offer_id']);
            $results = $query->execute();
            $bidId = $results ? reset($results) : FALSE;
            if($bidId) {
              $bid = Bid::load($bidId);
              $bid->set('bid', 1700);
              $bid->setNewRevision(TRUE);
              $bid->setRevisionLogMessage('Bid raised for offer ' . $bidListItem['offer_id']);
              $bid->setRevisionCreationTime(\Drupal::time()->getRequestTime());
              $bid->setRevisionUserId(\Drupal::currentUser()->id());
              $bid->save();
              $count +=1;
            }
          }
        }
        return $count;
        break;
    }

    return null;

  }

  public function getOfferList() {
    $data = [
      [
        'title' => 'Gq2019 Mens Mountain Trail Bike,11 Speed Mountain Bike Aluminum',
        'field_description' => '
            <ul>
              <li>Photochromic mountain bike, the use of aluminum alloy frame, hydraulic disc brake system, wheel diameter size: 27.5 inches</li>
              <li>An all action mountain bike, that is as comfortable on the road as well as on a country lane</li>
              <li>Lightweight frame, aviation-grade aluminum alloy frame, lighter and stronger</li>
              <li>27.5-inch large wheels, large wheel diameter, better handling performance, stronger passability, each lap goes further</li>
              <li>Remote lock pneumatic front fork, excellent shock absorption performance, can absorb the vibration from the ground, equipped with remote lock, easy to operate and improve riding comfort</li>
            </ul>
          ',
        'field_price' => 1500,
        'field_offer_type' => 'with_minimum',
        'field_image' => 'https://stefvanlooveren.me/seeds/61-HR1eqFuL._AC_SL1001_.jpg',
        'moderation_state' => 'published',
        'username' => 'Amber Knight'
      ],
      [
        'title' => 'Labradorite Gemstone',
        'field_description' => '
          <ul>
            <li>Size : 10x14x4&nbsp;</li>
            <li>Gemstone : Labradorite</li>
            <li>Origin : Madagascar</li>
            <li>quantity: 2 ps</li>
            <li>Free Drill Service Available</li>
            <li>Shipping Timing : Ready to Dispatch in 1 - 2 business daysWe accept wholesale orders and all kinds of gemstones are available in small and bulk quantity</li>
          </ul>
          ',
        'field_price' => 0,
        'field_offer_type' => 'no_minimum',
        'field_image' => 'https://stefvanlooveren.me/seeds/il_794xN.2738953975_4wer.jpg',
        'moderation_state' => 'published',
        'username' => 'Eric Wang'
      ],
      [
        'title' => 'Abstract original painting by Camilo Mattis',
        'field_description' => '
          <p>Extra large colorful abstract modern wall art pop art abstract original painting by Camilo Mattis<br />
          <br />
          Title: Jazz<br />
          Technique: Acrylic on canvas<br />
          Size: Width: 35.5 (90 cm) x Height: 35.5" (90cm) x Thickness: 0.8" (2 cm)<br />
          There may be slight variations in colors due to differences in lighting and monitors.</p>
          ',
        'field_price' => 440,
        'field_offer_type' => 'with_minimum',
        'field_image' => 'https://stefvanlooveren.me/seeds/il_794xN.1980396897_g19o.jpg',
        'moderation_state' => 'published',
        'username' => 'Kim Barkeley'
      ],
      [
        'title' => 'Waxed Canvas and Leather Work Apron with Pockets',
        'field_description' => '
          Waxed Canvas and Leather Work Apron with Pockets Heavy Duty Woodworking and Metalworking Apron with Free Monogram Personalized Gift for Her
          ',
        'field_price' => 0,
        'field_offer_type' => 'no_minimum',
        'field_image' => 'https://stefvanlooveren.me/seeds/il_794xN.2642593398_tmbh.jpg',
        'moderation_state' => 'published',
        'username' => 'Amber Knight'
      ],
      [
        'title' => '6 Foot Canadian Outdoor Pine Wood 4 Person Barrel Sauna',
        'field_description' => '
          <ul>
            <li>Grade A Canadian Pine 1 3/8" thick to provide a great insulation barrier and plenty of strength</li>
            <li>Large 6\' Size, 4+ Person Capacity 9KW Sauna Heater w/ Lava Rocks included. 1 Year Warranty.</li>
            <li>Water Bucket + Ladle, Thermometer / Hydrometer Included. Overall Assembled Size: 6\' Feet Long x 6" Feet Diameter (Slightly taller due to legs)</li>
            <li>Assembly Required. This will ship "Flat Packed" to reduce freight cost. Assembly instructions will be included. (All barrel saunas ship this way. Its impossible to ship a fully assembled sauna)</li>
            <li>Ships fast! (LTL curbside delivery only) All shipments can go out within 1 day, but please ensure your phone # is provided. Ships from Vista, CA distribution center.</li>
          </ul>
        ',
        'field_price' => 450,
        'field_offer_type' => 'with_minimum',
        'field_image' => 'https://stefvanlooveren.me/seeds/230-1_1_1.png',
        'moderation_state' => 'published',
        'username' => 'Amber Knight'
      ],
    ];
    return $data;
  }

  public function getBidList()
  {
    $data = [];
    // we are not sure about the correct uid's, so to make this
    // always work, we load them by username
    // so no problem, if we would create and delete
    // multiple times
    $users = [
      'Amber Knight',
      'Eric Wang',
      'Kim Barkeley'
    ];
    $offers = $this->getOfferList();
    foreach ($users as $username) {
      $user = user_load_by_name($username);
      $uid = $user->id();
      if ($username == 'Amber Knight') {
        if ($uid) {
          // to the gemstones, she offers 2$
          $offer = $this->offer_load_by_title($offers[1]['title']);
          if ($offer) {
            $data[] = [
              'user_id' => $uid,
              'offer_id' => $offer->id(),
              'bid' => 2
            ];
          }
          // to the painting, she offers 600$
          $offer = $this->offer_load_by_title($offers[2]['title']);
          if ($offer) {
            $data[] = [
              'user_id' => $uid,
              'offer_id' => $offer->id(),
              'bid' => 600
            ];
          }
        }
      }
      if ($username == 'Eric Wang') {
        if ($uid) {
          // to the bike, he offers 1550
          $offer = $this->offer_load_by_title($offers[0]['title']);
          if ($offer) {
            $data[] = [
              'user_id' => $uid,
              'offer_id' => $offer->id(),
              'bid' => 1550
            ];
          }
          // to the gemstones, he offers 4$
          $offer = $this->offer_load_by_title($offers[1]['title']);
          if ($offer) {
            $data[] = [
              'user_id' => $uid,
              'offer_id' => $offer->id(),
              'bid' => 4
            ];
          }
          // to the canvas, he offers 50$
          $offer = $this->offer_load_by_title($offers[3]['title']);
          if ($offer) {
            $data[] = [
              'user_id' => $uid,
              'offer_id' => $offer->id(),
              'bid' => 50
            ];
          }
        }
      }
      if ($username == 'Kim Barkeley') {
        if ($uid) {
          // to the bike, she offers 1550
          $offer = $this->offer_load_by_title($offers[0]['title']);
          if ($offer) {
            $data[] = [
              'user_id' => $uid,
              'offer_id' => $offer->id(),
              'bid' => 1650
            ];
          }
          // to the gemstones, she offers 4$
          $offer = $this->offer_load_by_title($offers[1]['title']);
          if ($offer) {
            $data[] = [
              'user_id' => $uid,
              'offer_id' => $offer->id(),
              'bid' => 6
            ];
          }
          // to the canvas, she offers 50$
          $offer = $this->offer_load_by_title($offers[3]['title']);
          if ($offer) {
            $data[] = [
              'user_id' => $uid,
              'offer_id' => $offer->id(),
              'bid' => 55
            ];
          }
        }
      }
    }

    return $data;

  }

  public function offer_load_by_title($title) {
    $offers = \Drupal::entityTypeManager()->getStorage('offer')
      ->loadByProperties(['title' => $title]);
    return $offers ? reset($offers) : FALSE;
  }


}

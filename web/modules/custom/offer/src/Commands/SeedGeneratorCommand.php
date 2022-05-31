<?php

namespace  Drupal\offer\Commands;

use Drush\Commands\DrushCommands;
use Drupal\offer\SeedData\SeedDataGenerator;
use Drush\Drush;

/**
 * Class SeedGeneratorCommand
 * @package Drupal\offer\Commands
 */
class SeedGeneratorCommand extends DrushCommands {

  /**
   * Runs the OfferCreateSeeds command. Will create all data for the Offer platform.
   *
   * @command offer-create-seeds
   * @aliases offercs
   * @usage drush offer-create-seeds
   *  Display 'Seed data created'
   */
  public function OfferCreateSeeds() {
    $seed = new SeedDataGenerator();
    $count = $seed->Generate('user');
    Drush::output()->writeln('<info>'. $count . ' user(s) created</info>' );
    $count = $seed->Generate('offer');
    Drush::output()->writeln('<info>'. $count . ' offer(s) created</info>' );
    $count = $seed->Generate('bid');
    Drush::output()->writeln('<info>'. $count . ' bid(s) created</info>' );
  }
}

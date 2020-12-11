<?php
namespace MUT\Crops;

class CropOnion extends \MUT\Crop
{
  public function __construct($row = null)
  {
    parent::__construct($row);
    $this->type  = ONION;
    $this->name  = clienttranslate('Onion');
    $this->promo = false;
    $this->copies = 3;
    $this->seeds = 1;

    $this->power1 = [1, 1];
    $this->power2 = [2, 2];
    $this->power3 = [2, FOOD, clienttranslate('At the end of game, gain 1 COINS for each of your Onion cards (including this one).') ];
  }
}

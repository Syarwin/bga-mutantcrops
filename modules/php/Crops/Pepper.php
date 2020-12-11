<?php
namespace MUT\Crops;

class CropPepper extends \MUT\Crop
{
  public function __construct($row = null)
  {
    parent::__construct($row);
    $this->type  = PEPPER;
    $this->name  = clienttranslate('Pepper');
    $this->promo = false;
    $this->copies = 1;
    $this->seeds = 3;

    $this->power1 = [1, 1];
    $this->power2 = [5, 4];
    $this->power3 = [2, WATER, clienttranslate('At the end of game, gain 2 COINS for every 3 FOODS remaining in your personal supply.') ];
  }
}

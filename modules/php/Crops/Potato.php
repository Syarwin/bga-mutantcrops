<?php
namespace MUT\Crops;

class CropPotato extends \MUT\Crop
{
  public function __construct($row = null)
  {
    parent::__construct($row);
    $this->type  = POTATO;
    $this->name  = clienttranslate('Potato');
    $this->promo = true;
    $this->copies = 1;
    $this->seeds = 4;

    $this->power1 = [2, 2];
    $this->power2 = [5, 4];
    $this->power3 = [3, WATER, clienttranslate('At the end of game, if you sowed an Eggplan, you get 4 COINS.') ];
  }
}

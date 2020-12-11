<?php
namespace MUT\Crops;

class CropPumpkin extends \MUT\Crop
{
  public function __construct($row = null)
  {
    parent::__construct($row);
    $this->type  = PUMPKIN;
    $this->name  = clienttranslate('Pumpkin');
    $this->promo = false;
    $this->copies = 1;
    $this->seeds = 3;

    $this->power1 = [2, 2];
    $this->power2 = [4, 3];
    $this->power3 = [2, WATER, clienttranslate('If at the end of game, you have sowed at least 1 Chard and 1 Onion, gain 5 COINS.') ];
  }
}

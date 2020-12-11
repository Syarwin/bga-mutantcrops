<?php
namespace MUT\Crops;

class CropStrawberry extends \MUT\Crop
{
  public function __construct($row = null)
  {
    parent::__construct($row);
    $this->type  = STRAWBERRY;
    $this->name  = clienttranslate('Strawberry');
    $this->promo = false;
    $this->copies = 1;
    $this->seeds = 4;

    $this->power1 = [3, 3];
    $this->power2 = [5, 4];
    $this->power3 = [2, FOOD, clienttranslate('If at the end of game, you have sowed at least 1 Chard and 1 Onion, gain 5 COINS.') ];
  }
}

<?php
namespace MUT\Crops;

class CropPeach extends \MUT\Crop
{
  public function __construct($row = null)
  {
    parent::__construct($row);
    $this->type  = PEACH;
    $this->name  = clienttranslate('PEACH');
    $this->promo = false;
    $this->copies = 1;
    $this->seeds = 3;

    $this->power1 = [5, 4];
    $this->power2 = [1, 1];
    $this->power3 = [3, WATER, clienttranslate('At the end of game, if you sowed a Pear, you get 3 COINS. If you sowed a Strawberry, get 4 COINS.') ];
  }
}

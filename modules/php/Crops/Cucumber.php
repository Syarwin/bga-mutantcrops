<?php
namespace MUT\Crops;

class CropCucumber extends \MUT\Crop
{
  public function __construct($row = null)
  {
    parent::__construct($row);
    $this->type  = CUCUMBER;
    $this->name  = clienttranslate('Cucumber');
    $this->promo = false;
    $this->copies = 2;
    $this->seeds = 2;

    $this->power1 = [3, 2];
    $this->power2 = [2, 2];
    $this->power3 = [3, WATER, clienttranslate('At the end of game, if you sowed another Cucumber, you get 4 COINS.') ];
  }
}

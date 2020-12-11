<?php
namespace MUT\Crops;

class CropChard extends \MUT\Crop
{
  public function __construct($row = null)
  {
    parent::__construct($row);
    $this->type  = CHARD;
    $this->name  = clienttranslate('Chard');
    $this->promo = false;
    $this->copies = 3;
    $this->seeds = 1;

    $this->power1 = [2, 2];
    $this->power2 = [1, 1];
    $this->power3 = [2, WATER, clienttranslate('At the end of game, gain 1 COINS for each of your Chard cards (including this one).') ];
  }
}

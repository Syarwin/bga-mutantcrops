<?php
namespace MUT\Crops;

class CropBroccoli extends \MUT\Crop
{
  public function __construct($row = null)
  {
    parent::__construct($row);
    $this->type  = BROCCOLI;
    $this->name  = clienttranslate('Broccoli');
    $this->promo = false;
    $this->copies = 2;
    $this->seeds = 2;

    $this->power1 = [1, 1];
    $this->power2 = [3, 2];
    $this->power3 = [3, FOOD, clienttranslate('At the end of game, choose a plant another player has sowed and copy the ability.') ];
  }
}

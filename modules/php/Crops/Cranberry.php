<?php
namespace MUT\Crops;

class CropCranberry extends \MUT\Crop
{
  public function __construct($row = null)
  {
    parent::__construct($row);
    $this->type  = CRANBERRY;
    $this->name  = clienttranslate('Cranberry');
    $this->promo = false;
    $this->copies = 1;
    $this->seeds = 5;

    $this->power1 = [5, 4];
    $this->power2 = [4, 4];
    $this->power3 = [2, FOOD, clienttranslate('At the end of game, the Cranberry count as any other sowed crop you choose') ];
  }
}

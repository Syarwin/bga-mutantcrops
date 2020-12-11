<?php
namespace MUT\Crops;

class CropOrange extends \MUT\Crop
{
  public function __construct($row = null)
  {
    parent::__construct($row);
    $this->type  = ORANGE;
    $this->name  = clienttranslate('Orange');
    $this->promo = true;
    $this->copies = 1;
    $this->seeds = 3;

    $this->power1 = [1, 1];
    $this->power2 = [3, 2];
    $this->power3 = [2, WATER, clienttranslate('At the end of game, the Orange count as any other sowed crop you choose.') ];
  }
}

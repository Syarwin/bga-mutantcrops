<?php
namespace MUT\Crops;

class CropMelon extends \MUT\Crop
{
  public function __construct($row = null)
  {
    parent::__construct($row);
    $this->type  = MELON;
    $this->name  = clienttranslate('Melon');
    $this->promo = false;
    $this->copies = 1;
    $this->seeds = 6;

    $this->power1 = [5, 5];
    $this->power2 = [5, 5];
    $this->power3 = [3, FOOD, clienttranslate('At the end of game, if you have the most resource tokens in your personal supply, gain 4 COINS.') ];
  }
}

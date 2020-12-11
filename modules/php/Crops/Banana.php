<?php
namespace MUT\Crops;

class CropBanana extends \MUT\Crop
{
  public function __construct($row = null)
  {
    parent::__construct($row);
    $this->type  = BANANA;
    $this->name  = clienttranslate('Banana');
    $this->promo = true;
    $this->copies = 2;
    $this->seeds = 7;

    $this->power1 = [2, 2];
    $this->power2 = [1, 1];
    $this->power3 = [1, FOOD, clienttranslate('Search for a card in the deck and sow it paying it cost. Then rotate crops.') ];
  }
}

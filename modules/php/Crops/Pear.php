<?php
namespace MUT\Crops;

class CropPear extends \MUT\Crop
{
  public function __construct($row = null)
  {
    parent::__construct($row);
    $this->type  = PEAR;
    $this->name  = clienttranslate('Pear');
    $this->promo = false;
    $this->copies = 1;
    $this->seeds = 3;

    $this->power1 = [4, 3];
    $this->power2 = [2, 2];
    $this->power3 = [3, FOOD, clienttranslate('Search for a plant and sow it without paying his SEEDS cost. Rotate crops after that.') ];
  }
}

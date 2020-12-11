<?php
namespace MUT\Crops;

class CropEggplant extends \MUT\Crop
{
  public function __construct($row = null)
  {
    parent::__construct($row);
    $this->type  = EGGPLANT;
    $this->name  = clienttranslate('Eggplant');
    $this->promo = false;
    $this->copies = 2;
    $this->seeds = 2;

    $this->power1 = [3, 2];
    $this->power2 = [1, 1];
    $this->power3 = [2, FOOD, clienttranslate('Immediately sow a plant with cost 4 SEEDS or less, without paying the seeds.') ];
  }
}

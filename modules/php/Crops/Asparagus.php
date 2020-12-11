<?php
namespace MUT\Crops;

class CropAsparagus extends \MUT\Crop
{
  public function __construct($row = null)
  {
    parent::__construct($row);
    $this->type  = ASPARAGUS;
    $this->name  = clienttranslate('Asparagus');
    $this->promo = true;
    $this->copies = 1;
    $this->seeds = 7;

    $this->power1 = [7, 6];
    $this->power2 = [5, 5];
    $this->power3 = [2, FOOD, clienttranslate('At the end of game, if you sowed at least 5 crops (Asparagus included) you get 5 COINS.') ];
  }
}

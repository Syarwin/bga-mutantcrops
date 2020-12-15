<?php
namespace MUT\Fields;

class Field2 extends \MUT\Field
{
  protected $id = 2;
  protected $stage = 1;
  protected $promo = false;

  // 3 Food
  public function canUseTop($player){
    return true;
  }

  public function resolveTop($player){
    $player->addResources('food', 3, $this->getTopId());
    return null;
  }
}

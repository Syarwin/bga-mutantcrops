<?php
namespace MUT\Fields;

class Field5 extends \MUT\Field
{
  protected $id = 5;
  protected $stage = 1;
  protected $promo = false;

  // 2 Seeds
  public function canUseTop($player){
    return true;
  }

  public function resolveTop($player){
    $player->addResources('seeds', 2, $this->getTopId());
    return null;
  }
}

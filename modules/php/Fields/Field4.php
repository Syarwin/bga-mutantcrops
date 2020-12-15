<?php
namespace MUT\Fields;

class Field4 extends \MUT\Field
{
  protected $id = 4;
  protected $stage = 1;
  protected $promo = false;

  // 2 Water
  public function canUseTop($player){
    return true;
  }

  public function resolveTop($player){
    $player->addResources('water', 2, $this->getTopId());
    return null;
  }
}

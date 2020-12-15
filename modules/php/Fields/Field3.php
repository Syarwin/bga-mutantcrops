<?php
namespace MUT\Fields;

class Field3 extends \MUT\Field
{
  protected $id = 3;
  protected $stage = 1;
  protected $promo = false;

  // 2 Food
  public function canUseTop($player){
    return true;
  }

  public function resolveTop($player){
    $player->addResources('food', 2, $this->getTopId());
    return null;
  }


  // 1 of each
  public function canUseBottom($player){
    return true;
  }

  public function resolveBottom($player){
    $player->addMultiResources([1,1,1], $this->getBottomId() );
    return null;
  }
}

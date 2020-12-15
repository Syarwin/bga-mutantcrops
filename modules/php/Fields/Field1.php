<?php
namespace MUT\Fields;

class Field1 extends \MUT\Field
{
  protected $id = 1;
  protected $stage = 1;
  protected $promo = false;

  // 3 Water
  public function canUseTop($player){
    return true;
  }

  public function resolveTop($player){
    $player->addResources('water', 3, $this->getTopId());
    return null;
  }


  // Water or Feed
  public function canUseBottom($player){
    return $player->canWaterOrFeed();
  }

  public function resolveBottom($player){
    return 'waterOrFeed';
  }

}

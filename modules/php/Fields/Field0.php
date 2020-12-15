<?php
namespace MUT\Fields;

class Field0 extends \MUT\Field
{
  protected $id = 0;
  protected $stage = 1;
  protected $promo = false;

  // 3 Seeds
  public function canUseTop($player){
    return true;
  }

  public function resolveTop($player){
    $player->addResources('seeds', 3, $this->getTopId());
    return null;
  }

  // Sow
  public function canUseBottom($player){
    return $player->canSow();
  }

  public function resolveBottom($player){
    return 'sow';
  }
}

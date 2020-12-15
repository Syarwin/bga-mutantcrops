<?php
namespace MUT;
use Fields;


class Field {
  protected $id = null;
  protected $stage = 1;
  protected $promo = false;
  protected $location = null;

  public function __construct($row = null){
    if(is_null($row))
      return;
    $this->location = $row['location'];
  }

  public function getId(){ return $this->id; }
  public function getTopId() { return 2*$this->id; }
  public function getBottomId() { return 2*$this->id + 1; }
  public function getStage(){ return $this->stage; }
  public function isPromo(){ return $this->promo; }
  public function getInfo(){
    return [
      'id' => $this->id,
      'location' => $this->location,
    ];
  }
  public function top() {}
  public function bottom() {}

  public function addAvailableLocations(&$locations, $player, $farmers){
    if(!in_array($this->getTopId(), $farmers) && $this->canUseTop($player))
      array_push($locations, $this->getTopId());

    if(!in_array($this->getBottomId(), $farmers) && $this->canUseBottom($player))
      array_push($locations, $this->getBottomId());
  }

  public function canUseTop($player){
    return false;
  }

  public function canUseBottom($player){
    return false;
  }

  public function resolveTop($player){
    return null;
  }
  public function resolveBottom($player){
    return null;
  }
}

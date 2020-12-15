<?php
namespace MUT;
use Crops;


class Crop {
  protected $id = null;
  protected $type;
  protected $name;
  protected $promo = false;
  protected $copies = 1;
  protected $seeds;
  protected $power1;
  protected $power2;
  protected $power3;

  protected $water = false;
  protected $food = false;
  protected $special = false;

  public function __construct($row = null){
    if(is_null($row))
      return;

    $this->id = $row['id'];
    $this->water   = $row['water'] == 1;
    $this->food    = $row['food'] == 1;
    $this->special = $row['special'] == 1;
  }

  public function getId(){ return $this->id; }
  public function getType(){ return $this->type; }
  public function getName(){ return $this->name; }
  public function isPromo(){ return $this->promo; }
  public function getCopies(){ return $this->copies; }
  public function getSeeds(){ return (int) $this->seeds; }
  public function getWater(){ return (int) $this->power1[0]; }
  public function getFood(){ return (int) $this->power2[0]; }


  public function getInfo(){
    return [
      'id' => $this->id,
      'type' => $this->type,
    ];
  }

  public function getUiData(){
    return [
      'id' => $this->id,
      'type' => $this->type,
      'name' => $this->name,
      'seeds' => $this->seeds,
      'power1Cost' => $this->power1[0],
      'power1Effect' => $this->power1[1],
      'power2Cost' => $this->power2[0],
      'power2Effect' => $this->power2[1],
      'power3Cost' => $this->power3[0],
      'power3CostType' => $this->power3[1],
      'power3Effect' => $this->power3[2]
    ];
  }

  public function getStatus(){
    return [
      'id' => $this->id,
      'type' => $this->type,
      'water' => $this->water,
      'food' => $this->food,
      'special' => $this->special,
    ];
  }


  public function canBeWatered($player){
    return !$this->water &&  $player->getWater() >= $this->getWater();
  }

  public function canBeFeed($player){
    return !$this->food &&  $player->getFood() >= $this->getFood();
  }

  public function canBeSpecialed($player, $action = null){
    if($this->special || !$this->water || !$this->food)
      return false;

    $type = $this->power3[1] == FOOD? "food" : "water";
    if(!is_null($action) && $action != $type)
      return false;

    $ressource = $type == "food"? $player->getFood() : $player->getWater();
    return $ressource >= $this->power3[0];
  }


  public function getGrowResource($type){
    if($type == 'water' || $type == 'food')
      return $type;
    else
      return $this->power3[1] == FOOD? "food" : "water";
  }

  public function getGrowCost($type){
    if($type == 'water') return $this->power1[0];
    if($type == 'food')  return $this->power2[0];
    if($type == 'special') return $this->power3[0];
    return 0;
  }


  public function getCoinGain($type){
    return $type == 'water'? $this->power1[1] : $this->power2[1];
  }
}

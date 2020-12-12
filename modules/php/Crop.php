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

  public function __construct($row = null){
    if(is_null($row))
      return;

    $this->id = $row['id'];
  }

  public function getId(){ return $this->id; }
  public function getType(){ return $this->type; }
  public function getName(){ return $this->name; }
  public function isPromo(){ return $this->promo; }
  public function getCopies(){ return $this->copies; }
  public function getSeeds(){ return $this->seeds; }
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
    ];
  }

}

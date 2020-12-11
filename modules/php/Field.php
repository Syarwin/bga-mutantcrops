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
}

<?php
namespace MUT;

class Player
{
  public function __construct($row)
  {
    $this->id = (int) $row['player_id'];
    $this->no = (int) $row['player_no'];
    $this->name = $row['player_name'];
    $this->color = $row['player_color'];
    $this->eliminated = $row['player_eliminated'] == 1;
    $this->zombie = $row['player_zombie'] == 1;

    $this->farmers = [$row['farmer_0'], $row['farmer_1'], $row['farmer_2']];
    $this->coins = (int) $row['coins'];
    $this->seeds = (int) $row['seeds'];
    $this->water = (int) $row['water'];
    $this->food  = (int) $row['food'];
    $this->crops = []; //Crops::getPlayerCrops($this->id);
  }

  private $game;
  private $id;
  private $no; // natural order
  private $name;
  private $color;
  private $eliminated = false;
  private $zombie = false;

  private $farmers = [];
  private $crops = [];
  private $coins;
  private $seeds;
  private $water;
  private $food;


  public function getId(){ return $this->id; }
  public function getNo(){ return $this->no; }
  public function getName(){ return $this->name; }
  public function getColor(){ return $this->color; }
  public function isEliminated(){ return $this->eliminated; }
  public function isZombie(){ return $this->zombie; }
  public function getCrops(){ return $this->crops; }
  public function getFarmers()
  {
    if(Players::count() > 2)
      unset($this->farmers[2]);
    return $this->farmers;
  }

  public function getFarmersOnBoard()
  {
    return array_values(array_filter($this->getFarmers(), "is_numeric"));
  }

  public function hasFarmerInHand()
  {
    return count($this->getFarmersOnBoard()) < count($this->getFarmers());
  }

  public function getUiData()
  {
    return [
      'id'        => $this->id,
      'no'        => $this->no,
      'name'      => $this->name,
      'color'     => $this->color,
      'farmers'   => $this->getFarmers(),
      'coins'     => $this->coins,
      'seeds'     => $this->seeds,
      'water'     => $this->water,
      'food'      => $this->food,
      'crops'     => $this->crops,
    ];
  }

  public function canSow($cropId)
  {
    return (int) $this->seeds >= (int) $this->game->crops[$cropId]['seeds'];
  }

  public function addResources($type, $amount, $from = null)
  {
    $this->$type += $amount;
    $this->DbQuery("UPDATE player SET {$type} = {$this->$type} WHERE player_id = {$this->getId()}");
    Notifications::addResources($this, $from, $amount, $type, $this->$type);
  }


  public function addMultiResources($numbers, $from = null)
  {
    $this->food += $numbers[0];
    $this->water += $numbers[1];
    $this->seeds += $numbers[2];
    $this->DbQuery("UPDATE player SET food = {$this->food}, water = {$this->water}, seeds = {$this->seeds} WHERE player_id = {$this->getId()}");
    Notifications::addMultiResources($this, $from, $numbers, [$this->food, $this->water, $this->seeds]);
  }


  public function sowCrop($card, $cropPos)
  {
    $crop = $this->game->crops[$card['type']];
    $this->seeds -= $crop['seeds'];
    $this->DbQuery("UPDATE player SET seeds = {$this->seeds} WHERE player_id = {$this->getId()}");
  }

}
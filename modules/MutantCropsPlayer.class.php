<?php

// Cannot use Player, already taken by BGA
class MutantCropsPlayer extends APP_GameClass
{
  public function __construct($game, $row)
  {
    $this->game = $game;
    $this->id = (int) $row['id'];
    $this->no = (int) $row['no'];
    $this->name = $row['name'];
    $this->color = $row['color'];
    $this->eliminated = $row['eliminated'] == 1;
    $this->zombie = $row['zombie'] == 1;

    $this->farmers = [$row['farmer_0'], $row['farmer_1'], $row['farmer_2']];
    $this->coins = (int) $row['coins'];
    $this->seeds = (int) $row['seeds'];
    $this->water = (int) $row['water'];
    $this->food  = (int) $row['food'];
  }

  private $game;
  private $id;
  private $no; // natural order
  private $name;
  private $color;
  private $eliminated = false;
  private $zombie = false;

  private $farmers = [];
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
  public function getFarmers()
  {
    if($this->game->playerManager->getPlayerCount() < 4)
      unset($this->farmers[2]);
    return $this->farmers;
  }

  public function getFarmersOnBoard()
  {
    return array_values(array_filter($this->getFarmers()));
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
    ];
  }
}

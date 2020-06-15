<?php

require_once('MutantCropsPlayer.class.php');

/*
 * PlayerManager : allows to easily access players ...
 *  a player is an instance of MutantCropsPlayer class
 */
class PlayerManager extends APP_GameClass
{
  public $game;
  public function __construct($game)
  {
    $this->game = $game;
  }

  /*
   * getPlayer : returns the SantoriniPlayer object for the given player ID
   */
  public function getPlayer($playerId = null)
  {
    $playerId = $playerId ?: $this->game->getActivePlayerId();
    $players = $this->getPlayers([$playerId]);
    return $players[0];
  }

  /*
   * getPlayers : Returns array of SantoriniPlayer objects for all/specified player IDs
   */
  public function getPlayers($playerIds = null)
  {
    $sql = "SELECT player_id id, player_color color, player_name name, player_score score, player_zombie zombie, player_eliminated eliminated, player_no no, farmer_0, farmer_1, farmer_2, coins, seeds, water, food FROM player";
    if (is_array($playerIds)) {
      $sql .= " WHERE player_id IN ('" . implode("','", $playerIds) . "')";
    }
    $rows = self::getObjectListFromDb($sql);

    $players = [];
    foreach ($rows as $row) {
      $player = new MutantCropsPlayer($this->game, $row);
      $players[] = $player;
    }
    return $players;
  }

  /*
   * getPlayerCount: return the number of players
   */
  public function getPlayerCount()
  {
    return intval(self::getUniqueValueFromDB("SELECT COUNT(*) FROM player"));
  }


  /*
   * getUiData : get all ui data of all players : id, no, name, team, color, powers list, farmers
   */
  public function getUiData()
  {
    $ui = [];
    foreach ($this->getPlayers() as $player)
       $ui[] = $player->getUiData();

    return $ui;
  }


  public function getFarmersLocations()
  {
    $locations = [];
    foreach ($this->getPlayers() as $player)
      $locations = array_merge($locations, $player->getFarmers());

    return array_values(array_filter($locations, "is_numeric"));
  }
}

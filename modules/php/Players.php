<?php
namespace MUT;
use MutantCrops;

/*
 * PlayerManager : allows to easily access players ...
 *  a player is an instance of MutantCropsPlayer class
 */
class Players extends Helpers\DB_Manager
{
  protected static $table = 'player';
  protected static $primary = 'player_id';
  protected static $associative = false;
  protected static function cast($row)
  {
    return new \MUT\Player($row);
  }


  public function setupNewGame($players)
  {
    // Create players
    self::DB()->delete();

    $gameInfos = MutantCrops::get()->getGameinfos();
    $query = self::DB()->multipleInsert(['player_id', 'player_color', 'player_canal', 'player_name', 'player_avatar', 'coins', 'seeds', 'water', 'food']);
    $values = [];
    $i = 0;
    foreach ($players as $pId => $player) {
      $seeds = $i == 1? 1 : 2;
      $color = $gameInfos['player_colors'][$i++];
//      $values[] = [$pId, $color, $player['player_canal'], $player['player_name'], $player['player_avatar'], 0, $seeds, 0, 0];
      $values[] = [$pId, $color, $player['player_canal'], $player['player_name'], $player['player_avatar'], 0, $seeds, 7, 7];
    }
    $query->values($values);
    MutantCrops::get()->reattributeColorsBasedOnPreferences($players, ["ff0000", "008000", "0000ff", "ffa500"]);
    MutantCrops::get()->reloadPlayersBasicInfos();
  }


  public function getActiveId()
  {
    return MutantCrops::get()->getActivePlayerId();
  }

  public function getAll(){
    return self::DB()->get();
  }

  /*
   * get : returns the MutantCrops object for the given player ID
   */
  public function get($pId = null)
  {
    $pId = $pId ?: self::getActiveId();
    return self::DB()->where($pId)->get();
  }

  public function getActive()
  {
    return self::get();
  }

  /*
   * getPlayerCount: return the number of players
   */
  public function count()
  {
    return self::DB()->count();
  }


  /*
   * getUiData : get all ui data of all players : id, no, name, team, color, powers list, farmers
   */
  public function getUiData()
  {
    $ui = [];
    foreach (self::getAll() as $player)
       $ui[] = $player->getUiData();

    return $ui;
  }


  public function getFarmersLocations()
  {
    $locations = [];
    foreach (self::getAll() as $player)
      $locations = array_merge($locations, $player->getFarmers());

    return array_values(array_filter($locations, "is_numeric"));
  }
}

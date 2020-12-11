<?php
namespace MUT;
use MutantCrops;

/*
 * MutantCropsLog: a class that allows to log some actions
 *   and then fetch these actions latter
 */
class Log extends \APP_GameClass
{
    ////////////////////////////////
    ////////////////////////////////
    //////////   Adders   //////////
    ////////////////////////////////
    ////////////////////////////////

    /*
     * insert: add a new log entry
     * params:
     *   - $playerId: the player who is making the action
     *   - $pieceId : the piece whose is making the action
     *   - string $action : the name of the action
     *   - array $args : action arguments (eg space)
     */
    public function insert($playerId, $cardId, $action, $args)
    {
      $playerId = $playerId == -1 ? Players::getActiveId() : $playerId;
      $round = MutantCrops::get()->getGameStateValue("currentRound");
      $actionArgs = is_array($args) ? json_encode($args) : $args;
      self::DbQuery("INSERT INTO log (`round`, `player_id`, `card_id`, `action`, `action_arg`) VALUES ('$round', '$playerId', '$cardId', '$action', '$actionArgs')");
    }


    /*
     * starTurn: TODO
     */
    public function startTurn()
    {
      self::insert(-1, 0, 'startTurn', '{}');
    }

    /*
     * addAction: add a new action to log
     */
    public function addAction($action, $args = '{}')
    {
      self::insert(-1, 0, $action, $args);
    }


    /////////////////////////////////
    /////////////////////////////////
    //////////   Getters   //////////
    /////////////////////////////////
    /////////////////////////////////
    public function getAction($action)
    {
      $log = self::getObjectFromDb("SELECT * FROM log WHERE `action` = '$action'");
      return json_decode($log['action_arg'], true);
    }

}

<?php

/*
 * MutantCropsLog: a class that allows to log some actions
 *   and then fetch these actions latter
 */
class MutantCropsLog extends APP_GameClass
{
  public $game;
  public function __construct($game)
  {
    $this->game = $game;
  }



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
      $playerId = $playerId == -1 ? $this->game->getActivePlayerId() : $playerId;
      $round = $this->game->getGameStateValue("currentRound");
      $actionArgs = is_array($args) ? json_encode($args) : $args;
      self::DbQuery("INSERT INTO log (`round`, `player_id`, `card_id`, `action`, `action_arg`) VALUES ('$round', '$playerId', '$cardId', '$action', '$actionArgs')");
    }


    /*
     * starTurn: TODO
     */
    public function startTurn()
    {
      $this->insert(-1, 0, 'startTurn', '{}');
    }

    /*
     * addAction: add a new action to log
     */
    public function addAction($action, $args = '{}')
    {
      $this->insert(-1, 0, $action, $args);
    }


    /////////////////////////////////
    /////////////////////////////////
    //////////   Getters   //////////
    /////////////////////////////////
    /////////////////////////////////
}

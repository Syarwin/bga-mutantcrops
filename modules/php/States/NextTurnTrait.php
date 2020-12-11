<?php
namespace MUT\States;
use MUT\Log;
use MUT\Players;

trait NextTurnTrait
{
  ////////////////////////////////////////////////
  ////////////   Next player / Win   ////////////
  ////////////////////////////////////////////////

  /*
   * stNextPlayer: go to next player
   */
  public function stNextPlayer()
  {
    $pId = self::activeNextPlayer();
    self::giveExtraTime($pId);
    if (self::getGamestateValue("firstPlayer") == $pId) {
      $n = (int) self::getGamestateValue('actionCounter') + 1;
      $actionPerTurn = Players::count() == 2? 3 : 2;
      if($n == $actionPerTurn){
        $m = (int) self::getGamestateValue('currentRound') + 1;
        self::setGamestateValue("currentRound", $m);
        $n = 0;

        $field = Fields::new();
        Notifications::newField($field);
      }
      self::setGamestateValue("actionCounter", $n);
    }

    $this->gamestate->nextState('start');
  }

  /*
   * stStartOfTurn: called at the beggining of each player turn
   */
  public function stStartOfTurn()
  {
    Log::startTurn();
    $state = "assign";
    $this->gamestate->nextState($state);
  }


  /*
   * stEndOfTurn: called at the end of each player turn
   */
  public function stEndOfTurn()
  {
    $this->stCheckEndOfGame();
    $this->gamestate->nextState('next');
  }

  /*
   * stCheckEndOfGame: check if the game is finished
   */
  public function stCheckEndOfGame()
  {
    return false;
  }


  /*
   * announceWin: TODO
   *
  public function announceWin($playerId, $win = true)
  {
    $players = $win ? $this->playerManager->getTeammates($playerId) : $this->playerManager->getOpponents($playerId);
    if (count($players) == 2) {
      self::notifyAllPlayers('message', clienttranslate('${player_name} and ${player_name2} win!'), [
        'player_name' => $players[0]->getName(),
        'player_name2' => $players[1]->getName(),
      ]);
    } else {
      self::notifyAllPlayers('message', clienttranslate('${player_name} wins!'), [
        'player_name' => $players[0]->getName(),
      ]);
    }
    self::DbQuery("UPDATE player SET player_score = 1 WHERE player_team = {$players[0]->getTeam()}");
    $this->gamestate->nextState('endgame');
  }
  */
}

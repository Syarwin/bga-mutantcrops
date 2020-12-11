<?php
 /**
  *------
  * BGA framework: © Gregory Isabelli <gisabelli@boardgamearena.com> & Emmanuel Colin <ecolin@boardgamearena.com>
  * MutantCrops implementation : © Timothée Pecatte <tim.pecatte@gmail.com>
  *
  * This code has been produced on the BGA studio platform for use on http://boardgamearena.com.
  * See http://en.boardgamearena.com/#!doc/Studio for more information.
  * -----
  *
  * mutantcrops.game.php
  *
  */


use MUT\Players;
use MUT\Crops;
use MUT\Fields;
use MUT\Log;
/*
$autoloadFuncs = spl_autoload_functions();
foreach($autoloadFuncs as $unregisterFunc)
{
    spl_autoload_unregister($unregisterFunc);
}
*/
$swdNamespaceAutoload = function ($class) {
   $classParts = explode('\\', $class);
   if ($classParts[0] == 'MUT') {
       array_shift($classParts);
       $file = dirname(__FILE__) . "/modules/php/" . implode(DIRECTORY_SEPARATOR, $classParts) . ".php";
       if (file_exists($file)) {
           require_once($file);
       }
   }
};
spl_autoload_register($swdNamespaceAutoload, true, true);


require_once( APP_GAMEMODULE_PATH.'module/table/table.game.php' );


class MutantCrops extends Table
{
  use MUT\States\NextTurnTrait;
  use MUT\States\AssignTrait;
  use MUT\States\SowTrait;

  public static $instance = null;
  public function __construct() {
    parent::__construct();
    self::$instance = $this;

    self::initGameStateLabels([
      'optionSetup'  => OPTION_SETUP,
      'currentRound' => CURRENT_ROUND,
      'actionCounter'=> ACTION_COUNTER,
      'firstPlayer'  => FIRST_PLAYER,
    ]);
  }
  public static function get(){
   return self::$instance;
  }

  protected function getGameName()
  {
		return "mutantcrops";
  }


  /*
   * setupNewGame:
   *  This method is called only once, when a new game is launched.
   * params:
   *  - array $players
   *  - mixed $options
   */
  protected function setupNewGame($players, $options = [])
  {
    MUT\Players::setupNewGame($players);
    MUT\Crops::setupNewGame($players);
    MUT\Fields::setupNewGame($players);

    // Active first player to play
    $pId = $this->activeNextPlayer();
    self::setGameStateInitialValue('firstPlayer', $pId);
    self::setGameStateInitialValue('currentRound', 0);
    self::setGameStateInitialValue('actionCounter', -1);
  }

  /*
   * getAllDatas:
   *  Gather all informations about current game situation (visible by the current player).
   *  The method is called each time the game interface is displayed to a player, ie: when the game starts and when a player refreshes the game page (F5)
   */
  protected function getAllDatas()
  {
    return [
			'cropsData' => MUT\Crops::getUiData(),
			'crops' => MUT\Crops::getOnBoard(),
      'fields' => MUT\Fields::getOnBoard(),
      'fplayers' => MUT\Players::getUiData(),
    ];
  }

  /*
   * getGameProgression:
   *  Compute and return the current game progression approximation
   *  This method is called each time we are in a game state with the "updateGameProgression" property set to true
   */
  public function getGameProgression()
  {
		// TODO
//    return count($this->board->getPlacedPieces()) / 100;
    return 0.3;
  }



  ////////////////////////////////////
  ////////////   Zombie   ////////////
  ////////////////////////////////////
  /*
   * zombieTurn:
   *   This method is called each time it is the turn of a player who has quit the game (= "zombie" player).
   *   You can do whatever you want in order to make sure the turn of this player ends appropriately
   */
  public function zombieTurn($state, $activePlayer)
  {
    if (array_key_exists('zombiePass', $state['transitions'])) {
      $this->playerManager->eliminate($activePlayer);
      $this->gamestate->nextState('zombiePass');
    } else {
      throw new BgaVisibleSystemException('Zombie player ' . $activePlayer . ' stuck in unexpected state ' . $state['name']);
    }
  }

  /////////////////////////////////////
  //////////   DB upgrade   ///////////
  /////////////////////////////////////
  // You don't have to care about this until your game has been published on BGA.
  // Once your game is on BGA, this method is called everytime the system detects a game running with your old Database scheme.
  // In this case, if you change your Database scheme, you just have to apply the needed changes in order to
  //   update the game database and allow the game to continue to run with your new version.
  /////////////////////////////////////
  /*
   * upgradeTableDb
   *  - int $from_version : current version of this game database, in numerical form.
   *      For example, if the game was running with a release of your game named "140430-1345", $from_version is equal to 1404301345
   */
  public function upgradeTableDb($from_version)
  {
  }
}

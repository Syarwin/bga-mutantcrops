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
 * mutantcrops.view.php
 *
 */

  require_once( APP_BASE_PATH."view/common/game.view.php" );

  class view_mutantcrops_mutantcrops extends game_view
  {
    function getGameName() {
        return "mutantcrops";
    }
  	function build_page( $viewArgs )
  	{
  	    // Get players & players number
        $players = $this->game->loadPlayersBasicInfos();
        $players_nbr = count( $players );


        $this->page->begin_block( "mutantcrops_mutantcrops", "playerCrops" );
        foreach($players as $player){
          $this->page->insert_block("playerCrops", [
            'PID' => $player['player_id'],
            'NAME' => $player['player_name'],
            'NO' => $player['player_no'],
          ] );
        }
  	}
  }

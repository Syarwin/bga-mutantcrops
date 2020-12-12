<?php
/**
 *------
 * BGA framework: © Gregory Isabelli <gisabelli@boardgamearena.com> & Emmanuel Colin <ecolin@boardgamearena.com>
 * MutantCrops implementation : © Timothée Pecatte <tim.pecatte@gmail.com>
 *
 * This code has been produced on the BGA studio platform for use on https://boardgamearena.com.
 * See http://en.doc.boardgamearena.com/Studio for more information.
 * -----
 *
 * mutantcrops.action.php
 *
 * MutantCrops main action entry point
 *
 *
 */


class action_mutantcrops extends APP_GameAction
{
  // Constructor: please do not modify
  public function __default()
  {
    if( self::isArg( 'notifwindow') ){
      $this->view = "common_notifwindow";
      $this->viewArgs['table'] = self::getArg( "table", AT_posint, true );
    } else {
      $this->view = "mutantcrops_mutantcrops";
      self::trace( "Complete reinitialization of board game" );
    }
  }


  public function assign()
  {
    self::setAjaxMode();
    $farmerId = (int) self::getArg('farmerId', AT_posint, true);
    $locationId = (int) self::getArg('locationId', AT_posint, true);
    $this->game->playerAssign($farmerId, $locationId);
    self::ajaxResponse();
  }

  public function sow()
  {
    self::setAjaxMode();
    $cropId = (int) self::getArg('cropId', AT_posint, true);
    $this->game->playerSow($cropId);
    self::ajaxResponse();
  }
}

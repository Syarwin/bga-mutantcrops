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
 * states.inc.php
 *
 * MutantCrops game states description
 *
 */



$machinestates = [
  /*
   * BGA framework initial state. Do not modify.
   */
  ST_GAME_SETUP => [
    'name' => 'gameSetup',
    'description' => '',
    'type' => 'manager',
    'action' => 'stGameSetup',
    'transitions' => [
      '' => ST_NEXT_PLAYER,
    ],
  ],


  ST_NEXT_PLAYER => [
    'name' => 'nextPlayer',
    'description' => '',
    'type' => 'game',
    'action' => 'stNextPlayer',
    'transitions' => [
      'next' => ST_NEXT_PLAYER,
      'start' => ST_START_OF_TURN,
      'endgame' => ST_GAME_END,
    ],
    'updateGameProgression' => true,
  ],

  ST_START_OF_TURN => [
    'name' => 'startOfTurn',
    'description' => '',
    'type' => 'game',
    'action' => 'stStartOfTurn',
    'transitions' => [
      'assign'  => ST_ASSIGN,
      'endgame' => ST_GAME_END,
    ],
  ],

  ST_ASSIGN => [
    'name' => 'playerAssign',
    'description' => clienttranslate('${actplayer} must assign a famer'),
    'descriptionmyturn' => clienttranslate('${you} must assign a farmer'),
    'type' => 'activeplayer',
    'args' => 'argPlayerAssign',
    'possibleactions' => ['assign', 'skip', 'endgame'],
    'transitions' => [
      'zombiePass' => ST_END_OF_TURN,
      'endturn'    => ST_END_OF_TURN,
      'endgame'    => ST_GAME_END,
      'farmerAssigned' => ST_END_OF_TURN,
      'sow' => ST_SOW,
    ],
  ],


  ST_SOW => [
    'name' => 'playerSow',
    'description' => clienttranslate('${actplayer} must sow a crop'),
    'descriptionmyturn' => clienttranslate('${you} must sow a crop'),
    'type' => 'activeplayer',
    'args' => 'argPlayerSow',
    'possibleactions' => ['sow'],
    'transitions' => [
      'zombiePass' => ST_END_OF_TURN,
      'endturn'    => ST_END_OF_TURN,
      'endgame'    => ST_GAME_END,
      'sowed'      => ST_END_OF_TURN,
    ],
  ],



  ST_END_OF_TURN => [
    'name' => 'endOfTurn',
    'description' => '',
    'type' => 'game',
    'action' => 'stEndOfTurn',
    'transitions' => [
      'next' => ST_NEXT_PLAYER,
      'endgame' => ST_GAME_END,
    ],
  ],

  /*
   * BGA framework final state. Do not modify.
   */
  ST_GAME_END => [
    'name' => 'gameEnd',
    'description' => clienttranslate('End of game'),
    'type' => 'manager',
    'action' => 'stGameEnd',
    'args' => 'argGameEnd'
  ]

];

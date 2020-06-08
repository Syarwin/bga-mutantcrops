<?php
/**
 *------
 * BGA framework: © Gregory Isabelli <gisabelli@boardgamearena.com> & Emmanuel Colin <ecolin@boardgamearena.com>
 * MutantCrops implementation : © <Your name here> <Your email address here>
 *
 * This code has been produced on the BGA studio platform for use on http://boardgamearena.com.
 * See http://en.boardgamearena.com/#!doc/Studio for more information.
 * -----
 *
 * material.inc.php
 *
 * MutantCrops game material description
 *
 * Here, you can describe the material of your game with PHP variables.
 *
 * This file is loaded in your game logic class constructor, ie these variables
 * are available everywhere in your game logic code.
 *
 */

$this->crops = [
  [
    'id' => 0,
    'name' => "Asparagus",
    'promo' => true,
    'number' => 1,
    'seeds' => 7,
    'power1Cost' => 7,
    'power1Effect' => 6,
    'power2Cost' => 5,
    'power2Effect' => 5,
    'power3Cost' => 2,
    'power3CostType' => 'F',
    'power3Effect' => clienttranslate('At the end of game, if you sowed at least 5 crops (Asparagus included) you get 5 COINS.')
  ],
  [
    'id' => 1,
    'name' => "Banana",
    'promo' => true,
    'number' => 2,
    'seeds' => 2,
    'power1Cost' => 2,
    'power1Effect' => 2,
    'power2Cost' => 1,
   'power2Effect' => 1,
   'power3Cost' => 2,
   'power3CostType' => 'F',
   'power3Effect' => clienttranslate('Search for a card in the deck and sow it paying it cost. Then rotate crops.')
  ],
  [
    'id' => 2,
    'name' => "Broccoli",
    'promo' => false,
    'number' => 2,
    'seeds' => 2,
    'power1Cost' => 1,
    'power1Effect' => 1,
    'power2Cost' => 3,
    'power2Effect' => 2,
    'power3Cost' => 2,
    'power3CostType' => 'F',
    'power3Effect' => clienttranslate('At the end of game, choose a plant another player has sowed and copy the ability.')
  ],
  [
    'id' => 3,
    'name' => "Chard",
    'promo' => false,
    'number' => 3,
    'seeds' => 1,
    'power1Cost' => 2,
    'power1Effect' => 2,
    'power2Cost' => 1,
    'power2Effect' => 1,
    'power3Cost' => 2,
    'power3CostType' => 'F',
    'power3Effect' => clienttranslate('At the end of game, gain 1 COINS for each of your Chard cards (including this one).')
  ],
  [
    'id' => 4,
    'name' => "Cranberry",
    'promo' => false,
    'number' => 1,
    'seeds' => 5,
    'power1Cost' => 5,
    'power1Effect' => 4,
    'power2Cost' => 4,
    'power2Effect' => 4,
    'power3Cost' => 2,
    'power3CostType' => 'F',
    'power3Effect' => clienttranslate('At the end of game, the Cranberry count as any other sowed crop you choose')
  ],
  [
    'id' => 5,
    'name' => "Cucumber",
    'promo' => false,
    'number' => 2,
    'seeds' => 2,
    'power1Cost' => 3,
    'power1Effect' => 2,
    'power2Cost' => 2,
    'power2Effect' => 2,
    'power3Cost' => 2,
    'power3CostType' => 'F',
    'power3Effect' => clienttranslate('At the end of game, if you sowed another Cucumber, you get 4 COINS.')
  ],
  [
    'id' => 6,
    'name' => "Eggplant",
    'promo' => false,
    'number' => 2,
    'seeds' => 2,
    'power1Cost' => 3,
    'power1Effect' => 2,
    'power2Cost' => 1,
    'power2Effect' => 1,
    'power3Cost' => 2,
    'power3CostType' => 'F',
    'power3Effect' => clienttranslate('Immediately sow a plant with cost 4 SEEDS or less, without paying the seeds.')
  ],
  [
    'id' => 7,
    'name' => "Melon",
    'promo' => false,
    'number' => 1,
    'seeds' => 6,
    'power1Cost' => 5,
    'power1Effect' => 5,
    'power2Cost' => 5,
    'power2Effect' => 5,
    'power3Cost' => 2,
    'power3CostType' => 'F',
    'power3Effect' => clienttranslate('At the end of game, if you have the most resource tokens in your personal supply, gain 4 COINS.')
  ],
  [
    'id' => 8,
    'name' => "Onion",
    'promo' => false,
    'number' => 3,
    'seeds' => 1,
    'power1Cost' => 1,
    'power1Effect' => 1,
    'power2Cost' => 2,
    'power2Effect' => 2,
    'power3Cost' => 2,
    'power3CostType' => 'F',
    'power3Effect' => clienttranslate('At the end of game, gain 1 COINS for each of your Onion cards (including this one).')
  ],
  [
    'id' => 9,
    'name' => "Orange",
    'promo' => true,
    'number' => 1,
    'seeds' => 3,
    'power1Cost' => 1,
    'power1Effect' => 1,
    'power2Cost' => 3,
    'power2Effect' => 2,
    'power3Cost' => 2,
    'power3CostType' => 'F',
    'power3Effect' => clienttranslate('At the end of game, the Orange count as any other sowed crop you choose.')
  ],
  [
    'id' => 10,
    'name' => "Pear",
    'promo' => false,
    'number' => 1,
    'seeds' => 3,
    'power1Cost' => 4,
    'power1Effect' => 3,
    'power2Cost' => 2,
    'power2Effect' => 2,
    'power3Cost' => 2,
    'power3CostType' => 'F',
    'power3Effect' => clienttranslate('Search for a plant and sow it without paying his SEEDS cost. Rotate crops after that.')
  ],
  [
    'id' => 11,
    'name' => "Peach",
    'promo' => false,
    'number' => 1,
    'seeds' => 3,
    'power1Cost' => 5,
    'power1Effect' => 4,
    'power2Cost' => 1,
    'power2Effect' => 1,
    'power3Cost' => 2,
    'power3CostType' => 'F',
    'power3Effect' => clienttranslate('At the end of game, if you sowed a Pear, you get 3 COINS. If you sowed a Strawberry, get 4 COINS.')
  ],
  [
    'id' => 12,
    'name' => "Pepper",
    'promo' => false,
    'number' => 1,
    'seeds' => 3,
    'power1Cost' => 1,
    'power1Effect' => 1,
    'power2Cost' => 5,
    'power2Effect' => 4,
    'power3Cost' => 2,
    'power3CostType' => 'F',
    'power3Effect' => clienttranslate('At the end of game, gain 2 COINS for every 3 FOODS remaining in your personal supply.')
  ],
  [
    'id' => 13,
    'name' => "Potato",
    'promo' => true,
    'number' => 1,
    'seeds' => 4,
    'power1Cost' => 2,
    'power1Effect' => 2,
    'power2Cost' => 5,
    'power2Effect' => 4,
    'power3Cost' => 2,
    'power3CostType' => 'F',
    'power3Effect' => clienttranslate('At the end of game, if you sowed an Eggplan, you get 4 COINS.')
  ],
  [
    'id' => 14,
    'name' => "Pumpkin",
    'promo' => false,
    'number' => 1,
    'seeds' => 3,
    'power1Cost' => 2,
    'power1Effect' => 2,
    'power2Cost' => 4,
    'power2Effect' => 3,
    'power3Cost' => 2,
    'power3CostType' => 'F',
    'power3Effect' => clienttranslate('If at the end of game, you have sowed at least 1 Chard and 1 Onion, gain 5 COINS.')
  ],
  [
    'id' => 15,
    'name' => "Strawberry",
    'promo' => false,
    'number' => 1,
    'seeds' => 4,
    'power1Cost' => 3,
    'power1Effect' => 3,
    'power2Cost' => 5,
    'power2Effect' => 4,
    'power3Cost' => 2,
    'power3CostType' => 'F',
    'power3Effect' => clienttranslate('At the end of game, gain 2 COINS for every 3 WATERS remaining in your personal supply.')
  ],
];



$this->fields = [
  [
    'id' => 0,
    'stage' => 1,
    'top' => [
      'type' => 'A',
      'effect' => "",
    ],
    'bottom' => [
      'type' => 'B',
      'effect' => clienttranslate("SOW"),
    ]
  ],
  [
    'id' => 1,
    'stage' => 1,
    'top' => [
      'type' => 'A',
      'effect' => "",
    ],
    'bottom' => [
      'type' => 'C',
      'effect' => "",
    ]
  ],
  [
    'id' => 2,
    'stage' => 1,
    'top' => [
      'type' => 'A',
      'effect' => "",
    ],
    'bottom' => [
      'type' => 'D',
      'effect' => "",
    ]
  ],
  [
    'id' => 3,
    'stage' => 1,
    'top' => [
      'type' => 'A',
      'effect' => "",
    ],
    'bottom' => [
      'type' => 'E',
      'effect' => "",
    ]
  ],
  [
    'id' => 4,
    'stage' => 1,
    'top' => [
      'type' => 'A',
      'effect' => "",
    ],
    'bottom' => [
      'type' => 'F',
      'effect' => clienttranslate("& First Player"),
    ]
  ],
  [
    'id' => 5,
    'stage' => 1,
    'top' => [
      'type' => 'A',
      'effect' => "",
    ],
    'bottom' => [
      'type' => 'G',
      'effect' => clienttranslate("& Dual Actions"),
    ]
  ],


  [
    'id' => 6,
    'stage' => 2,
    'top' => [
      'type' => 'H',
      'effect' => "",
    ],
    'bottom' => [
      'type' => 'I',
      'effect' => clienttranslate("WATER"),
    ]
  ],
  [
    'id' => 7,
    'stage' => 2,
    'top' => [
      'type' => 'H',
      'effect' => clienttranslate("WATER"),
    ],
    'bottom' => [
      'type' => 'I',
      'effect' => "",
    ]
  ],
  [
    'id' => 8,
    'stage' => 2,
    'top' => [
      'type' => 'H',
      'effect' => clienttranslate("SOW x2"),
    ],
    'bottom' => [
      'type' => 'I',
      'effect' => clienttranslate("FEED"),
    ]
  ],


  [
    'id' => 9,
    'stage' => 3,
    'top' => [
      'type' => 'J',
      'effect' => "",
    ],
    'bottom' => [
      'type' => 'K',
      'effect' => clienttranslate("WATER"),
    ]
  ],
  [
    'id' => 10,
    'stage' => 3,
    'top' => [
      'type' => 'L',
      'effect' => clienttranslate("Water & Fedd"),
    ],
    'bottom' => [
      'type' => 'M',
      'effect' => clienttranslate("& Dual Action")
    ]
  ],
  [
    'id' => 11,
    'stage' => 3,
    'top' => [
      'type' => 'N',
      'effect' => clienttranslate("SOW x2"),
    ],
    'bottom' => [
      'type' => 'O',
      'effect' => clienttranslate("Exchange"),
    ]
  ],


  [
    'id' => 12,
    'stage' => 3,
    'top' => [
      'type' => 'W',
      'effect' => "",
    ],
    'bottom' => [
      'type' => 'V',
      'effect' => "",
    ]
  ],
  [
    'id' => 13,
    'stage' => 3,
    'top' => [
      'type' => 'W',
      'effect' => "",
    ],
    'bottom' => [
      'type' => 'X',
      'effect' => "",
    ]
  ],
  [
    'id' => 14,
    'stage' => 3,
    'top' => [
      'type' => 'Y',
      'effect' => "",
    ],
    'bottom' => [
      'type' => 'Z',
      'effect' => "",
    ]
  ],

];

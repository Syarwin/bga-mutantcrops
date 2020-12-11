
-- ------
-- BGA framework: © Gregory Isabelli <gisabelli@boardgamearena.com> & Emmanuel Colin <ecolin@boardgamearena.com>
-- MutantCrops implementation : © Timothée Pecatte <tim.pecatte@gmail.com>
--
-- This code has been produced on the BGA studio platform for use on http://boardgamearena.com.
-- See http://en.boardgamearena.com/#!doc/Studio for more information.
-- -----

-- dbmodel.sql

-- This is the file where you are describing the database schema of your game
-- Basically, you just have to export from PhpMyAdmin your table structure and copy/paste
-- this export here.
-- Note that the database itself and the standard tables ("global", "stats", "gamelog" and "player") are
-- already created and must not be created here

-- Note: The database schema is created from this file when the game starts. If you modify this file,
--       you have to restart a game to see your changes in database.

-- Example 1: create a standard "card" table to be used with the "Deck" tools (see example game "hearts"):

-- CREATE TABLE IF NOT EXISTS `card` (
--   `card_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
--   `card_type` varchar(16) NOT NULL,
--   `card_type_arg` int(11) NOT NULL,
--   `card_location` varchar(16) NOT NULL,
--   `card_location_arg` int(11) NOT NULL,
--   PRIMARY KEY (`card_id`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- Example 2: add a custom field to the standard "player" table
-- ALTER TABLE `player` ADD `player_my_custom_field` INT UNSIGNED NOT NULL DEFAULT '0';

CREATE TABLE IF NOT EXISTS `crops` (
  `crop_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `crop_location` varchar(32) NOT NULL,
  `crop_state` int(10),
  `type` int(10),
  `water` int(2),
  `food` int(2),
  `special` int(2),
  PRIMARY KEY (`crop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `fields` (
  `field_id` int(10) unsigned NOT NULL,
  `field_location` varchar(32) NOT NULL,
  `field_state` int(10),
  PRIMARY KEY (`field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `round` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `action` varchar(16) NOT NULL,
  `card_id` int(11),
  `action_arg` json,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


ALTER TABLE `player` ADD `farmer_0` INT(10) UNSIGNED, ADD `farmer_1` INT(10) UNSIGNED, ADD `farmer_2` INT(10) UNSIGNED;
ALTER TABLE `player` ADD `coins` INT(10) UNSIGNED NOT NULL, ADD `seeds` INT(10) UNSIGNED NOT NULL,  ADD `water` INT(10) UNSIGNED NOT NULL, ADD `food` INT(10) UNSIGNED NOT NULL;

/**
 *------
 * BGA framework: © Gregory Isabelli <gisabelli@boardgamearena.com> & Emmanuel Colin <ecolin@boardgamearena.com>
 * MutantCrops implementation : © Timothée Pecatte <tim.pecatte@gmail.com>
 *
 * This code has been produced on the BGA studio platform for use on http://boardgamearena.com.
 * See http://en.boardgamearena.com/#!doc/Studio for more information.
 * -----
 *
 * mutantcrops.js
 *
 * MutantCrops user interface script
 *
 * In this file, you are describing the logic of your user interface, in Javascript language.
 *
 */

var isDebug = true;
var debug = isDebug ? console.info.bind(window.console) : function () { };
define([
  "dojo", "dojo/_base/declare", "ebg/counter",
  g_gamethemeurl + "modules/js/Game/game.js",
  g_gamethemeurl + "modules/js/Game/modal.js",

  g_gamethemeurl + "modules/js/PlayerTrait.js",
  g_gamethemeurl + "modules/js/States/AssignTrait.js",
  g_gamethemeurl + "modules/js/States/SowTrait.js",
  g_gamethemeurl + "modules/js/States/WaterFeedTrait.js",
], function (dojo, declare) {
  return declare("bgagame.mutantcrops", [
    customgame.game,
    mutantcrops.playerTrait,
    mutantcrops.sowTrait,
    mutantcrops.assignTrait,
    mutantcrops.waterFeedTrait,
  ], {
    /*
     * Constructor
     */
    constructor() {
      this._notifications.push(
        ['newField', 10]
      );

      // States that need the player to be active to be entered
      this._activeStates = ["playerAssign"];
    },

    /*
     * Setup:
     *  This method set up the game user interface according to current game situation specified in parameters
     *  The method is called each time the game interface is displayed to a player, ie: when the game starts and when a player refreshes the game page (F5)
     *
     * Params :
     *  - mixed gamedatas : contains all datas retrieved by the getAllDatas PHP method.
     */
    setup(gamedatas) {
      debug('SETUP', gamedatas);

      // Display fields (only the ones visible at that stage)
      gamedatas.fields.forEach(this.showField);

      this.setupPlayers();

      // Display crops
      gamedatas.crops.forEach((crop, index) => this.addCrop(crop, index, 'mutantcrops-grid') );

      this.inherited(arguments);
   },
onUpdateActionButtons(){
  this.addPrimaryActionButton("test", "Coucou", () => this.notif_growCrop(
    {
  "uid": "5fd7f0f910945",
  "type": "growCrop",
  "log": "${player_name} spends ${n} ${resource_name} to grow ${crop_name} and earns ${m} coins",
  "args": {
    "i18n": [
      "crop_name",
      "resource_name"
    ],
    "player_name": "<!--PNS--><span class=\"playername\"><!--PNS--><span class=\"playername\" style=\"color:#0000ff;\">Tisaac0</span><!--PNE--></span><!--PNE-->",
    "playerId": 2322021,
    "crop_name": "Orange",
    "crop": {
      "id": "18",
      "type": 9,
      "water": false,
      "food": false,
      "special": false
    },
    "resource_name": "water",
    "type":"water",
    "n": 1,
    "total": 6,
    "m": 1,
    "totalCoins": 1
  },
  "h": "04b910",
  "channelorig": "/table/t211097",
  "gamenameorig": "mutantcrops",
  "time": 1607987449,
  "move_id": 3,
  "bIsTableMsg": true,
  "table_id": "211097"
}) );
},

     addCrop(crop, index, container){
       var data = this.gamedatas.cropsData[crop.type];
       data.id = crop.id;
       data.index = index;
       data.power3Effect = data.power3Effect.replace("COINS",  "<span class='coin'></span>");
       data.power3Effect = data.power3Effect.replace("WATERS", "<span class='water'></span>");
       data.power3Effect = data.power3Effect.replace("FOODS",  "<span class='food'></span>");
       data.power3Effect = data.power3Effect.replace("SEEDS",  "<span class='seed'></span>");
       data.water = crop.water? 1 : 0;
       data.food = crop.food? 1 : 0;
       data.special = crop.special? 1 : 0;
       dojo.place( this.format_block( 'jstpl_crop', data), container);
       this.addTooltipHtml('crop-' + index, this.format_block( 'jstpl_crop', data), 0);
     },

     /*
      * notif_newField: TODO
      */
     notif_newField(n) {
       debug('Notif: new field available', n.args);
       this.showField(n.args.fieldId, n.args.index);
     },

     showField(field, index){
       dojo.addClass('field-' + index, 'field-active field-' + field.id);
       dojo.query('#field-' + index + ' div').forEach((location, id) => {
         location.id = "location-" + parseInt(2*field.id + id);
       });
     },




     /*
      * clearPossible:
      * 	clear every clickable space and any selected worker
      */
     clearPossible() {
       this._selectedFarmer = null;
       this._selectableCrops = [];
       this._selectableFarmers = [];

       dojo.query(".meeple").removeClass("selectable selected");
       dojo.query(".field > div").removeClass("selectable");
       dojo.query(".crop").removeClass("selectable");
       dojo.query(".crop .crop-power-box").removeClass("selectable");

       this.inherited(arguments);
     },

   });
});

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
], function (dojo, declare) {
  return declare("bgagame.mutantcrops", [
    customgame.game,
    mutantcrops.playerTrait,
    mutantcrops.sowTrait,
    mutantcrops.assignTrait,
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


     addCrop(crop, index, container){
       var data = this.gamedatas.cropsData[crop.type];
       data.id = crop.id;
       data.index = index;
       data.power3Effect = data.power3Effect.replace("COINS",  "<span class='coin'></span>");
       data.power3Effect = data.power3Effect.replace("WATERS", "<span class='water'></span>");
       data.power3Effect = data.power3Effect.replace("FOODS",  "<span class='food'></span>");
       data.power3Effect = data.power3Effect.replace("SEEDS",  "<span class='seed'></span>");
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
       this.inherited(arguments);
     },

   });
});

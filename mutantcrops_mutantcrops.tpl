{OVERALL_GAME_HEADER}

<div id="board">
  <div id="mutantcrops-grid">
    <div id="crops-deck"></div>

    <div id="field-0" class="field stage-1"><div id="location-0"></div><div id="location-1"></div></div>
    <div id="field-1" class="field stage-1"><div id="location-2"></div><div id="location-3"></div>></div>
    <div id="field-2" class="field stage-1"><div id="location-4"></div><div id="location-5"></div></div>
    <div id="field-3" class="field stage-1"><div id="location-6"></div><div id="location-7"></div></div>
    <div id="field-4" class="field stage-1"><div id="location-8"></div><div id="location-9"></div></div>
    <div id="field-5" class="field stage-1"><div id="location-10"></div><div id="location-11"></div></div>

    <div id="field-6" class="field stage-2"><div id="location-12"></div><div id="location-13"></div></div>
    <div id="field-7" class="field stage-2"><div id="location-14"></div><div id="location-15"></div></div>
    <div id="field-8" class="field stage-2"><div id="location-16"></div><div id="location-17"></div></div>

    <div id="field-9" class="field stage-3"><div id="location-18"></div><div id="location-19"></div></div>
    <div id="field-10" class="field stage-3"><div id="location-20"></div><div id="location-21"></div>></div>
    <div id="field-11" class="field stage-3"><div id="location-22"></div><div id="location-23"></div></div>
  </div>
</div>

<script type="text/javascript">

var jstpl_player_panel = `<div class="player-panel player-\${no}">
  <div class='farmer-card'></div>
  <div class='tokens-container' id='tokens-container-\${id}'>
    <div class='token token-coins'>x\${coins}</div>
    <div class='token token-water'>x\${water}</div>
    <div class='token token-seeds'>x\${seeds}</div>
    <div class='token token-food'>x\${food}</div>
  </div>
</div>`;
var jstpl_player_meeple = `<div class="meeple meeple-\${no}" id="meeple-\${playerId}-\${farmerId}" data-farmerId="\${farmerId}"><svg version="1.1" viewBox="0 0 109.17 112.48">
<path class="st0" d="M97.97,28.87v16.28c-3.77-2.31-7.86-3.98-12.02-5.47c-3.63-1.3-7.29-2.52-10.95-3.72
	c-0.94-0.31-1.2-0.86-1.28-1.77c-0.22-2.4-0.43-4.82-0.87-7.18c-0.08-0.44-0.18-0.87-0.29-1.3h9.23c2.89,0,5.24-2.34,5.24-5.23
	c0-2.89-2.34-5.23-5.24-5.23h-8.18l-1.28-7.49C71.55,3.27,67.68,0,63.14,0H53.1c-4.54,0-8.41,3.27-9.17,7.74l-1.28,7.49h-8.18
	c-2.89,0-5.24,2.34-5.24,5.23c0,2.89,2.34,5.23,5.24,5.23h9.25c-0.78,2.67-1.07,5.41-1.2,8.18c-0.07,1.6-0.05,1.64-1.57,2.16
	c-3.03,1.04-6.09,2-9.11,3.07c-4.75,1.67-9.43,3.53-13.76,6.15c-2.43,1.47-4.7,3.13-6.47,5.39c-1.18,1.5-2,3.15-2.19,5.07
	c-0.01,0.14-0.06,0.27-0.09,0.41v1.1c0.06,0.38,0.12,0.75,0.18,1.13c0.56,3.08,1.95,5.12,4.44,6.19v7.95H0l4.07,24.1h12.98
	c-1.18,2.59-2.18,5.26-2.88,8.04c-0.4,1.62-0.75,3.25-0.6,4.94c0.14,1.63,0.93,2.43,2.56,2.68c0.5,0.08,1,0.15,1.5,0.23h24.39
	c0.32-0.06,0.63-0.12,0.94-0.18c1.68-0.33,2.81-1.43,3.67-2.8c2.18-3.5,4.29-7.04,6.5-10.52c0.95-1.51,1.98-2.98,3.13-4.34
	c1.39-1.65,2.33-1.65,3.72,0c1.15,1.36,2.18,2.84,3.13,4.34c2.2,3.48,4.31,7.03,6.5,10.52c0.86,1.38,1.99,2.47,3.67,2.8
	c0.31,0.06,0.63,0.12,0.94,0.18h23.75h0.65h5.69c2.68,0,4.86-2.18,4.86-4.86V28.87H97.97z M23.18,65.82
	c0.21,0.01,0.43,0.03,0.64,0.05c1.52,0.12,3.03,0.25,4.55,0.38c0.1,0.01,0.2,0.04,0.3,0.06c2.07,0.52,2.69,1.53,2.12,3.58
	c-0.25,0.9-0.57,1.76-0.93,2.61h-6.67V65.82z M96,90.24c-2.55-4.74-5.25-9.4-7.79-14.14c-1.04-1.94-1.95-3.98-2.68-6.06
	c-0.8-2.26-0.03-3.49,2.34-3.77c2.53-0.31,5.1-0.36,7.65-0.51c0.82-0.05,1.63-0.1,2.44-0.19v28.46C97.34,92.75,96.68,91.5,96,90.24"
	/>
</svg></div>`;


var jstpl_crop = `<div class="crop crop-\${id}" id="crop-\${index}">
  <div class="crop-background"></div>
  <div class="crop-frame"></div>
  <div class="crop-seeds">\${seeds}</div>
  <div class="crop-name">\${name}</div>
  <div class="crop-power-cost power-1">\${power1Cost}</div>
  <div class="crop-power-gain power-1">+\${power1Effect}</div>
  <div class="crop-power-cost power-2">\${power2Cost}</div>
  <div class="crop-power-gain power-2">+\${power2Effect}</div>

  <div class="crop-power-cost power-3">\${power3Cost}</div>
  <div class="crop-power-cost-type type-\${power3CostType}"></div>
  <div class="crop-power-effect">\${power3Effect}</div>
</div>`;
</script>
{OVERALL_GAME_FOOTER}

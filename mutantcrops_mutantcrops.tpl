{OVERALL_GAME_HEADER}

<div id="board">
  <div id="mutantcrops-grid">
    <div id="crops-deck"></div>
  </div>
</div>

<script type="text/javascript">

var jstpl_crop=`<div class="crop crop-\${id}">
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

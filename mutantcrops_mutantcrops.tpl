{OVERALL_GAME_HEADER}

<div id="board">
  <div id="mutantcrops-grid">
    <div id="crops-deck"></div>

    <div id="field-0" class="field stage-1"><div></div><div></div></div>
    <div id="field-1" class="field stage-1"><div></div><div></div></div>
    <div id="field-2" class="field stage-1"><div></div><div></div></div>
    <div id="field-3" class="field stage-1"><div></div><div></div></div>
    <div id="field-4" class="field stage-1"><div></div><div></div></div>
    <div id="field-5" class="field stage-1"><div></div><div></div></div>

    <div id="field-6" class="field stage-2"></div>
    <div id="field-7" class="field stage-2"></div>
    <div id="field-8" class="field stage-2"></div>

    <div id="field-9" class="field stage-3"></div>
    <div id="field-10" class="field stage-3"></div>
    <div id="field-11" class="field stage-3"></div>
  </div>
</div>

<script type="text/javascript">

var jstpl_crop=`<div class="crop crop-\${id}" id="crop-\${index}">
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

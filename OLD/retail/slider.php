<?php
include('../topBar.php');

?>
<style>
input[type="range"]{
    -webkit-appearance: none;
    -moz-apperance: none;
    border-radius: 6px;
    height: 6px;
    background-image: -webkit-gradient(
        linear,
        left top,
        right top,
        color-stop(0.49, #94A14E),
        color-stop(0.50, #C5C5C5)
    );
}

input[type='range']::-webkit-slider-thumb {
    -webkit-appearance: none !important;
    background-image: url(/images/slider_icon3.png);
   border:0px solid white;
    height: 60px;
    width: 60px;
}
</style>
<script>
$( document ).ready(function() {

$('input[type="range"]').change(function () {

    var val = ($(this).val() - $(this).attr('min')) / ($(this).attr('max') - $(this).attr('min'));
    
    $(this).css('background-image',
                '-webkit-gradient(linear, left top, right top, '
                + 'color-stop(' + val + ', #94A14E), '
                + 'color-stop(' + val + ', #C5C5C5)'
                + ')'
                );
        $("#result").text(val);
});
});
</script>

<div class="container">
	<br><br>
	<input type="range" min="1" max="100" step="1" value="50">
	<br><br>
	<div id="result"></div>
</div>
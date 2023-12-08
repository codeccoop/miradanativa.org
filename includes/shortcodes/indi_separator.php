<?php
add_shortcode('indi_separator', function () {
    ob_start();
?>
    <div class="indi_separator">
        <div id="block-1" class="indi_content_column"></div>
        <div id="block-2" class="indi_content_column">
            <img src="https://www.miradanativa.org/wp-content/uploads/2021/04/ninot_blanco_72.png" class="indi_centered">
        </div>
        <div id="block-3" class="indi_content_column"></div>
    </div>
<?php
    $out = ob_get_clean();
    return $out;
});

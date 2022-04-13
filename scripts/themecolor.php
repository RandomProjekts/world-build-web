<?php
include_once(__DIR__ . "/colorextract.php");

// used for ligtening up color
function luminance($hexcolor, $percent)
{
    if (strlen($hexcolor) < 6) {
        $hexcolor = $hexcolor[0] . $hexcolor[0] . $hexcolor[1] . $hexcolor[1] . $hexcolor[2] . $hexcolor[2];
    }
    $hexcolor = array_map('hexdec', str_split(str_pad(str_replace('#', '', $hexcolor), 6, '0'), 2));

    foreach ($hexcolor as $i => $color) {
        $from = $percent < 0 ? 0 : $color;
        $to = $percent < 0 ? $color : 255;
        $pvalue = ceil(($to - $from) * $percent);
        $hexcolor[$i] = str_pad(dechex($color + $pvalue), 2, '0', STR_PAD_LEFT);
    }

    return '#' . implode($hexcolor);
}

function findthemecolor($imgfile)
{
    $ex = new GetMostCommonColors();
    $colors = $ex->Get_Color($imgfile, 4, true, true, 24);
    // find most colorful color
    $best = -1;
    foreach (array_keys($colors) as $c) {
        $crgb = array(hexdec(substr($c, 0, 1)), hexdec(substr($c, 2, 1)), hexdec(substr($c, 4, 1)));
        $crp = $crgb[0] / 255;
        $cgp = $crgb[1] / 255;
        $cbp = $crgb[2] / 255;
        # saturation of color
        if (max($crp, $cgp, $cbp)) {
            $S = (max($crp, $cgp, $cbp) - min($crp, $cgp, $cbp)) / max($crp, $cgp, $cbp);
        } else {
            $S = 0;
        }
        $cL = (max($crp, $cgp, $cbp) - min($crp, $cgp, $cbp)) / 2; // lightness of color
        if ($S * $cL > $best) {
            $best = $S * $cL;
            $rgb = $crgb;
            $hex = $c;
            $rp = $crp;
            $gp = $cgp;
            $bp = $cbp;
            $L = $cL;
        }
    }
    // if color is too dark, lighten it up, if too light, darken
    $themecolor = luminance($hex, 0.8 - $L);
    return $themecolor;
}

function adjustlightness($hex)
{
    $rgb = array(hexdec(substr($hex, 0, 1)), hexdec(substr($hex, 2, 1)), hexdec(substr($hex, 4, 1)));
    $rp = $rgb[0] / 255;
    $gp = $rgb[1] / 255;
    $bp = $rgb[2] / 255;
    $L = (max($rp, $gp, $bp) - min($rp, $gp, $bp)) / 2; // lightness of color
    $themecolor = luminance($hex, 0.8 - $L);
    return $themecolor;
}

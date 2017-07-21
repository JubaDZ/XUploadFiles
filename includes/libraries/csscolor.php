<?php
/*
 csscolor.php
 Copyright 2004 Patrick Fitzgerald
 http://www.barelyfitz.com/projects/csscolor/
*/
define('CSS_COLOR_ERROR', 100);

class Csscolor {
  var $bg = array();
  var $fg = array();
  var $minBrightDiff = 126;
  var $minColorDiff = 500;
  public static function make($bgHex= '', $fgHex='') 
  {
    return new self($bgHex, $fgHex);
  }

  public function __construct($bgHex='', $fgHex='') {
    $this->setPalette($bgHex, $fgHex);
  }

  function setPalette($bgHex='', $fgHex = '')
  {

    if (!$fgHex) {
      $fgHex = $bgHex;
    }

    $this->bg = array();
    $this->fg = array();

    if (!$this->isHex($bgHex)) {
      $this->raiseError("background color '$bgHex' is not a hex color value",'FUNCTION', "LINE");
      return false;
    }

    $this->bg[0] = $bgHex;

    $this->bg['+1'] = $this->lighten($bgHex, .85);
    $this->bg['+2'] = $this->lighten($bgHex, .75);
    $this->bg['+3'] = $this->lighten($bgHex, .5);
    $this->bg['+4'] = $this->lighten($bgHex, .25);
    $this->bg['+5'] = $this->lighten($bgHex, .1);

    $this->bg['-1'] = $this->darken($bgHex, .85);
    $this->bg['-2'] = $this->darken($bgHex, .75);
    $this->bg['-3'] = $this->darken($bgHex, .5);
    $this->bg['-4'] = $this->darken($bgHex, .25);
    $this->bg['-5'] = $this->darken($bgHex, .1);

    if (!$this->isHex($fgHex)) {
      $this->raiseError("background color '$bgHex' is not a hex color value",'FUNCTION', "LINE");
      return false;
    }

    $this->fg[0]    = $this->calcFG( $this->bg[0], $fgHex);
    $this->fg['+1'] = $this->calcFG( $this->bg['+1'], $fgHex);
    $this->fg['+2'] = $this->calcFG( $this->bg['+2'], $fgHex);
    $this->fg['+3'] = $this->calcFG( $this->bg['+3'], $fgHex);
    $this->fg['+4'] = $this->calcFG( $this->bg['+4'], $fgHex);
    $this->fg['+5'] = $this->calcFG( $this->bg['+5'], $fgHex);
    $this->fg['-1'] = $this->calcFG( $this->bg['-1'], $fgHex);
    $this->fg['-2'] = $this->calcFG( $this->bg['-2'], $fgHex);
    $this->fg['-3'] = $this->calcFG( $this->bg['-3'], $fgHex);
    $this->fg['-4'] = $this->calcFG( $this->bg['-4'], $fgHex);
    $this->fg['-5'] = $this->calcFG( $this->bg['-5'], $fgHex);
  }

  function lighten($hex, $percent)
  {
    return $this->mix($hex, $percent, 255);
  }

  function darken($hex, $percent)
  {
    return $this->mix($hex, $percent, 0);
  }

  function mix($hex, $percent, $mask)
  {
    if (!is_numeric($percent) || $percent < 0 || $percent > 1) {
      $this->raiseError("percent=$percent is not valid",
			'FUNCTION', "LINE");
      return false;
    }

    if (!is_int($mask) || $mask < 0 || $mask > 255) {
      $this->raiseError("mask=$mask is not valid", 'FUNCTION', "LINE");
      return false;
    }

    $rgb = $this->hex2RGB($hex);
    if (!is_array($rgb)) {
      return false;
    }

    for ($i=0; $i<3; $i++) {
      $rgb[$i] = round($rgb[$i] * $percent) + round($mask * (1-$percent));

      if ($rgb[$i] > 255) {
	$rgb[$i] = 255;
      }

    }
    return $this->RGB2Hex($rgb);
  }

  function hex2RGB($hex)
  {
    $d = '[a-fA-F0-9]';

    if (preg_match("/^($d$d)($d$d)($d$d)\$/", $hex, $rgb)) {

      return array(
		   hexdec($rgb[1]),
		   hexdec($rgb[2]),
		   hexdec($rgb[3])
		   );
    }
    if (preg_match("/^($d)($d)($d)$/", $hex, $rgb)) {

      return array(
		   hexdec($rgb[1] . $rgb[1]),
		   hexdec($rgb[2] . $rgb[2]),
		   hexdec($rgb[3] . $rgb[3])
		   );
    }

    $this->raiseError("cannot convert hex '$hex' to RGB", 'FUNCTION', "LINE");
    return false;
  }


  function RGB2Hex($rgb)
  {
    if(!$this->isRGB($rgb)) {
      $this->raiseError("RGB value is not valid", 'FUNCTION', "LINE");
      return false;
    }

    $hex = "";
    for($i=0; $i < 3; $i++) {

      $hexDigit = dechex($rgb[$i]);

      if(strlen($hexDigit) == 1) {
		$hexDigit = "0" . $hexDigit;
      }

      $hex .= $hexDigit;
    }

    return $hex;
  }

  function isHex($hex)
  {

    $d = '[a-fA-F0-9]';
    if (preg_match("/^#?$d$d$d$d$d$d\$/", $hex) ||
	preg_match("/^#?$d$d$d\$/", $hex)) {
      return true;
    }
    return false;
  }

  function isRGB($rgb)
  {

    if (!is_array($rgb) || count($rgb) != 3) {
      return false;
    }

    for($i=0; $i < 3; $i++) {

      $dec = intval($rgb[$i]);

      if (!is_int($dec) || $dec < 0 || $dec > 255) {
	return false;
      }
    }

    return true;
  }

  function calcFG($bgHex, $fgHex)
  {

    foreach (array(1, 0.75, 0.5, 0.25, 0) as $percent) {

      $darker = $this->darken($fgHex, $percent);
      $lighter = $this->lighten($fgHex, $percent);

      $darkerBrightDiff  = $this->brightnessDiff($bgHex, $darker);
      $lighterBrightDiff = $this->brightnessDiff($bgHex, $lighter);

      if ($lighterBrightDiff > $darkerBrightDiff) {
	$newFG = $lighter;
	$newFGBrightDiff = $lighterBrightDiff;
      } else {
	$newFG = $darker;
	$newFGBrightDiff = $darkerBrightDiff;
      }
      $newFGColorDiff = $this->colorDiff($bgHex, $newFG);

      if ($newFGBrightDiff >= $this->minBrightDiff &&
	  $newFGColorDiff >= $this->minColorDiff) {
	break;
      }
    }

    return $newFG;
  }

  function getMinBrightDiff()
  {
    return $this->minBrightDiff;
  }
  function setMinBrightDiff($b, $resetPalette = true)
  {
    $this->minBrightDiff = $b;
    if ($resetPalette) {
      $this->setPalette($this->bg[0],$this->fg[0]);
    }
  }

  function getMinColorDiff()
  {
    return $this->minColorDiff;
  }
  function setMinColorDiff($d, $resetPalette = true)
  {
    $this->minColorDiff = $d;
    if ($resetPalette) {
      $this->setPalette($this->bg[0],$this->fg[0]);
    }
  }

  function brightness($hex)
  {

    $rgb = $this->hex2RGB($hex);
    if (!is_array($rgb)) {
      return false;
    }

    return( (($rgb[0] * 299) + ($rgb[1] * 587) + ($rgb[2] * 114)) / 1000 );
  }

  function brightnessDiff($hex1, $hex2)
  {

    $b1 = $this->brightness($hex1);
    $b2 = $this->brightness($hex2);
    if (is_bool($b1) || is_bool($b2)) {
      return false;
    }
    return abs($b1 - $b2);
  }

  function colorDiff($hex1, $hex2)
  {

    $rgb1 = $this->hex2RGB($hex1);
    $rgb2 = $this->hex2RGB($hex2);

    if (!is_array($rgb1) || !is_array($rgb2)) {
      return -1;
    }

    $r1 = $rgb1[0];
    $g1 = $rgb1[1];
    $b1 = $rgb1[2];

    $r2 = $rgb2[0];
    $g2 = $rgb2[1];
    $b2 = $rgb2[2];

    return(abs($r1-$r2) + abs($g1-$g2) + abs($b1-$b2));
  }


  function raiseError($message, $method, $line) {
  	return;
  }

}

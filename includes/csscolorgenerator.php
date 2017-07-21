<?php
require_once ('libraries/csscolor.php');

$base = new Csscolor(substr(CodeColor, 1, 6));
define('CodeColorBorder', $base->bg['+2']);

$base = new Csscolor(substr(BodyColor, 1, 6));
define('WellColor', $base->bg['+4']);

$base = new Csscolor(substr(PanelColor, 1, 6));
define('PanelColorBorder', $base->bg['+2']);
?>
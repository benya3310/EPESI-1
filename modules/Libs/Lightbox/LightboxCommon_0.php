<?php
defined("_VALID_ACCESS") || die('Direct access forbidden');

Base_ThemeCommon::load_css('Libs/Lightbox','default',false);
eval_js_once('wait_while_null(\'Prototype\',\'load_js(\\\'modules/Libs/Lightbox/2.03.3/lightbox.js\\\')\')');
eval_js('wait_while_null(\'myLightbox\',\'myLightbox.updateImageList()\')');

?>
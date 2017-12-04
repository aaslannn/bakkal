<?php
/**
* Language file for general strings
*
*/

use App\Translation;
$translates = Translation::lists('lang_es', 'slug')->toArray();
return $translates;

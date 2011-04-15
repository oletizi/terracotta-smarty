<?php

// put full path to Smarty.class.php
include_once "library/Smarty/Smarty.class.php";
include_once "library/simplehtmldom/simple_html_dom.php";
$smarty = new Smarty();

$smarty->setTemplateDir('templates');
$smarty->setCompileDir('templates_c');
$smarty->setCacheDir('cache');
$smarty->setConfigDir('configs');

$id = (isset($_GET["id"])) ? trim($_GET["id"]) : "index";
$file = "content/{$id}.html";

// default template.
$template = "index.tpl";

if (file_exists($file)) {
  $content = file_get_html($file);
  $my_template = $content->find('[id=template]');
  if ($my_template) {
    $template = $my_template[0]->innertext;
  } else {
    // TODO: Error handling
    echo "MY TEMPLATE IS UNDEFINED<br/>";
  }
  $chunks = $content->find('[id^=tpl_]');
  foreach ($chunks as $chunk) {    
    $smarty->assign($chunk->id, $chunk->innertext);
  }
  // TODO: Error handling
} else {
  // TODO: handle missing content file.
}

$smarty->display($template);

?>

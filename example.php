require_once("class_translate.php");

$var = new translate("en","it");

echo $var->get("hello mister");
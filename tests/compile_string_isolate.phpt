--TEST--
Test V8::compileString() : Check compiled script isolate processing
--SKIPIF--
<?php require_once(dirname(__FILE__) . '/skipif.inc'); ?>
--FILE--
<?php 

$js = <<<'EOT'
var a = { 'hello' : 'world' }; a;
EOT;

$js2 = <<<'EOT'
var a = { 'foo' : 'bar' }; a;
EOT;

$v8 = new V8Js();
$v8two = new V8Js();

try {
  $script_a = $v8->compileString($js, 'a.js');
	var_dump(is_resource($script_a));
  $script_b = $v8two->compileString($js2, 'b.js');
	var_dump(is_resource($script_b));
	var_dump($v8->executeScript($script_a));
	var_dump($v8->executeScript($script_b));
	var_dump($v8->executeScript($script_a));
} catch (V8JsScriptException $e) {
	var_dump($e);
}
?>
===EOF===
--EXPECT--
--FILE--
--FILE--
bool(true)
bool(true)
object(V8Object)#3 (1) {
  ["hello"]=>
  string(5) "world"
}
bool(false)
object(V8Object)#3 (1) {
  ["hello"]=>
  string(5) "world"
}
===EOF===

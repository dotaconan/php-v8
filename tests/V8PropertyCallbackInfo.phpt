--TEST--
V8\PropertyCallbackInfo
--SKIPIF--
<?php if (!extension_loaded("v8")) print "skip"; ?>
--FILE--
<?php

use V8\Context;
use V8\Isolate;
use V8\NameValue;
use V8\ObjectValue;
use V8\PropertyCallbackInfo;
use V8\Script;
use V8\StringValue;

/** @var \Phpv8Testsuite $helper */
$helper = require '.testsuite.php';

$isolate = new Isolate();

$context = new Context($isolate);

$prop_value = 'foo';

$getter = function (NameValue $property, PropertyCallbackInfo $info) use (&$prop_value, $helper, $isolate, $context) {

    $helper->message('Property callback called');
    $helper->line();

    $helper->header('Object representation');
    $helper->dump($info);
    $helper->space();

    $helper->assert('Callback info holds original isolate object', $info->GetIsolate(), $isolate);
    $helper->assert('Callback info holds original isolate object', $info->GetContext(), $context);

    $helper->space();

    $info->GetReturnValue()->Set(new StringValue($info->GetIsolate(), $prop_value));
};


$obj = new ObjectValue($context);

$obj->SetAccessor($context, new StringValue($isolate, 'test'), $getter);

$context->GlobalObject()->Set($context, new StringValue($isolate, 'obj'), $obj);

$script1 = new Script($context, new StringValue($isolate, 'obj.test'));


$helper->dump($script1->Run($context)->ToString($context)->Value());

?>
--EXPECT--
Property callback called

Object representation:
----------------------
object(V8\PropertyCallbackInfo)#8 (6) {
  ["isolate":"V8\CallbackInfo":private]=>
  object(V8\Isolate)#2 (5) {
    ["snapshot":"V8\Isolate":private]=>
    NULL
    ["time_limit":"V8\Isolate":private]=>
    float(0)
    ["time_limit_hit":"V8\Isolate":private]=>
    bool(false)
    ["memory_limit":"V8\Isolate":private]=>
    int(0)
    ["memory_limit_hit":"V8\Isolate":private]=>
    bool(false)
  }
  ["context":"V8\CallbackInfo":private]=>
  object(V8\Context)#3 (1) {
    ["isolate":"V8\Context":private]=>
    object(V8\Isolate)#2 (5) {
      ["snapshot":"V8\Isolate":private]=>
      NULL
      ["time_limit":"V8\Isolate":private]=>
      float(0)
      ["time_limit_hit":"V8\Isolate":private]=>
      bool(false)
      ["memory_limit":"V8\Isolate":private]=>
      int(0)
      ["memory_limit_hit":"V8\Isolate":private]=>
      bool(false)
    }
  }
  ["this":"V8\CallbackInfo":private]=>
  object(V8\ObjectValue)#5 (2) {
    ["isolate":"V8\Value":private]=>
    object(V8\Isolate)#2 (5) {
      ["snapshot":"V8\Isolate":private]=>
      NULL
      ["time_limit":"V8\Isolate":private]=>
      float(0)
      ["time_limit_hit":"V8\Isolate":private]=>
      bool(false)
      ["memory_limit":"V8\Isolate":private]=>
      int(0)
      ["memory_limit_hit":"V8\Isolate":private]=>
      bool(false)
    }
    ["context":"V8\ObjectValue":private]=>
    object(V8\Context)#3 (1) {
      ["isolate":"V8\Context":private]=>
      object(V8\Isolate)#2 (5) {
        ["snapshot":"V8\Isolate":private]=>
        NULL
        ["time_limit":"V8\Isolate":private]=>
        float(0)
        ["time_limit_hit":"V8\Isolate":private]=>
        bool(false)
        ["memory_limit":"V8\Isolate":private]=>
        int(0)
        ["memory_limit_hit":"V8\Isolate":private]=>
        bool(false)
      }
    }
  }
  ["holder":"V8\CallbackInfo":private]=>
  object(V8\ObjectValue)#5 (2) {
    ["isolate":"V8\Value":private]=>
    object(V8\Isolate)#2 (5) {
      ["snapshot":"V8\Isolate":private]=>
      NULL
      ["time_limit":"V8\Isolate":private]=>
      float(0)
      ["time_limit_hit":"V8\Isolate":private]=>
      bool(false)
      ["memory_limit":"V8\Isolate":private]=>
      int(0)
      ["memory_limit_hit":"V8\Isolate":private]=>
      bool(false)
    }
    ["context":"V8\ObjectValue":private]=>
    object(V8\Context)#3 (1) {
      ["isolate":"V8\Context":private]=>
      object(V8\Isolate)#2 (5) {
        ["snapshot":"V8\Isolate":private]=>
        NULL
        ["time_limit":"V8\Isolate":private]=>
        float(0)
        ["time_limit_hit":"V8\Isolate":private]=>
        bool(false)
        ["memory_limit":"V8\Isolate":private]=>
        int(0)
        ["memory_limit_hit":"V8\Isolate":private]=>
        bool(false)
      }
    }
  }
  ["return_value":"V8\CallbackInfo":private]=>
  object(V8\ReturnValue)#9 (2) {
    ["isolate":"V8\ReturnValue":private]=>
    object(V8\Isolate)#2 (5) {
      ["snapshot":"V8\Isolate":private]=>
      NULL
      ["time_limit":"V8\Isolate":private]=>
      float(0)
      ["time_limit_hit":"V8\Isolate":private]=>
      bool(false)
      ["memory_limit":"V8\Isolate":private]=>
      int(0)
      ["memory_limit_hit":"V8\Isolate":private]=>
      bool(false)
    }
    ["context":"V8\ReturnValue":private]=>
    object(V8\Context)#3 (1) {
      ["isolate":"V8\Context":private]=>
      object(V8\Isolate)#2 (5) {
        ["snapshot":"V8\Isolate":private]=>
        NULL
        ["time_limit":"V8\Isolate":private]=>
        float(0)
        ["time_limit_hit":"V8\Isolate":private]=>
        bool(false)
        ["memory_limit":"V8\Isolate":private]=>
        int(0)
        ["memory_limit_hit":"V8\Isolate":private]=>
        bool(false)
      }
    }
  }
  ["should_throw_on_error":"V8\PropertyCallbackInfo":private]=>
  bool(false)
}


Callback info holds original isolate object: ok
Callback info holds original isolate object: ok


string(3) "foo"

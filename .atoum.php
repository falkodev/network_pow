<?php

$script->addTestsFromDirectory(__DIR__ . '/src/AppBundle/Tests/Units');
$script->noCodeCoverageForNamespaces('Composer');

$xunitWriter = new atoum\writers\file(__DIR__ . '/build/atoum.xunit.xml');
$xunitReport = new atoum\reports\asynchronous\xunit();
$xunitReport->addWriter($xunitWriter);

$runner->addReport($script->addDefaultReport());
$runner->addReport($xunitReport);

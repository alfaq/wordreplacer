<?php
CModule::IncludeModule("wordreplacer");
global $DBType;

$arClasses=array(
    'cWordReplacer'=>'classes/general/wordreplacer.class.php'
);

CModule::AddAutoloadClasses("wordreplacer",$arClasses);

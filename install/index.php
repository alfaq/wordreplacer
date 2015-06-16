<?
Class WordReplacer extends CModule
{
    var $MODULE_ID = "wordreplacer";
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_CSS;
    var $MODULE_GROUP_RIGHTS = "Y";

    function WordReplacer()
    {
        $arModuleVersion = array();

        $path = str_replace("\\", "/", __FILE__);
        $path = substr($path, 0, strlen($path) - strlen("/index.php"));
        include($path."/version.php");
        if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion))
        {
            $this->MODULE_VERSION = $arModuleVersion["VERSION"];
            $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        }
        $this->MODULE_NAME = "WordReplacer";
        $this->MODULE_DESCRIPTION = "Модуль позволяет создавать пояснения для слов на страницах сайта.";
        $this->PARTNER_NAME = "AGriboed"; 
        $this->PARTNER_URI = "http://v1rus.ru";
    }

    function DoInstall()
    {
        global $DOCUMENT_ROOT, $APPLICATION;
        // Install events
        RegisterModule($this->MODULE_ID);
        $APPLICATION->IncludeAdminFile("Установка модуля WordReplacer", $DOCUMENT_ROOT."/bitrix/modules/wordreplacer/install/step.php");
        return true;
    }

    function DoUninstall()
    {
        global $DOCUMENT_ROOT, $APPLICATION;
        UnRegisterModule($this->MODULE_ID);
        $APPLICATION->IncludeAdminFile("Деинсталляция модуля WordReplacer", $DOCUMENT_ROOT."/bitrix/modules/wordreplacer/install/unstep.php");
        return true;
    }
}
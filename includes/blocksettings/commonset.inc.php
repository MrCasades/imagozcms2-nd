<?php
/*Кнопка настроек */
if (loggedIn() && userRole('Администратор'))	
{
    //$mainpageSet = "<a href='//".MAIN_URL."/pagesettings/mainpagesetting/'><button class='btn_1 addit-btn'>Настроить</button></a>";

    //$pageSetButton = "<a href='//".MAIN_URL."/pagesettings/".$blockFolder."setting/'><button class='btn_1 addit-btn'>Настроить</button></a>";

    $pageSetButtonCommon = "<form action = '//".MAIN_URL."/admin/pagesettings/' method = 'get'>           
            <button name = 'common_action' class='btn_1 addit-btn' value='Общие настройки'><i class='fa fa-cog' aria-hidden='true' title='Общие настройки'></i></button>
        </form>";
}

$json_object_common = file_get_contents(MAIN_FILE.'/includes/blocksettings/header.json');
$data_common = json_decode($json_object_common, true);
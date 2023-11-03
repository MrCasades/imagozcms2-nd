<?php

if (userRole('Администратор'))	
{
    //$mainpageSet = "<a href='//".MAIN_URL."/pagesettings/mainpagesetting/'><button class='btn_1 addit-btn'>Настроить</button></a>";

    $pageSetButton = "<a href='//".MAIN_URL."/pagesettings/".$blockFolder."setting/'><button class='btn_1 addit-btn'>Настроить</button></a>";
}

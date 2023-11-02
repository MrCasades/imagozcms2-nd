<?php
$mainpageSet = '';

if (userRole('Администратор'))	
{
    $mainpageSet = "<a href='//".MAIN_URL."/pagesettings/mainpagesetting/'><button class='btn_1 addit-btn'>Настроить</button></a>";
}

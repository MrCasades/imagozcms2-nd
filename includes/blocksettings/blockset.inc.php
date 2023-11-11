<?php
/*Кнопка настроек */
if (loggedIn() && userRole('Администратор'))	
{
    //$mainpageSet = "<a href='//".MAIN_URL."/pagesettings/mainpagesetting/'><button class='btn_1 addit-btn'>Настроить</button></a>";

    //$pageSetButton = "<a href='//".MAIN_URL."/pagesettings/".$blockFolder."setting/'><button class='btn_1 addit-btn'>Настроить</button></a>";

    $pageSetButton = "<form action = '//".MAIN_URL."/pagesettings/' method = 'get'>
            <input type = 'hidden' name = 'blockfolder' value = '".$blockFolder."'>
            <button name = 'action' class='btn_1 addit-btn' value='Настроить'>Настроить</button>
        </form>";
}


$json_object = file_get_contents(MAIN_FILE.'/includes/blocksettings/'.$blockFolder.'.json');
$data = json_decode($json_object, true);

if(
    $blockFolder == 'viewallnewsincat' || 
    $blockFolder == 'viewallmetas' || 
    $blockFolder == 'viewcategory' || 
    $blockFolder == 'viewallpostsincat' ||
    $blockFolder == 'viewallpromotionincat' ||
    $blockFolder == 'viewallvideosincat' ||
    $blockFolder == 'viewmetanews' ||
    $blockFolder == 'viewmetapost' ||
    $blockFolder == 'viewmetapromotion' ||
    $blockFolder == 'viewmetavideo' ||
    $blockFolder == 'viewmetablogpublication'
    )

{
    if ($blockFolder == 'viewallnewsincat' || $blockFolder == 'viewcategory' || $blockFolder == 'viewallpostsincat' || $blockFolder == 'viewallpromotionincat' || $blockFolder == 'viewallvideosincat')
    {
        $preBlockFolder = 'viewcategory';
        $linkType = '/?id='.$row['categoryid'];
        $tm = 'categoryname';
    }

    elseif ($blockFolder == 'viewallmetas' || $blockFolder == 'viewmetanews' || $blockFolder == 'viewmetapost' || $blockFolder == 'viewmetapromotion' || $blockFolder == 'viewmetavideo' || $blockFolder == 'viewmetablogpublication')
    {
        $preBlockFolder = 'viewallmetas';
        $linkType = '/?metaid='.$idMeta;
        $tm = 'metaname';
    }
        

    //$phrases = array('metaname', 'categoryname');

   
    $title = insertVar($tm, $row[$tm], $data['title'] );
    $headMain = insertVar($tm, $row[$tm], $data['headMain'] ); 
    $descr = insertVar($tm, $row[$tm], $data['descr'] ); 

    $blockFolder = $blockFolder == 'viewmetablogpublication' ? 'blog/'.$blockFolder : $blockFolder;

    if (!empty($data['breadPart1'])) 
        $breadPart1 = '<a href="//'.MAIN_URL.'">'.insertVar($tm, $row[$tm], $data['breadPart1']).'</a> >> '; //Для хлебных крошек
    if (!empty($data['breadPart2']))
        $breadPart2 = '<a href="//'.MAIN_URL.'/'.$preBlockFolder.$linkType.'">'.insertVar($tm, $row[$tm], $data['breadPart2']).'</a> ';//Для хлебных крошек
    if (!empty($data['breadPart3']))
        $breadPart3 = '>> <a href="//'.MAIN_URL.'/'.$blockFolder.$linkType.'">'.insertVar($tm, $row[$tm], $data['breadPart3']).'</a> ';//Для хлебных крошек
}

else 
{
    $title = $data['title'];
    $headMain = $data['headMain'];   
    $descr = $data['descr'];

    if (!empty($data['breadPart1'])) 
        $breadPart1 = '<a href="//'.MAIN_URL.'">'.$data['breadPart1'].'</a> >> '; //Для хлебных крошек
    if (!empty($data['breadPart2']))
        $breadPart2 = '<a href="//'.MAIN_URL.'/'.$blockFolder.'/">'.$data['breadPart2'].'</a> ';//Для хлебных крошек
    // if (!empty($data['breadPart3']))
    //     $breadPart3 = '>> <a href="//'.MAIN_URL.'/'.$blockFolder.'/">'.$data['breadPart3'].'</a> ';//Для хлебных крошек
}

$robots = $data['robots'];

if (!empty($data['about'])) 
    $about = $data['about'];

/*Замена на название категории*/
function insertVar($typeVar, $var, $text)
{
    $newText = str_replace($typeVar, $var, $text);
    return $newText;
}
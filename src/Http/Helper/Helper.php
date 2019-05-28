<?php
use Illuminate\Support\Facades\File;
function loadAssetJs($path){
    $file = File::get($path);
    echo "<script>" . $file . "</script>";
}

function loadAssetCSS($path)
{
    $file = File::get($path);
    echo "<style>" . $file . "</style>";
}

function activeMenu($rota)
{
    if (is_array($rota)) {
        if(count($rota) > 0) {
            foreach($rota as $rotaSingle) {
                if((strpos(\Illuminate\Support\Facades\Route::currentRouteName(), $rotaSingle) === 0)) {
                    return ' active ';
                }
            }
        }
    } else {
        return (strpos(\Illuminate\Support\Facades\Route::currentRouteName(), $rota) === 0) ? ' active ' : '';
    }
}
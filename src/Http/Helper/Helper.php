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
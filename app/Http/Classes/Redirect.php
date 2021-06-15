<?php

namespace App\Http\Classes;

class Redirect
{

    public static function redirect($type, $id, $path)
    {
        //        save_and_back
//        save_and_edit
//        save_and_new

        switch ($type) {
            case "save_and_back" :
                return url($path);
                break;
            case  "save_and_edit":
                return url($path . '/' . $id . '/edit');
                break;
            case "save_and_new":
                return url($path . '/create');
                break;
            default :
                return url($path . '/' . $id . '/edit');
        }

    }


}

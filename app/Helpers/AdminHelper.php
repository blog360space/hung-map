<?php

use App\Menu;
use App\Helpers\Cms;

if (! function_exists('display_menu')):
    function display_menu () {
    
        $tree = Menu::tree(0, 'admin');
        $str = _display_menu($tree);
        echo mb_substr ($str,0, -5) .
                
        '<li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" 
               role="button" aria-expanded="false">' .
                Auth::user()->name . '<span class="caret"></span>
            </a>

            <ul class="dropdown-menu" role="menu">
                <li><a href="' . url('/admin/profiles/change-password') . '">
                        <i class="fa fa-btn fa-lock"></i>Change password</a></li>
                <li><a href="' . url('/logout') . '">
                        <i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
            </ul>
        </li></ul>';
                
    }
    
    function _display_menu($tree, $lv = 0)
    {
        if ($lv == 0) {
            $str = '<ul class="nav navbar-nav navbar-right">';
        } else {
            $str = '<ul class="dropdown-menu" role="menu">';
        }
        
        $lv ++;
        foreach ($tree as $menu) {
            if (count($menu->children)) {
                 $str .= '<li class="dropdown">'
                 . '<a href="' . $menu->uri .'" data-toggle="dropdown" 
                               role="button" aria-expanded="false">'        
                 . $menu->title                 
                 . '<span class="caret"></span></a>'
                 . _display_menu($menu->children, $lv)
                 . "</li>";
            } else {
                 $str .= '<li>'
                 . '<a href="' . url('/') . $menu->uri .'">'        
                 . $menu->title
                 . "</a></li>"
                ;
            }
        }
        
        $str .="</ul>";
        
        return $str;
    }
    
endif;

if (! function_exists('status_text')):
    /**
     * Display status by text
     * @param type $code
     * @param type $first For select box
     */
    function status_text ($code = null, $first = '') {
        $statuses = [
            Cms::Active => 'Active',
            Cms::Draft => 'Draft',
            Cms::Trash => 'Trash',
        ];
        
        if ($first) {
            array_unshift($statuses, ['' => $first]);
        }
        
        if ($code === null) {
            if (isset($statuses[$code])) {
                echo $statuses[$code];
            }
        }
        
        return $statuses;
    }
endif;


if (! function_exists('status_icon')):
    /**
     * Display status by text
     * @param type $code
     * @param type $first For select box
     */
    function status_icon ($code = null) {
        $statuses = [
            Cms::Active => ['Active', 'glyphicon glyphicon-check'],
            Cms::Draft => ['Draft', 'glyphicon glyphicon-edit'],
            Cms::Trash => ['Trash', 'glyphicon glyphicon-trash'],
        ];
        $s = '<i class="' . $statuses[$code][1] .'" title="'. $statuses[$code][0] .'"></i>';
        
        echo $s;
    }
endif;


if (!function_exists('')):
    /**
     * Short description for content
     * @param type $strContent
     */
    function the_excerpt($strContent = '') {
        echo $strContent;
    }
endif;

if (!function_exists('the_date')) {
    /**
     * Format date
     * @param string $date mysql format date
     */
    function the_date($date) {
        echo $date;
    }
}


if (!function_exists('the_content')) {
    /**
     * Format date
     * @param string $date mysql format date
     */
    function the_content($strContent) {
        echo $strContent;
    }
}


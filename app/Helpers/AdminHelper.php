<?php

use App\Menu;

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
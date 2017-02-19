<?php

use App\Menu;
use App\Helpers\Cms;
use Parsedown;

define( 'TIMEBEFORE_NOW',         'now' );
define( 'TIMEBEFORE_MINUTE',      '{num} minute ago' );
define( 'TIMEBEFORE_MINUTES',     '{num} minutes ago' );
define( 'TIMEBEFORE_HOUR',        '{num} hour ago' );
define( 'TIMEBEFORE_HOURS',       '{num} hours ago' );
define( 'TIMEBEFORE_YESTERDAY',   'yesterday' );
define( 'TIMEBEFORE_FORMAT',      '%e %b' );
define( 'TIMEBEFORE_FORMAT_YEAR', '%e %b, %Y' );

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


if (!function_exists('the_excerpt')):
    /**
     * Short description for content
     * @param type $strContent
     */
    function the_excerpt($strContent = '') {
        $parsedown = new Parsedown();
        $split = '<!--more-->';
        $pos = mb_strpos($strContent, $split);
        
        if ($pos === 0) {
            return '';
        }
        else if ($pos > 0){
            echo $parsedown->text(mb_substr($strContent, 0, $pos));
        }
        else {
            echo $parsedown->text($strContent);
        }
    }
endif;

if (!function_exists('the_date')) {
    /**
     * Format date
     * @param string $date mysql format date
     */
    function the_date($date) {
        echo time_ago(strtotime($date));
    }
}


if (!function_exists('the_content')) {
    /**
     * Format date
     * @param string $date mysql format date
     */
    function the_content($strContent) {
        $parsedown = new Parsedown();
        echo $parsedown->text($strContent);
    }
}

function time_ago( $time )
{
    $out    = ''; // what we will print out
    $now    = time(); // current time
    $diff   = $now - $time; // difference between the current and the provided dates

    if( $diff < 60 ) // it happened now
        return TIMEBEFORE_NOW;

    elseif( $diff < 3600 ) // it happened X minutes ago
        return str_replace( '{num}', ( $out = round( $diff / 60 ) ), $out == 1 ? TIMEBEFORE_MINUTE : TIMEBEFORE_MINUTES );

    elseif( $diff < 3600 * 24 ) // it happened X hours ago
        return str_replace( '{num}', ( $out = round( $diff / 3600 ) ), $out == 1 ? TIMEBEFORE_HOUR : TIMEBEFORE_HOURS );

    elseif( $diff < 3600 * 24 * 2 ) // it happened yesterday
        return TIMEBEFORE_YESTERDAY;

    else // falling back on a usual date format as it happened later than yesterday
        return strftime( date( 'Y', $time ) == date( 'Y' ) ? TIMEBEFORE_FORMAT : TIMEBEFORE_FORMAT_YEAR, $time );
}
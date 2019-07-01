<?php if (!defined('ABSPATH')) die;

class BIEExceptionHelper
{
    public static function pretify(Exception $e) {
        $trace = $e->getTrace();
    
        $result = 'Exception: "';
        $result .= $e->getMessage();
        $result .= '" @ ';
        if ($trace[0]['class'] != '') {
          $result .= $trace[0]['class'];
          $result .= '->';
        }

        $result .= $trace[0]['function'];
        $result .= '();<br />';
    
        return $result;
      }
}
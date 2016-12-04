<?php

if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');

class syntax_plugin_ffxivdb extends DokuWiki_Syntax_Plugin {
    function getType(){
        return 'substition';
    }

    function getSort(){
        return 300;
    }

    function connectTo($mode){
        $this->Lexer->addSpecialPattern('\{\{ffitem>[^}]*\}\}', $mode, 'plugin_ffxivdb');
    }

    function handle($match, $state, $pos, Doku_Handler $handler){
        // Strip the markup
        $match = substr($match, 9, -2);

        $data = array();
        $items = explode(',', $match, 2);
        
        $data['id'] = trim($items[0]);

        if(count($items) == 2){
            $data['text'] = trim($items[1]);
        }else{
            $data['text'] = $data['id'];
        }

        return $data;
    }

    function render($mode, Doku_Renderer $R, $data){
        if($mode == 'xhtml'){
            $R->doc .= '<a href="http://eu.finalfantasyxiv.com/lodestone/playguide/db/item/' 
                    . htmlentities($data['id'])
                    . '/" class="eorzeadb_link">' 
                    . htmlentities($data['text'])
                    . '</a>';
            return true;
        }

        return false;
    }
}

?>

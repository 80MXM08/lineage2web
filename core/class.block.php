<?php
if (!defined('CORE'))
{
    die();
}

class Block
{
    private static $data = [];

    static function init()
    {
        DAO::get()::Block()::get();
    }

    static function add($b)
    {
        array_push(Block::$data, $b);
    }

    static function show($pos)
    {
        $cnt = '';
        foreach (Block::$data as $b)
        {
            if (!$b['active'])
            {
                continue;
            }
            if ($pos == $b['align'] && User::getAccess() >= $b['access'])
            {
                $cnt .= Block::showBlock($b);
            }
        }
        return $cnt;
    }

    static function showBlock($b)
    {
        global $sql, $Lang, $GS, $content;
        //TODO: remove globals?
        //$imgLink = 'themes/'.$user->getVar('theme');
        $cnt = '';
        if ($b['frame'])
        {
            $parse2['blockTitle'] = $Lang['__'.$b['title'].'_'];
            $cnt                  .= tpl::parse('blocks/block_t', $parse2);
        }
        if ($b['file'])
        {
            if (file_exists('blocks/' . $b['file'] . '.php'))
            {
                require('blocks/' . $b['file'] . '.php');
                $cnt .= $content;
            }
            else
            {
                $cnt .= msg('Error', 'Failed to get block ' . $b['file'], 'error');
            }
        }
        else
        {
            $cnt .= $b['content'];
        }

        if ($b['frame'])
        {
            $cnt .= tpl::parse('blocks/block_b', null);
        }
        return $cnt;
    }

    static function debug()
    {
        var_dump(Block::$data);
    }

}

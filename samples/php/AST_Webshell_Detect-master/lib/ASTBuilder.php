<?php

namespace ASTBuilder;

require_once dirname(__FILE__)."/../vendor/autoload.php";

use PhpParser\ParserFactory;

/**
 *
*/
class ASTBuilder
{
    /* AST生成器 */
    public $parser;

    /**
     *  创建一个AST生成器
    */
    public function __construct()
    {
        $this->parser = (new ParserFactory())->create(ParserFactory::PREFER_PHP5);
    }

}
<?php

    /**
     * 该文件定义了通用配置
     */

    define("MAX_SCAN_FILECOUNT", 5000);     //最大检测文件数

    /* 检测的文件扩展名列表 */
    $FILE_TYPES = array(
        '.php',
        '.inc',
        '.phps',
        '.php4',
        '.php5',
        '.html',
        '.htm',
        '.txt',
        '.phtml',
        '.tpl',
        '.cgi',
        '.test',
        '.module',
        '.plugin'
    );
<?php

    /**
     * 该文件定义了所有的威胁函数，威胁函数按漏洞类型进行了分类。
     * 每个威胁函数定义结构如下：
     *          威胁函数名 => [[重要参数位置]，[安全函数名]]
     *
     *  重要参数位置为0代表检查所有参数
     */

    /* 操作系统命令执行类函数 */
    $NAME_EXEC = 'Command Execution';
    $F_EXEC = array(
        'exec'							=> array(array(1), array()),
        'expect_popen'					=> array(array(1), array()),  //执行命令，并返回流指针
        'passthru'						=> array(array(1), array()),
        'pcntl_exec'					=> array(array(1), array()),
        'popen'							=> array(array(1), array()),
        'proc_open'						=> array(array(1), array()),
        'shell_exec'					=> array(array(1), array()),
        'system'						=> array(array(1), array()),
        'mail'							=> array(array(5), array()),  //http://esec-pentest.sogeti.com/posts/2011/11/03/using-mail-for-remote-code-execution.html
        'mb_send_mail'					=> array(array(5), array()),  //同mail
    );

    /* 代码执行类函数 */
    $NAME_CODE = 'Code Execution';
    $F_CODE = array(
        'assert' 						=> array(array(1), array()),
        'create_function' 				=> array(array(1,2), array()),
        'eval' 							=> array(array(1), array()),
        'mb_ereg_replace'				=> array(array(2,4), array()),
        'mb_eregi_replace'				=> array(array(2,4), array()),
        'preg_filter'					=> array(array(1,2), array()),
        'preg_replace'					=> array(array(1,2), array()),
        'preg_replace_callback'			=> array(array(1), array()),   //为什么不检查第二个参数，因为第二个参数威胁较小
    );

    /* 文件包含类函数 */
    $NAME_FILE_INCLUDE = 'File Inclusion';
    $F_FILE_INCLUDE = array(
        'include' 						=> array(array(1), array()),
        'include_once' 					=> array(array(1), array()),
        'parsekit_compile_file'			=> array(array(1), array()),
        'php_check_syntax' 				=> array(array(1), array()),
        'require' 						=> array(array(1), array()),
        'require_once' 					=> array(array(1), array()),
        'runkit_import'					=> array(array(1), array()),
        'set_include_path' 				=> array(array(1), array()),
        'virtual' 						=> array(array(1), array())
    );

    // 回调类函数
    $NAME_REFLECTION = 'Reflection Injection';
    $F_REFLECTION = array(
        'event_buffer_new'				=> array(array(2,3,4), array()),
        'event_set'						=> array(array(4), array()),
        'iterator_apply'				=> array(array(2), array()),
        'forward_static_call'			=> array(array(1), array()),
        'forward_static_call_array'		=> array(array(1), array()),
        'call_user_func'				=> array(array(1,2), array()), //第二个参数也要检测
        'call_user_func_array'			=> array(array(1), array()),
        'array_diff_uassoc'				=> array(array(3), array()),
        'array_diff_ukey'				=> array(array(3), array()),
        'array_filter'					=> array(array(2), array()),
        'array_intersect_uassoc'		=> array(array(3), array()),
        'array_intersect_ukey'			=> array(array(3), array()),
        'array_map'						=> array(array(1), array()),
        'array_reduce'					=> array(array(2), array()),
        'array_udiff'					=> array(array(3), array()),
        'array_udiff_assoc'				=> array(array(3), array()),
        'array_udiff_uassoc'			=> array(array(3,4), array()),
        'array_uintersect'				=> array(array(3), array()),
        'array_uintersect_assoc'		=> array(array(3), array()),
        'array_uintersect_uassoc'		=> array(array(3,4), array()),
        'array_walk'					=> array(array(2), array()),
        'array_walk_recursive'			=> array(array(2), array()),
        'assert_options'				=> array(array(2), array()),
        'ob_start'						=> array(array(1), array()),
        'register_shutdown_function'	=> array(array(1), array()),
        'register_tick_function'		=> array(array(1), array()),
        'runkit_method_add'				=> array(array(1,2,3,4), array()),
        'runkit_method_copy'			=> array(array(1,2,3), array()),
        'runkit_method_redefine'		=> array(array(1,2,3,4), array()),
        'runkit_method_rename'			=> array(array(1,2,3), array()),
        'runkit_function_add'			=> array(array(1,2,3), array()),
        'runkit_function_copy'			=> array(array(1,2), array()),
        'runkit_function_redefine'		=> array(array(1,2,3), array()),
        'runkit_function_rename'		=> array(array(1,2), array()),
        'session_set_save_handler'		=> array(array(1,2,3,4,5), array()),
        'set_error_handler'				=> array(array(1), array()),
        'set_exception_handler'			=> array(array(1), array()),
        'spl_autoload'					=> array(array(1), array()),
        'spl_autoload_register'			=> array(array(1), array()),
        'sqlite_create_aggregate'		=> array(array(2,3,4), array()),
        'sqlite_create_function'		=> array(array(2,3), array()),
        'stream_wrapper_register'		=> array(array(2), array()),
        'uasort'						=> array(array(2), array()),
        'uksort'						=> array(array(2), array()),
        'usort'							=> array(array(2), array()),
        'yaml_parse'					=> array(array(4), array()),
        'yaml_parse_file'				=> array(array(4), array()),
        'yaml_parse_url'				=> array(array(4), array()),
        'eio_busy'						=> array(array(3), array()),
        'eio_chmod'						=> array(array(4), array()),
        'eio_chown'						=> array(array(5), array()),
        'eio_close'						=> array(array(3), array()),
        'eio_custom'					=> array(array(1,2), array()),
        'eio_dup2'						=> array(array(4), array()),
        'eio_fallocate'					=> array(array(6), array()),
        'eio_fchmod'					=> array(array(4), array()),
        'eio_fchown'					=> array(array(5), array()),
        'eio_fdatasync'					=> array(array(3), array()),
        'eio_fstat'						=> array(array(3), array()),
        'eio_fstatvfs'					=> array(array(3), array()),
        'preg_replace_callback'			=> array(array(2), array()),
        'dotnet_load'					=> array(array(1), array()),
    );

    // 文件操作类函数
    $NAME_FILE_AFFECT = 'File Manipulation';
    $F_FILE_AFFECT = array(
        'bzwrite'						=> array(array(2), array()),
        'chmod'							=> array(array(1), array()),
        'chgrp'							=> array(array(1), array()),
        'chown'							=> array(array(1), array()),
        'copy'							=> array(array(1), array()),
        'dio_write'						=> array(array(1,2), array()),
        'eio_chmod'						=> array(array(1), array()),
        'eio_chown'						=> array(array(1), array()),
        'eio_mkdir'						=> array(array(1), array()),
        'eio_mknod'						=> array(array(1), array()),
        'eio_rmdir'						=> array(array(1), array()),
        'eio_write'						=> array(array(1,2), array()),
        'eio_unlink'					=> array(array(1), array()),
        'error_log'						=> array(array(3), array()),
        'event_buffer_write'			=> array(array(2), array()),
        'file_put_contents'				=> array(array(1,2), array()),
        'fputcsv'						=> array(array(1,2), array()),
        'fputs'							=> array(array(1,2), array()),
        'fprintf'						=> array(array(0), array()),
        'ftruncate'						=> array(array(1), array()),
        'fwrite'						=> array(array(1,2), array()),
        'gzwrite'						=> array(array(1,2), array()),
        'gzputs'						=> array(array(1,2), array()),
        'loadXML'						=> array(array(1), array()),
        'mkdir'							=> array(array(1), array()),
        'move_uploaded_file'			=> array(array(1,2), array()),
        'posix_mknod'					=> array(array(1), array()),
        'recode_file'					=> array(array(2,3), array()),
        'rename'						=> array(array(1,2), array()),
        'rmdir'							=> array(array(1), array()),
        'shmop_write'					=> array(array(2), array()),
        'touch'							=> array(array(1), array()),
        'unlink'						=> array(array(1), array()),
        'vfprintf'						=> array(array(0), array()),
        'xdiff_file_bdiff'				=> array(array(3), array()),
        'xdiff_file_bpatch'				=> array(array(3), array()),
        'xdiff_file_diff_binary'		=> array(array(3), array()),
        'xdiff_file_diff'				=> array(array(3), array()),
        'xdiff_file_merge3'				=> array(array(4), array()),
        'xdiff_file_patch_binary'		=> array(array(3), array()),
        'xdiff_file_patch'				=> array(array(3), array()),
        'xdiff_file_rabdiff'			=> array(array(3), array()),
        'yaml_emit_file'				=> array(array(1,2), array()),
    );

    /* 跨站脚本类函数 */
    $NAME_XSS = 'Cross-Site Scripting';
    $F_XSS = array(
        'echo'							=> array(array(0), array()),
        'print'							=> array(array(1), array()),
        'print_r'						=> array(array(1), array()),
        'exit'							=> array(array(1), array()),
        'die'							=> array(array(1), array()),
        'printf'						=> array(array(0), array()),
        'vprintf'						=> array(array(0), array()),
        'trigger_error'					=> array(array(1), array()),
        'user_error'					=> array(array(1), array()),
        'odbc_result_all'				=> array(array(2), array()),
        'ovrimos_result_all'			=> array(array(2), array()),
        'ifx_htmltbl_result'			=> array(array(2), array())
    );

    /* http header注入函数 */
    $NAME_HTTP_HEADER = 'HTTP Response Splitting';
    $F_HTTP_HEADER = array(
        'header' 						=> array(array(1), array())
    );

    /* http session类函数 */
    $NAME_SESSION_FIXATION = 'Session Fixation';
    $F_SESSION_FIXATION = array(
        'setcookie' 					=> array(array(2), array()),
        'setrawcookie' 					=> array(array(2), array()),
        'session_id' 					=> array(array(1), array())
    );

    /* 文件暴露类函数 */
    $NAME_FILE_READ = 'File Disclosure';
    $F_FILE_READ = array(
        'bzread'						=> array(array(1), array()),
        'bzflush'						=> array(array(1), array()),
        'dio_read'						=> array(array(1), array()),
        'eio_readdir'					=> array(array(1), array()),
        'fdf_open'						=> array(array(1), array()),
        'file'							=> array(array(1), array()),
        'file_get_contents'				=> array(array(1), array()),
        'finfo_file'					=> array(array(1,2), array()),
        'fflush'						=> array(array(1), array()),
        'fgetc'							=> array(array(1), array()),
        'fgetcsv'						=> array(array(1), array()),
        'fgets'							=> array(array(1), array()),
        'fgetss'						=> array(array(1), array()),
        'fread'							=> array(array(1), array()),
        'fpassthru'						=> array(array(1,2), array()),
        'fscanf'						=> array(array(1), array()),
        'ftok'							=> array(array(1), array()),
        'get_meta_tags'					=> array(array(1), array()),
        'glob'							=> array(array(1), array()),
        'gzfile'						=> array(array(1), array()),
        'gzgetc'						=> array(array(1), array()),
        'gzgets'						=> array(array(1), array()),
        'gzgetss'						=> array(array(1), array()),
        'gzread'						=> array(array(1), array()),
        'gzpassthru'					=> array(array(1), array()),
        'highlight_file'				=> array(array(1), array()),
        'imagecreatefrompng'			=> array(array(1), array()),
        'imagecreatefromjpg'			=> array(array(1), array()),
        'imagecreatefromgif'			=> array(array(1), array()),
        'imagecreatefromgd2'			=> array(array(1), array()),
        'imagecreatefromgd2part'		=> array(array(1), array()),
        'imagecreatefromgd'				=> array(array(1), array()),
        'opendir'						=> array(array(1), array()),
        'parse_ini_file' 				=> array(array(1), array()),
        'php_strip_whitespace'			=> array(array(1), array()),
        'readfile'						=> array(array(1), array()),
        'readgzfile'					=> array(array(1), array()),
        'readlink'						=> array(array(1), array()),
        //'stat'						=> array(array(1), array()),
        'scandir'						=> array(array(1), array()),
        'show_source'					=> array(array(1), array()),
        'simplexml_load_file'			=> array(array(1), array()),
        'stream_get_contents'			=> array(array(1), array()),
        'stream_get_line'				=> array(array(1), array()),
        'xdiff_file_bdiff'				=> array(array(1,2), array()),
        'xdiff_file_bpatch'				=> array(array(1,2), array()),
        'xdiff_file_diff_binary'		=> array(array(1,2), array()),
        'xdiff_file_diff'				=> array(array(1,2), array()),
        'xdiff_file_merge3'				=> array(array(1,2,3), array()),
        'xdiff_file_patch_binary'		=> array(array(1,2), array()),
        'xdiff_file_patch'				=> array(array(1,2), array()),
        'xdiff_file_rabdiff'			=> array(array(1,2), array()),
        'yaml_parse_file'				=> array(array(1), array()),
        'zip_open'						=> array(array(1), array())
    );

    /* SQL注入类函数 */
    $NAME_DATABASE = 'SQL Injection';
    $F_DATABASE = array(
        // Abstraction Layers
        'dba_open'						=> array(array(1), array()),
        'dba_popen'						=> array(array(1), array()),
        'dba_insert'					=> array(array(1,2), array()),
        'dba_fetch'						=> array(array(1), array()),
        'dba_delete'					=> array(array(1), array()),
        'dbx_query'						=> array(array(2), array()),
        'odbc_do'						=> array(array(2), array()),
        'odbc_exec'						=> array(array(2), array()),
        'odbc_execute'					=> array(array(2), array()),
        // Vendor Specific
        'db2_exec' 						=> array(array(2), array()),
        'db2_execute'					=> array(array(2), array()),
        'fbsql_db_query'				=> array(array(2), array()),
        'fbsql_query'					=> array(array(1), array()),
        'ibase_query'					=> array(array(2), array()),
        'ibase_execute'					=> array(array(1), array()),
        'ifx_query'						=> array(array(1), array()),
        'ifx_do'						=> array(array(1), array()),
        'ingres_query'					=> array(array(2), array()),
        'ingres_execute'				=> array(array(2), array()),
        'ingres_unbuffered_query'		=> array(array(2), array()),
        'msql_db_query'					=> array(array(2), array()),
        'msql_query'					=> array(array(1), array()),
        'msql'							=> array(array(2), array()),
        'mssql_query'					=> array(array(1), array()),
        'mssql_execute'					=> array(array(1), array()),
        'mysql_db_query'				=> array(array(2), array()),
        'mysql_query'					=> array(array(1), array()),
        'mysql_unbuffered_query'		=> array(array(1), array()),
        'mysqli_stmt_execute'			=> array(array(1), array()),
        'mysqli_query'					=> array(array(2), array()),
        'mysqli_real_query'				=> array(array(1), array()),
        'mysqli_master_query'			=> array(array(2), array()),
        'oci_execute'					=> array(array(1), array()),
        'ociexecute'					=> array(array(1), array()),
        'ovrimos_exec'					=> array(array(2), array()),
        'ovrimos_execute'				=> array(array(2), array()),
        'ora_do'						=> array(array(2), array()),
        'ora_exec'						=> array(array(1), array()),
        'pg_query'						=> array(array(2), array()),
        'pg_send_query'					=> array(array(2), array()),
        'pg_send_query_params'			=> array(array(2), array()),
        'pg_send_prepare'				=> array(array(3), array()),
        'pg_prepare'					=> array(array(3), array()),
        'sqlite_open'					=> array(array(1), array()),
        'sqlite_popen'					=> array(array(1), array()),
        'sqlite_array_query'			=> array(array(1,2), array()),
        'arrayQuery'					=> array(array(1,2), array()),
        'singleQuery'					=> array(array(1), array()),
        'sqlite_query'					=> array(array(1,2), array()),
        'sqlite_exec'					=> array(array(1,2), array()),
        'sqlite_single_query'			=> array(array(2), array()),
        'sqlite_unbuffered_query'		=> array(array(1,2), array()),
        'sybase_query'					=> array(array(1), array()),
        'sybase_unbuffered_query'		=> array(array(1), array())
    );

    /* xpath 注入 */
    $NAME_XPATH = 'XPath Injection';
    $F_XPATH = array(
        'xpath_eval'					=> array(array(2), array()),
        'xpath_eval_expression'			=> array(array(2), array()),
        'xptr_eval'						=> array(array(2), array())
    );

    /* ldap 注入 */
    $NAME_LDAP = 'LDAP Injection';
    $F_LDAP = array(
        'ldap_add'						=> array(array(2,3), array()),
        'ldap_delete'					=> array(array(2), array()),
        'ldap_list'						=> array(array(3), array()),
        'ldap_read'						=> array(array(3), array()),
        'ldap_search'					=> array(array(3), array())
    );

    /* 连接处理类函数 */
    $NAME_CONNECT = 'Protocol Injection';
    $F_CONNECT = array(
        'curl_setopt'					=> array(array(2,3), array()),
        'curl_setopt_array' 			=> array(array(2), array()),
        'cyrus_query' 					=> array(array(2), array()),
        'error_log'						=> array(array(3), array()),
        'fsockopen'						=> array(array(1), array()),
        'ftp_chmod' 					=> array(array(2,3), array()),
        'ftp_exec'						=> array(array(2), array()),
        'ftp_delete' 					=> array(array(2), array()),
        'ftp_fget' 						=> array(array(3), array()),
        'ftp_get'						=> array(array(2,3), array()),
        'ftp_nlist' 					=> array(array(2), array()),
        'ftp_nb_fget' 					=> array(array(3), array()),
        'ftp_nb_get' 					=> array(array(2,3), array()),
        'ftp_nb_put'					=> array(array(2), array()),
        'ftp_put'						=> array(array(2,3), array()),
        'get_headers'					=> array(array(1), array()),
        'imap_open'						=> array(array(1), array()),
        'imap_mail'						=> array(array(1), array()),
        'mail' 							=> array(array(1,4), array()),
        'mb_send_mail'					=> array(array(1,4), array()),
        'ldap_connect'					=> array(array(1), array()),
        'msession_connect'				=> array(array(1), array()),
        'pfsockopen'					=> array(array(1), array()),
        'session_register'				=> array(array(0), array()),
        'socket_bind'					=> array(array(2), array()),
        'socket_connect'				=> array(array(2), array()),
        'socket_send'					=> array(array(2), array()),
        'socket_write'					=> array(array(2), array()),
        'stream_socket_client'			=> array(array(1), array()),
        'stream_socket_server'			=> array(array(1), array()),
        'printer_open'					=> array(array(1), array())
    );

    /* 其他重要函数 */
    $NAME_OTHER = 'Possible Flow Control'; // :X
    $F_OTHER = array(
        'dl' 							=> array(array(1), array()),
        'ereg'							=> array(array(2), array()), # nullbyte injection affected
        'eregi'							=> array(array(2), array()), # nullbyte injection affected
        'ini_set' 						=> array(array(1,2), array()),
        'ini_restore'					=> array(array(1), array()),
        'runkit_constant_redefine'		=> array(array(1,2), array()),
        'runkit_method_rename'			=> array(array(1,2,3), array()),
        'sleep'							=> array(array(1), array()),
        'usleep'						=> array(array(1), array()),
        'extract'						=> array(array(1), array()),
        'mb_parse_str'					=> array(array(1), array()),
        'parse_str'						=> array(array(1), array()),
        'putenv'						=> array(array(1), array()),
        'set_include_path'				=> array(array(1), array()),
        'apache_setenv'					=> array(array(1,2), array()),
        'define'						=> array(array(1), array()),
        'is_a'							=> array(array(1), array()) // calls __autoload()
    );

    /* 对象注入类函数 */
    $NAME_POP = 'PHP Object Injection';
    $F_POP = array(
        'unserialize'					=> array(array(1), array()), // calls gadgets
        'yaml_parse'					=> array(array(1), array())	 // calls unserialize
    );

    // XML
    //simplexml_load_string


    # interruption vulnerabilities
    # trim(), rtrim(), ltrim(), explode(), strchr(), strstr(), substr(), chunk_split(), strtok(), addcslashes(), str_repeat() htmlentities() htmlspecialchars(), unset()
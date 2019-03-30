#!/usr/bin/php
<?php

require_once( __DIR__.'/functions/google/parse_google_text_page.php' );
require_once( __DIR__.'/functions/fs/get_file_names.php' );

$_ = 'google_text_page_parser: ';

if( isset( $argv[ 1 ] ) && ( $argv[ 1 ] == '-h' || $argv[ 1 ] == '--help' ) )
	{///////////////////////////////////////////////////////////////////////
	$help = <<< HEREDOC

NAME
	google_text_page_parser - parse text file of google result

SYNOPSIS
	google_text_page_parser dir_name

DESCRIPTION
	Script find all files in dir_name, then parse it. Every file must be saved in firefox browser to text file ( Save As Text Files ) and be google search result.


HEREDOC;
	echo( $help );
	return( true );
	}///////////////////////////////////////////////////////////////////////

if( !isset( $argv[ 1 ] ) )
	trigger_error( $_."command line argument 1 is not set", E_USER_ERROR );
$dir_name = $argv[ 1 ];

$FILE_NAME = get_file_names( $dir_name );
if( count( $FILE_NAME ) == 0 )
	trigger_error( $_."found 0 files", E_USER_ERROR );

$HOST = array(  );
$QUERY = array(  );
foreach( $FILE_NAME as $file_name )
	{
	if( !( is_file( $file_name ) && is_readable( $file_name ) ) ) continue;
	
	$return = parse_google_text_page( $file_name );
	if( is_array( $return ) )
		{
		$URL = $return[ 'results' ];
		foreach( $URL as $url )
			{
			$host = parse_url( $url, PHP_URL_HOST );
			if( !array_key_exists( $host, $HOST ) )
				$HOST[ $host ] = 0;
			$HOST[ $host ] += 1;
			}

		$related = $return[ 'related' ];
		foreach( $related as $query )
			{
			if( !array_key_exists( $query, $QUERY ) )
				$QUERY[ $query ] = 0;
			$QUERY[ $query ] += 1;
			}
		}
	}
arsort( $HOST, SORT_NUMERIC );
arsort( $QUERY, SORT_NUMERIC );

echo( "Unique domain names : ".count( $HOST )."\n" );

echo( "\nDomain names top list\n" );
foreach( $HOST as $host => $count )
	echo( sprintf( "%04d %s\n", $count, $host ) );

echo( "\nUnique queries : ".count( $QUERY )."\n" );
echo( "\nSearches related top list\n" );
foreach( $QUERY as $query => $count )
	echo( sprintf( "%04d %s\n", $count, $query ) );

return( true );
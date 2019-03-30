<?php
////////////////////////////////////////////////////////////////////////////////
                                                                              /*
You must save google search result in firefox browser to text file ( Save As Text Files )

IN
	string $file_name - firefox saved file name
OUT
	array
		(
		 'results' => array( strings with search result url )
		,'related' => array( strings with searches related queries )
		)
	or false if error
                                                                              */
////////////////////////////////////////////////////////////////////////////////

function parse_google_text_page( $file_name )
	{
	$_ = __FUNCTION__.'(): ';

	if( !is_string( $file_name ) )
		return( !trigger_error( $_."\$file_name is not string", E_USER_WARNING ) );

	$STRING = file( $file_name, FILE_IGNORE_NEW_LINES );
	if( !is_array( $STRING ) )
		return( !trigger_error( $_."can't load file strings from file", E_USER_WARNING ) );

	$ARRAY = array
		(
		 'Search Results' => array(  )
		,'Searches related' => array(  )
		);
	$FLAG = array
		(
		 'Search Results' => false
		,'Searches related' => false
		,'1 2' => false
		);
	
	foreach( $STRING as $number => $string )
		{
		if( !$FLAG[ '1 2' ] )
			{
			if( $FLAG[ 'Search Results' ] && !$FLAG[ 'Searches related' ] )
				{
				if( preg_match( '/^\s*Searches related to .*$/', $string ) == 1 )
					{
					$FLAG[ 'Searches related' ] = true;
					continue;
					}
				array_push( $ARRAY[ 'Search Results' ], $string );
				continue;
				}
			if( $FLAG[ 'Search Results' ] && $FLAG[ 'Searches related' ] )
				{
				if( preg_match( '/^\s*1\s+2\s*$/', $string ) == 1 )
					{
					$FLAG[ '1 2' ] = true;
					break;
					}
				array_push( $ARRAY[ 'Searches related' ], $string );
				continue;
				}
			if( !$FLAG[ 'Search Results' ] )
				{
				if( preg_match( '/^\s*Search Results\s*$/', $string ) == 1 )
					{
					$FLAG[ 'Search Results' ] = true;
					continue;
					}
				}
			}
		}
	$result = array
		(
		 'Search Results' => array(  )
		,'Searches related' => array(  )
		);
	
	if( !$FLAG[ 'Search Results' ] )
		return( !trigger_error( $_."can't find 'Search Results'", E_USER_WARNING ) );
	else
		{
		$counter = 0;
		$count = count( $ARRAY[ 'Search Results' ] );
		$text = '';
		for( $key = 0; $key < $count; $key++ )
			{
			$string = $ARRAY[ 'Search Results' ][ $key ];
			
			if( preg_match( '/^\s*$/', $string ) == 1 ) $counter += 1;
			else
				{
				if( $counter == 2 )
					{
					for( ; $key < $count; $key++ )
						{
						$string = $ARRAY[ 'Search Results' ][ $key ];
						if( preg_match( '/^\s*$/', $string ) == 1 ) break;
						
						$text .= $string;
						if( preg_match( '/^.*\<([^\<\>]+)\>\s*$/', $text, $matches ) == 1 )
							array_push( $result[ 'Search Results' ], $matches[ 1 ] );
						}
					}
				$counter = 0;
				$text = '';
				}
			}
		}
		
	if( !$FLAG[ 'Searches related' ] )
		trigger_error( $_."can't find 'Searches related'", E_USER_WARNING );
	else
		{
		$count = count( $ARRAY[ 'Searches related' ] );
		$array = &$ARRAY[ 'Searches related' ];
		for( $key = 0; $key < $count; $key += 4 )
			{
			if(
			    array_key_exists( ( $key + 0 ), $array )
			 && array_key_exists( ( $key + 1 ), $array )
			 && array_key_exists( ( $key + 2 ), $array )
			 && array_key_exists( ( $key + 3 ), $array )
			 && trim( $array[ $key + 0 ] ) == ''
			 && trim( $array[ $key + 2 ] ) == ''
			 && strlen( trim( $array[ $key + 1 ] ) ) > 0
			 && preg_match( '/^\<.+\>$/', trim( $array[ $key + 3 ] ), $matches ) == 1 
			   )	
				{
				$string = $array[ $key + 1 ];
				$string = preg_replace( '/\*/', '', $string );
				array_push( $result[ 'Searches related' ], $string );
				}
			}
		}
		
	if( !$FLAG[ '1 2' ] )
		trigger_error( $_."can't find 1 2", E_USER_WARNING );
	
	$result = array
		(
		 'results' => $result[ 'Search Results' ]
		,'related' => $result[ 'Searches related' ]
		);
	
	return( $result );
	}
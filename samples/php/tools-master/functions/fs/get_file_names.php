<?php
function get_file_names( $dir_name )
	{
	$FILE_NAME = array(  );
	if( is_string( $dir_name ) && is_dir( $dir_name ) )
		{
		$FILE_NAME = array( $dir_name );
		for( $key = 0; $key < count( $FILE_NAME ); $key++ )
			{
			if( is_dir( $FILE_NAME[ $key ] ) )
				{
			 	$resource = opendir( $FILE_NAME[ $key ] );
				while( true )
					{
					$file_name = readdir( $resource );
					if( !is_string( $file_name ) )
						break;
						
					if( $file_name != '.' && $file_name != '..' )
						array_push( $FILE_NAME, $FILE_NAME[ $key ].'/'.$file_name );
					}
				}
			}
		}
	return( $FILE_NAME );
	}

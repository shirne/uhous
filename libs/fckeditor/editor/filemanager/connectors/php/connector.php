<?php
ob_start() ;

require('./config.php') ;
require('./util.php') ;
require('./io.php') ;
require('./basexml.php') ;
require('./commands.php') ;
require('./phpcompat.php') ;

if ( !$Config['Enabled'] )
	SendError( 1, 'This connector is disabled. Please check the "editor/filemanager/connectors/php/config.php" file' ) ;

DoResponse() ;

function DoResponse()
{
    if (!isset($_GET)) {
        global $_GET;
    }
	if ( !isset( $_GET['Command'] ) || !isset( $_GET['Type'] ) || !isset( $_GET['CurrentFolder'] ) )
		return ;

	// Get the main request informaiton.
	$sCommand		= $_GET['Command'] ;
	$sResourceType	= $_GET['Type'] ;
	$sCurrentFolder	= GetCurrentFolder() ;

	// Check if it is an allowed command
	if ( ! IsAllowedCommand( $sCommand ) )
		SendError( 1, 'The "' . $sCommand . '" command isn\'t allowed' ) ;

	// Check if it is an allowed type.
	if ( !IsAllowedType( $sResourceType ) )
		SendError( 1, 'Invalid type specified' ) ;

	// File Upload doesn't have to Return XML, so it must be intercepted before anything.
	if ( $sCommand == 'FileUpload' )
	{
		FileUpload( $sResourceType, $sCurrentFolder, $sCommand ) ;
		return ;
	}

	CreateXmlHeader( $sCommand, $sResourceType, $sCurrentFolder ) ;

	// Execute the required command.
	switch ( $sCommand )
	{
		case 'GetFolders' :
			GetFolders( $sResourceType, $sCurrentFolder ) ;
			break ;
		case 'GetFoldersAndFiles' :
			GetFoldersAndFiles( $sResourceType, $sCurrentFolder ) ;
			break ;
		case 'CreateFolder' :
			CreateFolder( $sResourceType, $sCurrentFolder ) ;
			break ;
	}

	CreateXmlFooter() ;

	exit ;
}
?>

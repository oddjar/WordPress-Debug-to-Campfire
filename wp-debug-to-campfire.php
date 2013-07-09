<?php

/*
Plugin Name: WP Debug to Campfire
Description: Send debug messages from WordPress to a Campfire chatroom
Version: 1.0
Author: Johnathon Williams
Author URI: http://oddjar.com
*/

/**
 * Copyright (c) 2013 Johnathon Williams. All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * **********************************************************************
 */

function ojcp_debug( $data, $message = null ) {


	// EDIT THESE VARIABLES TO MATCH YOUR OWN

	// the url to your campire account, without trailing slash
	$cp_url = '';
	// the api key from your campfire account
	$cp_api_key = '';
	// the room id from the room you want messages to post to
	// you can find this in the url when you're visiting the room
	$cp_api_chatroom_id = '';
	// your name and email address
	$cp_app_name = '';

	// END OF VARIABLES


	global $current_user;
	get_currentuserinfo();
	if ( $current_user ) {
		$user_name = $current_user->user_login;
	} else {
		$user_name = "User Not Logged In";
	}

	$site_name = $_SERVER['SERVER_NAME'];
	$script_name = $_SERVER['PHP_SELF'];
	$query_string = $_SERVER['PHP_SELF'];

	if ( $message ) {
		$message = $message;
	} else {
		$message = "No message";
	}


	$data = print_r( $data, true );


	$send_data  =	"Site Name:	" . $site_name . "\n";
	$send_data .=	"Script:		" . $script_name . "\n";
	$send_data .=	"Query String:	" . $query_string . "\n";
	$send_data .=	"WP Username:	" . $user_name . "\n";
	$send_data .=	"Message:		" . $message . "\n\n\n";



	$send_data .=	$data;

	$url = "$cp_url/room/$cp_api_chatroom_id/speak.json";

	$json_content = array(
		'message' => array(
			'type' => "PasteMessage",
			'body' => $send_data
		)
	);

	$json = json_encode( $json_content );
	$ch = curl_init();
	curl_setopt( $ch, CURLOPT_URL, $url );
	curl_setopt( $ch, CURLOPT_USERAGENT, $cp_app_name );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch, CURLOPT_POST, 1 );
	curl_setopt( $ch, CURLOPT_USERPWD, "$cp_api_key:X" );
	curl_setopt( $ch, CURLOPT_HTTPHEADER, array( "Content-type: application/json" ) );
	curl_setopt( $ch, CURLOPT_POSTFIELDS, $json );
	$output = curl_exec( $ch );
	curl_close( $ch );

}
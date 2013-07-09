WordPress Debug to Campfire
===========================

This is a WordPress plugin that provides a single function for sending debug messages to Campfire.

It's useful for when you don't want debug messages appearing on screen, when you need to quickly compare debug messages with another developer, or when you want to track or archive debug messages over time.

Each debug message includes the following information:

* The name of the site
* The name of the script
* The query string
* The username of the user executing the script (if the user is logged in)
* The array, object, string, or other information you choose to send
* An optional message

You call it like this:

ojcp_debug( $data, $message );

$data is the object, array, string, or other data type that you want to output and debug.

$message is an optional note (string) you can include.

You'll need to edit the variables at the top of the function to match your Campfire account details before using it.

It's a single function, so you could easily copy the function of out of the plugin file and paste it into the functions.php file of a theme, or into any existing plugin file.

It requires that the CURL and JSON libraries be available to PHP.
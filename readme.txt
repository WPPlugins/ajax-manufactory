=== AJAX Manufactory ===
Contributors: Epsiloncool
Donate link: http://e-wm.org/
Tags: ajax, client side, server side, xmlrequest, wordpress, request, response
Requires at least: 3.0.1
Tested up to: 4.5.1
Stable tag: 1.5.2.7
License: GPL3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

This plugin allows you to create AJAX applications by simple way. It implements JSON data transfer, data escaping, error
handling.

== Description ==

Whenever you plan to begin developing applications on Wordpress using AJAX technology, you have to solve a number of 
minor issues unrelated to the logic of your application:

*	How to package and transmit data from the browser to the server, so they will not have been distorted?
*	How to transfer data, if they are multi-dimensional array?
*	How to implement a custom processing of AJAX response in case, again, it represents a complex set of data (a typical
example - form sending and on-server validation)?
*	How to handle data transition errors?
*	How to debug all this stuff?

Usually these issues generates a lot of spaghetti code, moreover, each new request type requires some customization of
code. Managing all of this, you forget about the function that you would like to implement.

AJAX Manufactory plugin for Wordpress have most of these tasks already solved. You can think about functionality and 
business logic instead.

What you can have from the box:

*	A simple function at the client side which allows to send any your complex data from javascript to Wordpress server
side.
*	An AJAX response wrapper at the server side which gives to you sent data as PHP array and allows you to create
an AJAX response as a set of simple "commands" like "make an alert", "set up javascript variable", "put html text to
specific html node(s)", "execute a javascript function", "go to specific URL" etc.
*	Automatic execution of "commands" queue at the client side. Additionally you can specify your own callback.

= Documentation =

Please refer [Documentation](http://e-wm.org/ajax-manufactory/#documentation "AJAX Manufactory Documentation").

== Installation ==

1. Unpack and upload `ajax-manufactory` folder with all files to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Where can I put some notices, comments or bugreports? =

Do not hesistate to write to us at [Contact Us](http://e-wm.org/contact/ "Contact Us") page.


== Screenshots ==

1. A screenshot of simple example

== Changelog ==

= 1.5.2.6 =
* Fixed data collection from forms by jxFormData() method. Especially for checkbox lists and radio lists.

= 1.5.2.4 =
* New method call() was added. Read doc for details.

= 1.5.2.3 =
* Added new flag "has_priv" in JX class

= 1.5.2.1 =
* Fixed version number in core file

= 1.5.1.1 =
* Now working at admin side too

= 1.5.0.1 =
* Some security bugs was fixed.

= 1.5 =
* console() method added
* redirect() method has been fixed
* javascript module completely redone.

= 1.1 =
* Full Documentation has been added
* variable() method added

= 1.0 =
* First Wordpress version

= 0.4 =
* html(), redirect(), reload() methods were added.

= 0.1 =
* Initial edition. Only conception is implemented with alert() method on-board.

== Upgrade Notice ==

= 1.5.0.1 =
* Upgrade immediately, because of some security issues found and fixed

= 1.5 =
* First version to be in Wordpress repository, just install it

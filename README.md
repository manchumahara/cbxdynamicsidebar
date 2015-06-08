=== CBX Dynamic Sidebar ===
Contributors: manchumahara,codeboxr,wpboxr
Donate link: http://wpboxr.com
Tags: sidebar, widgets, dynamic
Requires at least: 3.0.1
Tested up to: 4.2.2
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Dynamic sidebar for wordpress using custom post type and shortcode

== Description ==

CBX Dynamic Sidebar for Wordpress helps to create dynamic sidebar or widget position using custom post type. Sometimes we need to put sidebar inside content and this plugin
 helps to create sidebar using custom post type and put the sidebar inside content using shortcode using simple shortcode

 [cbxdynamicsidebar id="686" /]  where 686  is the post id or as you get

 It'a also possible to call the sidebar using direction function call in theme

 `<?php
   if(function_exists('cbxdynamicsidebar_display')){
  	 $config_array = array(
  		 'id'       => '686',
  		 'wclass'        => 'cbxdynamicsidebar_wrapper',
  		 'wid'           => 'cbxdynamicsidebar_wrapper',
  		 'float'         => 'auto'
  	 );
  	 echo cbxdynamicsidebar_display($config_array);
   }

  ?>`

  or more simple way

  <?php
    do_shortcode('[cbxdynamicsidebar id="686"]');  where 686  is the post id or as you get
   ?>

From the custom post type "cbxsidebar" post edit screen there are other features that is implemented using meta field for

- sidebar class
- sidebar description
- sidebar before widget html wrapper
- sidebar after widget html wrapper
- sidebar widget before title html wrapper
- sidebar widget after title html wrapper
- sidebar enable disable without deleting the sidebar post
- Translation ready

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload `cbxdynamicsidebar.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= A question that someone might have =

An answer to that question.

= What about foo bar? =

Answer to foo bar dilemma.

== Screenshots ==

1. Sidebar Listing with shortcode note
2. Single Sidebar Edit

== Changelog ==

= 1.0.1 =
* First Release

== Upgrade Notice ==

= 1.0 =
Upgrade notices will be here if available

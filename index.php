<?php
/*
Plugin Name: Nexmopress
Plugin URI: http://www.gauravkheterpal.com/
Description: Nexmopress is a Wordpress plugin that leverages the powerful Number verification capabilities of Nexmo platform to provide secure authentication for Wordpress blog post comments and helps eliminate spam comments.
Version: 1.0
Author: Gaurav Kheterpal
Author URI: http://www.gauravkheterpal.com/
License: GPL2
 
{Plugin Name} is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
{Plugin Name} is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with {Plugin Name}. If not, see {License URI}.
*/


if( !defined( 'ABSPATH') && !defined('WP_UNINSTALL_PLUGIN') )
    exit();


    
//echo '<link href="'. plugins_url( '/style.css' , __FILE__ ) . '" rel="stylesheet" type="text/css" />';
add_filter('comment_form_defaults','comment_reform');

function comment_reform ($arg) {

$imgpath=plugins_url('', __FILE__).'/nexmo_logo.png';

    $arg['title_reply'] = __('Leave a Reply
        <em><small>Powered by </small>  </em><img src="'.$imgpath.'" style="width:50px;height:20px;text-align:right;"/>
        ');
    return $arg;
}

//alter database
function create_leave_reply_sql()    {
        global $wpdb;
        include_once ABSPATH . 'wp-admin/includes/upgrade.php';

$sql = "ALTER TABLE ". $wpdb->comments." ADD COLUMN comment_author_phone BIGINT(50) NOT NULL AFTER comment_author";

       $wpdb->query($sql);

$plugin_dir_template = plugin_dir_path( __FILE__ ) . 'comment-template.php';
    $theme_dir_template = ABSPATH . '/wp-includes/comment-template.php';

    $plugin_dir_comment = plugin_dir_path( __FILE__ ) . 'comment.php';
    $theme_dir_comment = ABSPATH . '/wp-includes/comment.php';


     $plugin_dir_wp_comment_post= plugin_dir_path( __FILE__ ) . 'wp-comments-post.php';
   
    $theme_dir_wp_comment_post = ABSPATH . 'wp-comments-post.php';


    //footer
    
    $plugin_dir_footer= plugin_dir_path( __FILE__ ). 'footer.php';
   
    $theme_dir_footer = get_template_directory().'/footer.php';

copy($plugin_dir_template,$theme_dir_template);

copy($plugin_dir_comment,$theme_dir_comment);

copy($plugin_dir_wp_comment_post,$theme_dir_wp_comment_post);

copy($plugin_dir_footer,$theme_dir_footer);

 }

register_activation_hook( __FILE__, 'create_leave_reply_sql' );


function create_leave_reply_deactivation()    {
        

$plugin_dir_template = plugin_dir_path( __FILE__ ) . 'orignalfiles/comment-template.php';
    $theme_dir_template = ABSPATH . '/wp-includes/comment-template.php';

    $plugin_dir_comment = plugin_dir_path( __FILE__ ) . 'orignalfiles/comment.php';
    $theme_dir_comment = ABSPATH . '/wp-includes/comment.php';


     $plugin_dir_wp_comment_post= plugin_dir_path( __FILE__ ) . 'orignalfiles/wp-comments-post.php';
   
    $theme_dir_wp_comment_post = ABSPATH . 'wp-comments-post.php';


    //footer
    
    $plugin_dir_footer= plugin_dir_path( __FILE__ ). 'orignalfiles/footer.php';
   
    $theme_dir_footer = get_template_directory().'/footer.php';

copy($plugin_dir_template,$theme_dir_template);

copy($plugin_dir_comment,$theme_dir_comment);

copy($plugin_dir_wp_comment_post,$theme_dir_wp_comment_post);

copy($plugin_dir_footer,$theme_dir_footer);

 }

register_deactivation_hook( __FILE__, 'create_leave_reply_deactivation' );
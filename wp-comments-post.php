<?php
/**
 * Handles Comment Post to WordPress and prevents duplicate comment posting.
 *
 * @package WordPress
 */

if ( 'POST' != $_SERVER['REQUEST_METHOD'] ) {
	header('Allow: POST');
	header('HTTP/1.1 405 Method Not Allowed');
	header('Content-Type: text/plain');
	exit;
}

/** Sets up the WordPress Environment. */
require( dirname(__FILE__) . '/wp-load.php' );

nocache_headers();

$comment_post_ID = isset($_POST['comment_post_ID']) ? (int) $_POST['comment_post_ID'] : 0;

$post = get_post($comment_post_ID);

if ( empty( $post->comment_status ) ) {
	/**
	 * Fires when a comment is attempted on a post that does not exist.
	 *
	 * @since 1.5.0
	 *
	 * @param int $comment_post_ID Post ID.
	 */
	do_action( 'comment_id_not_found', $comment_post_ID );
	exit;
}

// get_post_status() will get the parent status for attachments.
$status = get_post_status($post);

$status_obj = get_post_status_object($status);

if ( ! comments_open( $comment_post_ID ) ) {
	/**
	 * Fires when a comment is attempted on a post that has comments closed.
	 *
	 * @since 1.5.0
	 *
	 * @param int $comment_post_ID Post ID.
	 */
	do_action( 'comment_closed', $comment_post_ID );
	wp_die( __( 'Sorry, comments are closed for this item.' ), 403 );
} elseif ( 'trash' == $status ) {
	/**
	 * Fires when a comment is attempted on a trashed post.
	 *
	 * @since 2.9.0
	 *
	 * @param int $comment_post_ID Post ID.
	 */
	do_action( 'comment_on_trash', $comment_post_ID );
	exit;
} elseif ( ! $status_obj->public && ! $status_obj->private ) {
	/**
	 * Fires when a comment is attempted on a post in draft mode.
	 *
	 * @since 1.5.1
	 *
	 * @param int $comment_post_ID Post ID.
	 */
	do_action( 'comment_on_draft', $comment_post_ID );
	exit;
} elseif ( post_password_required( $comment_post_ID ) ) {
	/**
	 * Fires when a comment is attempted on a password-protected post.
	 *
	 * @since 2.9.0
	 *
	 * @param int $comment_post_ID Post ID.
	 */
	do_action( 'comment_on_password_protected', $comment_post_ID );
	exit;
} else {
	/**
	 * Fires before a comment is posted.
	 *
	 * @since 2.8.0
	 *
	 * @param int $comment_post_ID Post ID.
	 */
	do_action( 'pre_comment_on_post', $comment_post_ID );
}

$comment_author       = ( isset($_POST['author']) )  ? trim(strip_tags($_POST['author'])) : null;
/* Nexmo - Added phone number for verification */
$comment_author_phone = ( isset($_POST['phone']) )   ? trim($_POST['phone']) : null;
$comment_author_email = ( isset($_POST['email']) )   ? trim($_POST['email']) : null;
$comment_author_url   = ( isset($_POST['url']) )     ? trim($_POST['url']) : null;
$comment_content      = ( isset($_POST['comment']) ) ? trim($_POST['comment']) : null;

// If the user is logged in
$user = wp_get_current_user();
if ( $user->exists() ) {
	if ( empty( $user->display_name ) )
		$user->display_name=$user->user_login;
	$comment_author       = wp_slash( $user->display_name );
	$comment_author_email = wp_slash( $user->user_email );
	$comment_author_url   = wp_slash( $user->user_url );
	if ( current_user_can( 'unfiltered_html' ) ) {
		if ( ! isset( $_POST['_wp_unfiltered_html_comment'] )
			|| ! wp_verify_nonce( $_POST['_wp_unfiltered_html_comment'], 'unfiltered-html-comment_' . $comment_post_ID )
		) {
			kses_remove_filters(); // start with a clean slate
			kses_init_filters(); // set up the filters
		}
	}
} else {
	if ( get_option( 'comment_registration' ) || 'private' == $status ) {
		wp_die( __( 'Sorry, you must be logged in to post a comment.' ), 403 );
	}
}

$comment_type = '';

if ( get_option('require_name_email') ) {
	if ( '' == $comment_author ) {
		wp_die( __( '<strong>ERROR</strong>: please fill the required fields (name).' ), 200 );
	}
	/* Nexmo - Added phone number for verification */
	else if ( ! is_numeric( $comment_author_phone ) ) {
		wp_die( __( '<strong>ERROR</strong>: please enter a valid phone.' ), 200 );
	}
	else if ( '' == ( $comment_author_phone ) ) {
		wp_die( __( '<strong>ERROR</strong>: please enter a phone.' ), 200 );
	}
}

if ( '' == $comment_content ) {
	wp_die( __( '<strong>ERROR</strong>: please type a comment.' ), 200 );
}

$comment_parent = isset($_POST['comment_parent']) ? absint($_POST['comment_parent']) : 0;
/* Nexmo - Added phone number for verification */
$commentdata = compact('comment_post_ID', 'comment_author', 'comment_author_phone','comment_author_email', 'comment_author_url', 'comment_content', 'comment_type', 'comment_parent', 'user_ID');

$comment_id = wp_new_comment( $commentdata );
if ( ! $comment_id ) {
	wp_die( __( "<strong>ERROR</strong>: The comment could not be saved. Please try again later." ) );
}

$comment = get_comment( $comment_id );



/**
 * Perform other actions when comment cookies are set.
 *
 * @since 3.4.0
 *
 * @param object $comment Comment object.
 * @param WP_User $user   User object. The user may not exist.
 */
do_action( 'set_comment_cookies', $comment, $user );

/* Nexmo - Added phone number for verification */
//send code to phone
if(isset($comment_author_phone))
{
session_start();

include_once 'wp-content/plugins/Nexmopress/credentials.php';
    $number = $comment_author_phone;
    $code = rand(1000, 9999); // random 4 digit code
    $_SESSION['code'] = $code; // store code for later

    $url = 'https://rest.nexmo.com/sms/json?' . http_build_query(array(
            'api_key' => NEXMO_KEY,
            'api_secret' => NEXMO_SECRET,
            'from' => NEXMO_FROM,
            'to' => $number,
            'text' => 'Your verification code is: ' . $code
        ));

    $ch = curl_init($url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 2);
    $result = curl_exec($ch);
    curl_close($ch);

    

    

//some error checking
$data = json_decode($result, true);

if(!isset($data['messages'])){
        echo 'Unknown API Response';
    }
   foreach($data['messages'] as $message){
        if(0 != $message['status']){
            echo $message['error-text'];
        }
    }
    
$location = empty($_POST['redirect_to']) ? get_comment_link($comment_id) : $_POST['redirect_to']."#comment-".$comment;
$location = apply_filters( 'comment_post_redirect', $location);
wp_safe_redirect( $location);
exit;

}

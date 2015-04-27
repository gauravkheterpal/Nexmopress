<?php
/**
 * Comment template functions
 *
 * These functions are meant to live inside of the WordPress loop.
 *
 * @package WordPress
 * @subpackage Template
 */

/**
 * Retrieve the author of the current comment.
 *
 * If the comment has an empty comment_author field, then 'Anonymous' person is
 * assumed.
 *
 * @since 1.5.0
 *
 * @param int $comment_ID Optional. The ID of the comment for which to retrieve the author. Default current comment.
 * @return string The comment author
 */
function get_comment_author( $comment_ID = 0 ) {
	$comment = get_comment( $comment_ID );

	if ( empty( $comment->comment_author ) ) {
		if ( $comment->user_id && $user = get_userdata( $comment->user_id ) )
			$author = $user->display_name;
		else
			$author = __('Anonymous');
	} else {
		$author = $comment->comment_author;
	}

	/**
	 * Filter the returned comment author name.
	 *
	 * @since 1.5.0
	 * @since 4.1.0 The `$comment_ID` and `$comment` parameters were added.
	 *
	 * @param string $author     The comment author's username.
	 * @param int    $comment_ID The comment ID.
	 * @param object $comment    The comment object.
	 */
	return apply_filters( 'get_comment_author', $author, $comment_ID, $comment );
}

/**
 * Displays the author of the current comment.
 *
 * @since 0.71
 *
 * @param int $comment_ID Optional. The ID of the comment for which to print the author. Default current comment.
 */
function comment_author( $comment_ID = 0 ) {
	$author = get_comment_author( $comment_ID );

	/**
	 * Filter the comment author's name for display.
	 *
	 * @since 1.2.0
	 * @since 4.1.0 The `$comment_ID` parameter was added.
	 *
	 * @param string $author     The comment author's username.
	 * @param int    $comment_ID The comment ID.
	 */
	$author = apply_filters( 'comment_author', $author, $comment_ID );
	echo $author;
}

/**
 * Retrieve the email of the author of the current comment.
 *
 * @since 1.5.0
 *
 * @param int $comment_ID Optional. The ID of the comment for which to get the author's email. Default current comment.
 * @return string The current comment author's email
 */
function get_comment_author_email( $comment_ID = 0 ) {
	$comment = get_comment( $comment_ID );

	/**
	 * Filter the comment author's returned email address.
	 *
	 * @since 1.5.0
	 * @since 4.1.0 The `$comment_ID` and `$comment` parameters were added.
	 *
	 * @param string $comment_author_email The comment author's email address.
	 * @param int    $comment_ID           The comment ID.
	 * @param object $comment              The comment object.
	 */
	return apply_filters( 'get_comment_author_email', $comment->comment_author_email, $comment_ID, $comment );
}

/**
 * Display the email of the author of the current global $comment.
 *
 * Care should be taken to protect the email address and assure that email
 * harvesters do not capture your commentors' email address. Most assume that
 * their email address will not appear in raw form on the blog. Doing so will
 * enable anyone, including those that people don't want to get the email
 * address and use it for their own means good and bad.
 *
 * @since 0.71
 *
 * @param int $comment_ID Optional. The ID of the comment for which to print the author's email. Default current comment.
 */
function comment_author_email( $comment_ID = 0 ) {
	$author_email = get_comment_author_email( $comment_ID );

	/**
	 * Filter the comment author's email for display.
	 *
	 * @since 1.2.0
	 * @since 4.1.0 The `$comment_ID` parameter was added.
	 *
	 * @param string $author_email The comment author's email address.
	 * @param int    $comment_ID   The comment ID.
	 */
	echo apply_filters( 'author_email', $author_email, $comment_ID );
}


/**
 * Retrieve the phone number of the author of the current comment.
 *
 * @since 1.5.0
 *
 * @param int $comment_ID Optional. The ID of the comment for which to get the author's email. Default current comment.
 * @return string The current comment author's email
 */
function get_comment_author_phone( $comment_ID = 0 ) {
	$comment = get_comment( $comment_ID );

	/**
	 * Filter the comment author's returned email address.
	 *
	 * @since 1.5.0
	 * @since 4.1.0 The `$comment_ID` and `$comment` parameters were added.
	 *
	 * @param string $comment_author_email The comment author's email address.
	 * @param int    $comment_ID           The comment ID.
	 * @param object $comment              The comment object.
	 */
	return apply_filters( 'get_comment_author_phone', $comment->comment_author_phone, $comment_ID, $comment );
}

/**
 * Display the phone number of the author of the current global $comment.
 *
 * Care should be taken to protect the email address and assure that email
 * harvesters do not capture your commentors' email address. Most assume that
 * their email address will not appear in raw form on the blog. Doing so will
 * enable anyone, including those that people don't want to get the email
 * address and use it for their own means good and bad.
 *
 * @since 0.71
 *
 * @param int $comment_ID Optional. The ID of the comment for which to print the author's email. Default current comment.
 */
function comment_author_phone( $comment_ID = 0 ) {
	$author_phone = get_comment_author_phone( $comment_ID );

	/**
	 * Filter the comment author's email for display.
	 *
	 * @since 1.2.0
	 * @since 4.1.0 The `$comment_ID` parameter was added.
	 *
	 * @param string $author_email The comment author's email address.
	 * @param int    $comment_ID   The comment ID.
	 */
	echo apply_filters( 'author_phone', $author_phone, $comment_ID );
}
/**
 * Display the html email link to the author of the current comment.
 *
 * Care should be taken to protect the email address and assure that email
 * harvesters do not capture your commentors' email address. Most assume that
 * their email address will not appear in raw form on the blog. Doing so will
 * enable anyone, including those that people don't want to get the email
 * address and use it for their own means good and bad.
 *
 * @since 0.71
 *
 * @param string $linktext Optional. Text to display instead of the comment author's email address.
 *                         Default empty.
 * @param string $before   Optional. Text or HTML to display before the email link. Default empty.
 * @param string $after    Optional. Text or HTML to display after the email link. Default empty.
 */
function comment_author_email_link( $linktext = '', $before = '', $after = '' ) {
	if ( $link = get_comment_author_email_link( $linktext, $before, $after ) )
		echo $link;
}

/**
 * Return the html email link to the author of the current comment.
 *
 * Care should be taken to protect the email address and assure that email
 * harvesters do not capture your commentors' email address. Most assume that
 * their email address will not appear in raw form on the blog. Doing so will
 * enable anyone, including those that people don't want to get the email
 * address and use it for their own means good and bad.
 *
 * @global object $comment The current Comment row object.
 *
 * @since 2.7.0
 *
 * @param string $linktext Optional. Text to display instead of the comment author's email address.
 *                         Default empty.
 * @param string $before   Optional. Text or HTML to display before the email link. Default empty.
 * @param string $after    Optional. Text or HTML to display after the email link. Default empty.
 */
function get_comment_author_email_link( $linktext = '', $before = '', $after = '' ) {
	global $comment;

	/**
	 * Filter the comment author's email for display.
	 *
	 * Care should be taken to protect the email address and assure that email
	 * harvesters do not capture your commenter's email address.
	 *
	 * @since 1.2.0
	 * @since 4.1.0 The `$comment` parameter was added.
	 *
	 * @param string $comment_author_email The comment author's email address.
	 * @param object $comment              The comment object.
	 */
	$email = apply_filters( 'comment_email', $comment->comment_author_email, $comment );
	if ((!empty($email)) && ($email != '@')) {
	$display = ($linktext != '') ? $linktext : $email;
		$return  = $before;
		$return .= "<a href='mailto:$email'>$display</a>";
	 	$return .= $after;
		return $return;
	} else {
		return '';
	}
}

/**
 * Retrieve the HTML link to the URL of the author of the current comment.
 *
 * Both get_comment_author_url() and get_comment_author() rely on get_comment(),
 * which falls back to the global comment variable if the $comment_ID argument is empty.
 *
 * @since 1.5.0
 *
 * @param int $comment_ID ID of the comment for which to get the author's link.
 *                        Default current comment.
 * @return string The comment author name or HTML link for author's URL.
 */
function get_comment_author_link( $comment_ID = 0 ) {
	$url    = get_comment_author_url( $comment_ID );
	$author = get_comment_author( $comment_ID );

	if ( empty( $url ) || 'http://' == $url )
		$return = $author;
	else
		$return = "<a href='$url' rel='external nofollow' class='url'>$author</a>";

	/**
	 * Filter the comment author's link for display.
	 *
	 * @since 1.5.0
	 * @since 4.1.0 The `$author` and `$comment_ID` parameters were added.
	 *
	 * @param string $return     The HTML-formatted comment author link.
	 *                           Empty for an invalid URL.
	 * @param string $author     The comment author's username.
	 * @param int    $comment_ID The comment ID.
	 */
	return apply_filters( 'get_comment_author_link', $return, $author, $comment_ID );
}

/**
 * Display the html link to the url of the author of the current comment.
 *
 * @since 0.71
 *
 * @see get_comment_author_link() Echoes result
 *
 * @param int $comment_ID ID of the comment for which to print the author's
 *                        link. Default current comment.
 */
function comment_author_link( $comment_ID = 0 ) {
	echo get_comment_author_link( $comment_ID );
}

/**
 * Retrieve the IP address of the author of the current comment.
 *
 * @since 1.5.0
 *
 * @param int $comment_ID ID of the comment for which to get the author's IP
 *                        address. Default current comment.
 * @return string Comment author's IP address.
 */
function get_comment_author_IP( $comment_ID = 0 ) {
	$comment = get_comment( $comment_ID );

	/**
	 * Filter the comment author's returned IP address.
	 *
	 * @since 1.5.0
	 * @since 4.1.0 The `$comment_ID` and `$comment` parameters were added.
	 *
	 * @param string $comment_author_IP The comment author's IP address.
	 * @param int    $comment_ID        The comment ID.
	 * @param object $comment           The comment object.
	 */
	return apply_filters( 'get_comment_author_IP', $comment->comment_author_IP, $comment_ID, $comment );
}

/**
 * Display the IP address of the author of the current comment.
 *
 * @since 0.71
 *
 * @param int $comment_ID ID of the comment for which to print the author's IP
 *                        address. Default current comment.
 */
function comment_author_IP( $comment_ID = 0 ) {
	echo get_comment_author_IP( $comment_ID );
}

/**
 * Retrieve the url of the author of the current comment.
 *
 * @since 1.5.0
 *
 * @param int $comment_ID ID of the comment for which to get the author's URL.
 *                        Default current comment.
 * @return string
 */
function get_comment_author_url( $comment_ID = 0 ) {
	$comment = get_comment( $comment_ID );
	$url = ('http://' == $comment->comment_author_url) ? '' : $comment->comment_author_url;
	$url = esc_url( $url, array('http', 'https') );

	/**
	 * Filter the comment author's URL.
	 *
	 * @since 1.5.0
	 * @since 4.1.0 The `$comment_ID` and `$comment` parameters were added.
	 *
	 * @param string $url        The comment author's URL.
	 * @param int    $comment_ID The comment ID.
	 * @param object $comment    The comment object.
	 */
	return apply_filters( 'get_comment_author_url', $url, $comment_ID, $comment );
}

/**
 * Display the url of the author of the current comment.
 *
 * @since 0.71
 *
 * @param int $comment_ID ID of the comment for which to print the author's URL.
 *                        Default current comment.
 */
function comment_author_url( $comment_ID = 0 ) {
	$author_url = get_comment_author_url( $comment_ID );

	/**
	 * Filter the comment author's URL for display.
	 *
	 * @since 1.2.0
	 * @since 4.1.0 The `$comment_ID` parameter was added.
	 *
	 * @param string $author_url The comment author's URL.
	 * @param int    $comment_ID The comment ID.
	 */
	echo apply_filters( 'comment_url', $author_url, $comment_ID );
}

/**
 * Retrieves the HTML link of the url of the author of the current comment.
 *
 * $linktext parameter is only used if the URL does not exist for the comment
 * author. If the URL does exist then the URL will be used and the $linktext
 * will be ignored.
 *
 * Encapsulate the HTML link between the $before and $after. So it will appear
 * in the order of $before, link, and finally $after.
 *
 * @since 1.5.0
 *
 * @param string $linktext Optional. The text to display instead of the comment
 *                         author's email address. Default empty.
 * @param string $before   Optional. The text or HTML to display before the email link.
 *                         Default empty.
 * @param string $after    Optional. The text or HTML to display after the email link.
 *                         Default empty.
 * @return string The HTML link between the $before and $after parameters.
 */
function get_comment_author_url_link( $linktext = '', $before = '', $after = '' ) {
	$url = get_comment_author_url();
	$display = ($linktext != '') ? $linktext : $url;
	$display = str_replace( 'http://www.', '', $display );
	$display = str_replace( 'http://', '', $display );

	if ( '/' == substr($display, -1) ) {
		$display = substr($display, 0, -1);
	}

	$return = "$before<a href='$url' rel='external'>$display</a>$after";

	/**
	 * Filter the comment author's returned URL link.
	 *
	 * @since 1.5.0
	 *
	 * @param string $return The HTML-formatted comment author URL link.
	 */
	return apply_filters( 'get_comment_author_url_link', $return );
}

/**
 * Displays the HTML link of the url of the author of the current comment.
 *
 * @since 0.71
 *
 * @param string $linktext Optional. Text to display instead of the comment author's
 *                         email address. Default empty.
 * @param string $before   Optional. Text or HTML to display before the email link.
 *                         Default empty.
 * @param string $after    Optional. Text or HTML to display after the email link.
 *                         Default empty.
 */
function comment_author_url_link( $linktext = '', $before = '', $after = '' ) {
	echo get_comment_author_url_link( $linktext, $before, $after );
}

/**
 * Generates semantic classes for each comment element.
 *
 * @since 2.7.0
 *
 * @param string|array $class      Optional. One or more classes to add to the class list.
 *                                 Default empty.
 * @param int          $comment_id Comment ID. Default current comment.
 * @param int|WP_Post  $post_id    Post ID or WP_Post object. Default current post.
 * @param bool         $echo       Optional. Whether to cho or return the output.
 *                                 Default true.
 */
function comment_class( $class = '', $comment_id = null, $post_id = null, $echo = true ) {
	// Separates classes with a single space, collates classes for comment DIV
	$class = 'class="' . join( ' ', get_comment_class( $class, $comment_id, $post_id ) ) . '"';
	if ( $echo)
		echo $class;
	else
		return $class;
}

/**
 * Returns the classes for the comment div as an array.
 *
 * @since 2.7.0
 *
 * @param string|array $class      Optional. One or more classes to add to the class list. Default empty.
 * @param int          $comment_id Comment ID. Default current comment.
 * @param int|WP_Post  $post_id    Post ID or WP_Post object. Default current post.
 * @return array An array of classes.
 */
function get_comment_class( $class = '', $comment_id = null, $post_id = null ) {
	global $comment_alt, $comment_depth, $comment_thread_alt;

	$comment = get_comment($comment_id);

	$classes = array();

	// Get the comment type (comment, trackback),
	$classes[] = ( empty( $comment->comment_type ) ) ? 'comment' : $comment->comment_type;

	// If the comment author has an id (registered), then print the log in name
	if ( $comment->user_id > 0 && $user = get_userdata($comment->user_id) ) {
		// For all registered users, 'byuser'
		$classes[] = 'byuser';
		$classes[] = 'comment-author-' . sanitize_html_class($user->user_nicename, $comment->user_id);
		// For comment authors who are the author of the post
		if ( $post = get_post($post_id) ) {
			if ( $comment->user_id === $post->post_author )
				$classes[] = 'bypostauthor';
		}
	}

	if ( empty($comment_alt) )
		$comment_alt = 0;
	if ( empty($comment_depth) )
		$comment_depth = 1;
	if ( empty($comment_thread_alt) )
		$comment_thread_alt = 0;

	if ( $comment_alt % 2 ) {
		$classes[] = 'odd';
		$classes[] = 'alt';
	} else {
		$classes[] = 'even';
	}

	$comment_alt++;

	// Alt for top-level comments
	if ( 1 == $comment_depth ) {
		if ( $comment_thread_alt % 2 ) {
			$classes[] = 'thread-odd';
			$classes[] = 'thread-alt';
		} else {
			$classes[] = 'thread-even';
		}
		$comment_thread_alt++;
	}

	$classes[] = "depth-$comment_depth";

	if ( !empty($class) ) {
		if ( !is_array( $class ) )
			$class = preg_split('#\s+#', $class);
		$classes = array_merge($classes, $class);
	}

	$classes = array_map('esc_attr', $classes);

	/**
	 * Filter the returned CSS classes for the current comment.
	 *
	 * @since 2.7.0
	 *
	 * @param array       $classes    An array of comment classes.
	 * @param string      $class      A comma-separated list of additional classes added to the list.
	 * @param int         $comment_id The comment id.
	 * @param object   	  $comment    The comment
	 * @param int|WP_Post $post_id    The post ID or WP_Post object.
	 */
	return apply_filters( 'comment_class', $classes, $class, $comment_id, $comment, $post_id );
}

/**
 * Retrieve the comment date of the current comment.
 *
 * @since 1.5.0
 *
 * @param string $d          Optional. The format of the date. Default user's setting.
 * @param int    $comment_ID ID of the comment for which to get the date. Default current comment.
 * @return string The comment's date.
 */
function get_comment_date( $d = '', $comment_ID = 0 ) {
	$comment = get_comment( $comment_ID );
	if ( '' == $d )
		$date = mysql2date(get_option('date_format'), $comment->comment_date);
	else
		$date = mysql2date($d, $comment->comment_date);
	/**
	 * Filter the returned comment date.
	 *
	 * @since 1.5.0
	 *
	 * @param string|int $date    Formatted date string or Unix timestamp.
	 * @param string     $d       The format of the date.
	 * @param object     $comment The comment object.
	 */
	return apply_filters( 'get_comment_date', $date, $d, $comment );
}

/**
 * Display the comment date of the current comment.
 *
 * @since 0.71
 *
 * @param string $d          Optional. The format of the date. Default user's settings.
 * @param int    $comment_ID ID of the comment for which to print the date. Default current comment.
 */
function comment_date( $d = '', $comment_ID = 0 ) {
	echo get_comment_date( $d, $comment_ID );
}

/**
 * Retrieve the excerpt of the current comment.
 *
 * Will cut each word and only output the first 20 words with '&hellip;' at the end.
 * If the word count is less than 20, then no truncating is done and no '&hellip;'
 * will appear.
 *
 * @since 1.5.0
 *
 * @param int $comment_ID ID of the comment for which to get the excerpt.
 *                        Default current comment.
 * @return string The maybe truncated comment with 20 words or less.
 */
function get_comment_excerpt( $comment_ID = 0 ) {
	$comment = get_comment( $comment_ID );
	$comment_text = strip_tags($comment->comment_content);
	$blah = explode(' ', $comment_text);

	if (count($blah) > 20) {
		$k = 20;
		$use_dotdotdot = 1;
	} else {
		$k = count($blah);
		$use_dotdotdot = 0;
	}

	$excerpt = '';
	for ($i=0; $i<$k; $i++) {
		$excerpt .= $blah[$i] . ' ';
	}
	$excerpt .= ($use_dotdotdot) ? '&hellip;' : '';

	/**
	 * Filter the retrieved comment excerpt.
	 *
	 * @since 1.5.0
	 * @since 4.1.0 The `$comment_ID` and `$comment` parameters were added.
	 *
	 * @param string $excerpt    The comment excerpt text.
	 * @param int    $comment_ID The comment ID.
	 * @param object $comment    The comment object.
	 */
	return apply_filters( 'get_comment_excerpt', $excerpt, $comment_ID, $comment );
}

/**
 * Display the excerpt of the current comment.
 *
 * @since 1.2.0
 *
 * @param int $comment_ID ID of the comment for which to print the excerpt.
 *                        Default current comment.
 */
function comment_excerpt( $comment_ID = 0 ) {
	$comment_excerpt = get_comment_excerpt($comment_ID);

	/**
	 * Filter the comment excerpt for display.
	 *
	 * @since 1.2.0
	 * @since 4.1.0 The `$comment_ID` parameter was added.
	 *
	 * @param string $comment_excerpt The comment excerpt text.
	 * @param int    $comment_ID      The comment ID.
	 */
	echo apply_filters( 'comment_excerpt', $comment_excerpt, $comment_ID );
}

/**
 * Retrieve the comment id of the current comment.
 *
 * @since 1.5.0
 *
 * @return int The comment ID.
 */
function get_comment_ID() {
	global $comment;

	/**
	 * Filter the returned comment ID.
	 *
	 * @since 1.5.0
	 * @since 4.1.0 The `$comment_ID` parameter was added.
	 *
	 * @param int    $comment_ID The current comment ID.
	 * @param object $comment    The comment object.
	 */
	return apply_filters( 'get_comment_ID', $comment->comment_ID, $comment );
}

/**
 * Display the comment id of the current comment.
 *
 * @since 0.71
 */
function comment_ID() {
	echo get_comment_ID();
}

/**
 * Retrieve the link to a given comment.
 *
 * @since 1.5.0
 *
 * @see get_page_of_comment()
 *
 * @param mixed $comment Comment to retrieve. Default current comment.
 * @param array $args    Optional. An array of arguments to override the defaults.
 * @return string The permalink to the given comment.
 */
function get_comment_link( $comment = null, $args = array() ) {
	global $wp_rewrite, $in_comment_loop;

	$comment = get_comment($comment);

	// Backwards compat
	if ( ! is_array( $args ) ) {
		$args = array( 'page' => $args );
	}

	$defaults = array( 'type' => 'all', 'page' => '', 'per_page' => '', 'max_depth' => '' );
	$args = wp_parse_args( $args, $defaults );

	if ( '' === $args['per_page'] && get_option('page_comments') )
		$args['per_page'] = get_option('comments_per_page');

	if ( empty($args['per_page']) ) {
		$args['per_page'] = 0;
		$args['page'] = 0;
	}

	if ( $args['per_page'] ) {
		if ( '' == $args['page'] )
			$args['page'] = ( !empty($in_comment_loop) ) ? get_query_var('cpage') : get_page_of_comment( $comment->comment_ID, $args );

		if ( $wp_rewrite->using_permalinks() )
			$link = user_trailingslashit( trailingslashit( get_permalink( $comment->comment_post_ID ) ) . 'comment-page-' . $args['page'], 'comment' );
		else
			$link = add_query_arg( 'cpage', $args['page'], get_permalink( $comment->comment_post_ID ) );
	} else {
		$link = get_permalink( $comment->comment_post_ID );
	}

	$link = $link . '#comment-' . $comment->comment_ID;
	/**
	 * Filter the returned single comment permalink.
	 *
	 * @since 2.8.0
	 *
	 * @see get_page_of_comment()
	 *
	 * @param string $link    The comment permalink with '#comment-$id' appended.
	 * @param object $comment The current comment object.
	 * @param array  $args    An array of arguments to override the defaults.
	 */
	return apply_filters( 'get_comment_link', $link, $comment, $args );
}

/**
 * Retrieve the link to the current post comments.
 *
 * @since 1.5.0
 *
 * @param int|WP_Post $post_id Optional. Post ID or WP_Post object. Default is global $post.
 * @return string The link to the comments.
 */
function get_comments_link( $post_id = 0 ) {
	$comments_link = get_permalink( $post_id ) . '#comments';
	/**
	 * Filter the returned post comments permalink.
	 *
	 * @since 3.6.0
	 *
	 * @param string      $comments_link Post comments permalink with '#comments' appended.
	 * @param int|WP_Post $post_id       Post ID or WP_Post object.
	 */
	return apply_filters( 'get_comments_link', $comments_link, $post_id );
}

/**
 * Display the link to the current post comments.
 *
 * @since 0.71
 *
 * @param string $deprecated   Not Used.
 * @param string $deprecated_2 Not Used.
 */
function comments_link( $deprecated = '', $deprecated_2 = '' ) {
	if ( !empty( $deprecated ) )
		_deprecated_argument( __FUNCTION__, '0.72' );
	if ( !empty( $deprecated_2 ) )
		_deprecated_argument( __FUNCTION__, '1.3' );
	echo esc_url( get_comments_link() );
}

/**
 * Retrieve the amount of comments a post has.
 *
 * @since 1.5.0
 *
 * @param int|WP_Post $post_id Optional. Post ID or WP_Post object. Default is global $post.
 * @return int The number of comments a post has.
 */
function get_comments_number( $post_id = 0 ) {
	$post = get_post( $post_id );

	if ( ! $post ) {
		$count = 0;
	} else {
		$count = $post->comment_count;
		$post_id = $post->ID;
	}

	/**
	 * Filter the returned comment count for a post.
	 *
	 * @since 1.5.0
	 *
	 * @param int $count   Number of comments a post has.
	 * @param int $post_id Post ID.
	 */
	return apply_filters( 'get_comments_number', $count, $post_id );
}

/**
 * Display the language string for the number of comments the current post has.
 *
 * @since 0.71
 *
 * @param string $zero       Optional. Text for no comments. Default false.
 * @param string $one        Optional. Text for one comment. Default false.
 * @param string $more       Optional. Text for more than one comment. Default false.
 * @param string $deprecated Not used.
 */
function comments_number( $zero = false, $one = false, $more = false, $deprecated = '' ) {
	if ( ! empty( $deprecated ) ) {
		_deprecated_argument( __FUNCTION__, '1.3' );
	}
	echo get_comments_number_text( $zero, $one, $more );
}

/**
 * Display the language string for the number of comments the current post has.
 *
 * @since 4.0.0
 *
 * @param string $zero Optional. Text for no comments. Default false.
 * @param string $one  Optional. Text for one comment. Default false.
 * @param string $more Optional. Text for more than one comment. Default false.
 */
function get_comments_number_text( $zero = false, $one = false, $more = false ) {
	$number = get_comments_number();

	if ( $number > 1 ) {
		$output = str_replace( '%', number_format_i18n( $number ), ( false === $more ) ? __( '% Comments' ) : $more );
	} elseif ( $number == 0 ) {
		$output = ( false === $zero ) ? __( 'No Comments' ) : $zero;
	} else { // must be one
		$output = ( false === $one ) ? __( '1 Comment' ) : $one;
	}
	/**
	 * Filter the comments count for display.
	 *
	 * @since 1.5.0
	 *
	 * @see _n()
	 *
	 * @param string $output A translatable string formatted based on whether the count
	 *                       is equal to 0, 1, or 1+.
	 * @param int    $number The number of post comments.
	 */
	return apply_filters( 'comments_number', $output, $number );
}

/**
 * Retrieve the text of the current comment.
 *
 * @since 1.5.0
 *
 * @see Walker_Comment::comment()
 *
 * @param int   $comment_ID ID of the comment for which to get the text. Default current comment.
 * @param array $args       Optional. An array of arguments. Default empty.
 * @return string The comment content.
 */
function get_comment_text( $comment_ID = 0, $args = array() ) {
	$comment = get_comment( $comment_ID );

	/**
	 * Filter the text of a comment.
	 *
	 * @since 1.5.0
	 *
	 * @see Walker_Comment::comment()
	 *
	 * @param string $comment_content Text of the comment.
	 * @param object $comment         The comment object.
	 * @param array  $args            An array of arguments.
	 */
	return apply_filters( 'get_comment_text', $comment->comment_content, $comment, $args );
}

/**
 * Display the text of the current comment.
 *
 * @since 0.71
 *
 * @see Walker_Comment::comment()
 *
 * @param int   $comment_ID ID of the comment for which to print the text. Default 0.
 * @param array $args       Optional. An array of arguments. Default empty array. Default empty.
 */
function comment_text( $comment_ID = 0, $args = array() ) {
	$comment = get_comment( $comment_ID );

	$comment_text = get_comment_text( $comment_ID , $args );
	/**
	 * Filter the text of a comment to be displayed.
	 *
	 * @since 1.2.0
	 *
	 * @see Walker_Comment::comment()
	 *
	 * @param string $comment_text Text of the current comment.
	 * @param object $comment      The comment object.
	 * @param array  $args         An array of arguments.
	 */
	echo apply_filters( 'comment_text', $comment_text, $comment, $args );
}

/**
 * Retrieve the comment time of the current comment.
 *
 * @since 1.5.0
 *
 * @param string $d         Optional. The format of the time. Default user's settings.
 * @param bool   $gmt       Optional. Whether to use the GMT date. Default false.
 * @param bool   $translate Optional. Whether to translate the time (for use in feeds).
 *                          Default true.
 * @return string The formatted time.
 */
function get_comment_time( $d = '', $gmt = false, $translate = true ) {
	global $comment;
	$comment_date = $gmt ? $comment->comment_date_gmt : $comment->comment_date;
	if ( '' == $d )
		$date = mysql2date(get_option('time_format'), $comment_date, $translate);
	else
		$date = mysql2date($d, $comment_date, $translate);

	/**
	 * Filter the returned comment time.
	 *
	 * @since 1.5.0
	 *
	 * @param string|int $date      The comment time, formatted as a date string or Unix timestamp.
	 * @param string     $d         Date format.
	 * @param bool       $gmt       Whether the GMT date is in use.
	 * @param bool       $translate Whether the time is translated.
	 * @param object     $comment   The comment object.
	 */
	return apply_filters( 'get_comment_time', $date, $d, $gmt, $translate, $comment );
}

/**
 * Display the comment time of the current comment.
 *
 * @since 0.71
 *
 * @param string $d Optional. The format of the time. Default user's settings.
 */
function comment_time( $d = '' ) {
	echo get_comment_time($d);
}

/**
 * Retrieve the comment type of the current comment.
 *
 * @since 1.5.0
 *
 * @param int $comment_ID ID of the comment for which to get the type. Default current comment.
 * @return string The comment type.
 */
function get_comment_type( $comment_ID = 0 ) {
	$comment = get_comment( $comment_ID );
	if ( '' == $comment->comment_type )
		$comment->comment_type = 'comment';

	/**
	 * Filter the returned comment type.
	 *
	 * @since 1.5.0
	 * @since 4.1.0 The `$comment_ID` and `$comment` parameters were added.
	 *
	 * @param string $comment_type The type of comment, such as 'comment', 'pingback', or 'trackback'.
	 * @param int 	 $comment_ID   The comment ID.
	 * @param object $comment      The comment object.
	 */
	return apply_filters( 'get_comment_type', $comment->comment_type, $comment_ID, $comment );
}

/**
 * Display the comment type of the current comment.
 *
 * @since 0.71
 *
 * @param string $commenttxt   Optional. String to display for comment type. Default false.
 * @param string $trackbacktxt Optional. String to display for trackback type. Default false.
 * @param string $pingbacktxt  Optional. String to display for pingback type. Default false.
 */
function comment_type( $commenttxt = false, $trackbacktxt = false, $pingbacktxt = false ) {
	if ( false === $commenttxt ) $commenttxt = _x( 'Comment', 'noun' );
	if ( false === $trackbacktxt ) $trackbacktxt = __( 'Trackback' );
	if ( false === $pingbacktxt ) $pingbacktxt = __( 'Pingback' );
	$type = get_comment_type();
	switch( $type ) {
		case 'trackback' :
			echo $trackbacktxt;
			break;
		case 'pingback' :
			echo $pingbacktxt;
			break;
		default :
			echo $commenttxt;
	}
}

/**
 * Retrieve The current post's trackback URL.
 *
 * There is a check to see if permalink's have been enabled and if so, will
 * retrieve the pretty path. If permalinks weren't enabled, the ID of the
 * current post is used and appended to the correct page to go to.
 *
 * @since 1.5.0
 *
 * @return string The trackback URL after being filtered.
 */
function get_trackback_url() {
	if ( '' != get_option('permalink_structure') )
		$tb_url = trailingslashit(get_permalink()) . user_trailingslashit('trackback', 'single_trackback');
	else
		$tb_url = get_option('siteurl') . '/wp-trackback.php?p=' . get_the_ID();

	/**
	 * Filter the returned trackback URL.
	 *
	 * @since 2.2.0
	 *
	 * @param string $tb_url The trackback URL.
	 */
	return apply_filters( 'trackback_url', $tb_url );
}

/**
 * Display the current post's trackback URL.
 *
 * @since 0.71
 *
 * @param bool $deprecated_echo Not used.
 * @return void|string Should only be used to echo the trackback URL, use get_trackback_url()
 *                     for the result instead.
 */
function trackback_url( $deprecated_echo = true ) {
	if ( $deprecated_echo !== true )
		_deprecated_argument( __FUNCTION__, '2.5', __('Use <code>get_trackback_url()</code> instead if you do not want the value echoed.') );
	if ( $deprecated_echo )
		echo get_trackback_url();
	else
		return get_trackback_url();
}

/**
 * Generate and display the RDF for the trackback information of current post.
 *
 * Deprecated in 3.0.0, and restored in 3.0.1.
 *
 * @since 0.71
 *
 * @param int $deprecated Not used (Was $timezone = 0).
 */
function trackback_rdf( $deprecated = '' ) {
	if ( ! empty( $deprecated ) ) {
		_deprecated_argument( __FUNCTION__, '2.5' );
	}

	if ( isset( $_SERVER['HTTP_USER_AGENT'] ) && false !== stripos( $_SERVER['HTTP_USER_AGENT'], 'W3C_Validator' ) ) {
		return;
	}

	echo '<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
			xmlns:dc="http://purl.org/dc/elements/1.1/"
			xmlns:trackback="http://madskills.com/public/xml/rss/module/trackback/">
		<rdf:Description rdf:about="';
	the_permalink();
	echo '"'."\n";
	echo '    dc:identifier="';
	the_permalink();
	echo '"'."\n";
	echo '    dc:title="'.str_replace('--', '&#x2d;&#x2d;', wptexturize(strip_tags(get_the_title()))).'"'."\n";
	echo '    trackback:ping="'.get_trackback_url().'"'." />\n";
	echo '</rdf:RDF>';
}

/**
 * Whether the current post is open for comments.
 *
 * @since 1.5.0
 *
 * @param int|WP_Post $post_id Post ID or WP_Post object. Default current post.
 * @return bool True if the comments are open.
 */
function comments_open( $post_id = null ) {

	$_post = get_post($post_id);

	$open = ( 'open' == $_post->comment_status );

	/**
	 * Filter whether the current post is open for comments.
	 *
	 * @since 2.5.0
	 *
	 * @param bool        $open    Whether the current post is open for comments.
	 * @param int|WP_Post $post_id The post ID or WP_Post object.
	 */
	return apply_filters( 'comments_open', $open, $post_id );
}

/**
 * Whether the current post is open for pings.
 *
 * @since 1.5.0
 *
 * @param int|WP_Post $post_id Post ID or WP_Post object. Default current post.
 * @return bool True if pings are accepted
 */
function pings_open( $post_id = null ) {

	$_post = get_post($post_id);

	$open = ( 'open' == $_post->ping_status );

	/**
	 * Filter whether the current post is open for pings.
	 *
	 * @since 2.5.0
	 *
	 * @param bool        $open    Whether the current post is open for pings.
	 * @param int|WP_Post $post_id The post ID or WP_Post object.
	 */
	return apply_filters( 'pings_open', $open, $post_id );
}

/**
 * Display form token for unfiltered comments.
 *
 * Will only display nonce token if the current user has permissions for
 * unfiltered html. Won't display the token for other users.
 *
 * The function was backported to 2.0.10 and was added to versions 2.1.3 and
 * above. Does not exist in versions prior to 2.0.10 in the 2.0 branch and in
 * the 2.1 branch, prior to 2.1.3. Technically added in 2.2.0.
 *
 * Backported to 2.0.10.
 *
 * @since 2.1.3
 */
function wp_comment_form_unfiltered_html_nonce() {
	$post = get_post();
	$post_id = $post ? $post->ID : 0;

	if ( current_user_can( 'unfiltered_html' ) ) {
		wp_nonce_field( 'unfiltered-html-comment_' . $post_id, '_wp_unfiltered_html_comment_disabled', false );
		echo "<script>(function(){if(window===window.parent){document.getElementById('_wp_unfiltered_html_comment_disabled').name='_wp_unfiltered_html_comment';}})();</script>\n";
	}
}

/**
 * Load the comment template specified in $file.
 *
 * Will not display the comments template if not on single post or page, or if
 * the post does not have comments.
 *
 * Uses the WordPress database object to query for the comments. The comments
 * are passed through the 'comments_array' filter hook with the list of comments
 * and the post ID respectively.
 *
 * The $file path is passed through a filter hook called, 'comments_template'
 * which includes the TEMPLATEPATH and $file combined. Tries the $filtered path
 * first and if it fails it will require the default comment template from the
 * default theme. If either does not exist, then the WordPress process will be
 * halted. It is advised for that reason, that the default theme is not deleted.
 *
 * @todo Document globals
 * @uses $withcomments Will not try to get the comments if the post has none.
 *
 * @since 1.5.0
 *
 * @param string $file              Optional. The file to load. Default '/comments.php'.
 * @param bool   $separate_comments Optional. Whether to separate the comments by comment type.
 *                                  Default false.
 * @return null Returns null if no comments appear.
 */
function comments_template( $file = '/comments.php', $separate_comments = false ) {
	global $wp_query, $withcomments, $post, $wpdb, $id, $comment, $user_login, $user_ID, $user_identity, $overridden_cpage;

	if ( !(is_single() || is_page() || $withcomments) || empty($post) )
		return;

	if ( empty($file) )
		$file = '/comments.php';

	$req = get_option('require_name_email');

	/*
	 * Comment author information fetched from the comment cookies.
	 * Uuses wp_get_current_commenter().
	 */
	$commenter = wp_get_current_commenter();

	/*
	 * The name of the current comment author escaped for use in attributes.
	 * Escaped by sanitize_comment_cookies().
	 */
	$comment_author = $commenter['comment_author'];

	/*
	 * The email address of the current comment author escaped for use in attributes.
	 * Escaped by sanitize_comment_cookies().
	 */
	$comment_author_email = $commenter['comment_author_email'];

	/*
	 * The url of the current comment author escaped for use in attributes.
	 */
	$comment_author_url = esc_url($commenter['comment_author_url']);

	/* Nexmo - Added phone number for verification */

	$comment_author_phone= $commenter['comment_author_phone'];

	$comment_args = array(
		'order'   => 'ASC',
		'orderby' => 'comment_date_gmt',
		'status'  => 'approve',
		'post_id' => $post->ID,
	);

	if ( $user_ID ) {
		$comment_args['include_unapproved'] = array( $user_ID );
	} else if ( ! empty( $comment_author_email ) ) {
		$comment_args['include_unapproved'] = array( $comment_author_email );
	}

	$comments = get_comments( $comment_args );

	/**
	 * Filter the comments array.
	 *
	 * @since 2.1.0
	 *
	 * @param array $comments Array of comments supplied to the comments template.
	 * @param int   $post_ID  Post ID.
	 */
	$wp_query->comments = apply_filters( 'comments_array', $comments, $post->ID );
	$comments = &$wp_query->comments;
	$wp_query->comment_count = count($wp_query->comments);
	update_comment_cache($wp_query->comments);

	if ( $separate_comments ) {
		$wp_query->comments_by_type = separate_comments($comments);
		$comments_by_type = &$wp_query->comments_by_type;
	}

	$overridden_cpage = false;
	if ( '' == get_query_var('cpage') && get_option('page_comments') ) {
		set_query_var( 'cpage', 'newest' == get_option('default_comments_page') ? get_comment_pages_count() : 1 );
		$overridden_cpage = true;
	}

	if ( !defined('COMMENTS_TEMPLATE') )
		define('COMMENTS_TEMPLATE', true);

	$theme_template = STYLESHEETPATH . $file;
	/**
	 * Filter the path to the theme template file used for the comments template.
	 *
	 * @since 1.5.1
	 *
	 * @param string $theme_template The path to the theme template file.
	 */
	$include = apply_filters( 'comments_template', $theme_template );
	if ( file_exists( $include ) )
		require( $include );
	elseif ( file_exists( TEMPLATEPATH . $file ) )
		require( TEMPLATEPATH . $file );
	else // Backward compat code will be removed in a future release
		require( ABSPATH . WPINC . '/theme-compat/comments.php');
}

/**
 * Display the JS popup script to show a comment.
 *
 * If the $file parameter is empty, then the home page is assumed. The defaults
 * for the window are 400px by 400px.
 *
 * For the comment link popup to work, this function has to be called or the
 * normal comment link will be assumed.
 *
 * @global string $wpcommentspopupfile  The URL to use for the popup window.
 * @global int    $wpcommentsjavascript Whether to use JavaScript. Set when function is called.
 *
 * @since 0.71
 *
 * @param int $width  Optional. The width of the popup window. Default 400.
 * @param int $height Optional. The height of the popup window. Default 400.
 * @param string $file Optional. Sets the location of the popup window.
 */
function comments_popup_script( $width = 400, $height = 400, $file = '' ) {
	global $wpcommentspopupfile, $wpcommentsjavascript;

	if (empty ($file)) {
		$wpcommentspopupfile = '';  // Use the index.
	} else {
		$wpcommentspopupfile = $file;
	}

	$wpcommentsjavascript = 1;
	$javascript = "<script type='text/javascript'>\nfunction wpopen (macagna) {\n    window.open(macagna, '_blank', 'width=$width,height=$height,scrollbars=yes,status=yes');\n}\n</script>\n";
	echo $javascript;
}

/**
 * Displays the link to the comments popup window for the current post ID.
 *
 * Is not meant to be displayed on single posts and pages. Should be used
 * on the lists of posts
 *
 * @global string $wpcommentspopupfile  The URL to use for the popup window.
 * @global int    $wpcommentsjavascript Whether to use JavaScript. Set when function is called.
 *
 * @since 0.71
 *
 * @param string $zero      Optional. String to display when no comments. Default false.
 * @param string $one       Optional. String to display when only one comment is available.
 *                          Default false.
 * @param string $more      Optional. String to display when there are more than one comment.
 *                          Default false.
 * @param string $css_class Optional. CSS class to use for comments. Default empty.
 * @param string $none      Optional. String to display when comments have been turned off.
 *                          Default false.
 * @return null Returns null on single posts and pages.
 */
function comments_popup_link( $zero = false, $one = false, $more = false, $css_class = '', $none = false ) {
	global $wpcommentspopupfile, $wpcommentsjavascript;

	$id = get_the_ID();

	if ( false === $zero ) $zero = __( 'No Comments' );
	if ( false === $one ) $one = __( '1 Comment' );
	if ( false === $more ) $more = __( '% Comments' );
	if ( false === $none ) $none = __( 'Comments Off' );

	$number = get_comments_number( $id );

	if ( 0 == $number && !comments_open() && !pings_open() ) {
		echo '<span' . ((!empty($css_class)) ? ' class="' . esc_attr( $css_class ) . '"' : '') . '>' . $none . '</span>';
		return;
	}

	if ( post_password_required() ) {
		echo __('Enter your password to view comments.');
		return;
	}

	echo '<a href="';
	if ( $wpcommentsjavascript ) {
		if ( empty( $wpcommentspopupfile ) )
			$home = home_url();
		else
			$home = get_option('siteurl');
		echo $home . '/' . $wpcommentspopupfile . '?comments_popup=' . $id;
		echo '" onclick="wpopen(this.href); return false"';
	} else { // if comments_popup_script() is not in the template, display simple comment link
		if ( 0 == $number )
			echo get_permalink() . '#respond';
		else
			comments_link();
		echo '"';
	}

	if ( !empty( $css_class ) ) {
		echo ' class="'.$css_class.'" ';
	}
	$title = the_title_attribute( array('echo' => 0 ) );

	$attributes = '';
	/**
	 * Filter the comments popup link attributes for display.
	 *
	 * @since 2.5.0
	 *
	 * @param string $attributes The comments popup link attributes. Default empty.
	 */
	echo apply_filters( 'comments_popup_link_attributes', $attributes );

	echo ' title="' . esc_attr( sprintf( __('Comment on %s'), $title ) ) . '">';
	comments_number( $zero, $one, $more );
	echo '</a>';
}

/**
 * Retrieve HTML content for reply to comment link.
 *
 * @since 2.7.0
 *
 * @param array $args {
 *     Optional. Override default arguments.
 *
 *     @type string $add_below  The first part of the selector used to identify the comment to respond below.
 *                              The resulting value is passed as the first parameter to addComment.moveForm(),
 *                              concatenated as $add_below-$comment->comment_ID. Default 'comment'.
 *     @type string $respond_id The selector identifying the responding comment. Passed as the third parameter
 *                              to addComment.moveForm(), and appended to the link URL as a hash value.
 *                              Default 'respond'.
 *     @type string $reply_text The text of the Reply link. Default 'Reply'.
 *     @type string $login_text The text of the link to reply if logged out. Default 'Log in to Reply'.
 *     @type int    $depth'     The depth of the new comment. Must be greater than 0 and less than the value
 *                              of the 'thread_comments_depth' option set in Settings > Discussion. Default 0.
 *     @type string $before     The text or HTML to add before the reply link. Default empty.
 *     @type string $after      The text or HTML to add after the reply link. Default empty.
 * }
 * @param int         $comment Comment being replied to. Default current comment.
 * @param int|WP_Post $post    Post ID or WP_Post object the comment is going to be displayed on.
 *                             Default current post.
 * @return null|false|string Link to show comment form, if successful. False, if comments are closed.
 */
function get_comment_reply_link( $args = array(), $comment = null, $post = null ) {

	$defaults = array(
		'add_below'     => 'comment',
		'respond_id'    => 'respond',
		'reply_text'    => __( 'Reply' ),
		'reply_to_text' => __( 'Reply to %s' ),
		'login_text'    => __( 'Log in to Reply' ),
		'depth'         => 0,
		'before'        => '',
		'after'         => ''
	);

	$args = wp_parse_args( $args, $defaults );

	if ( 0 == $args['depth'] || $args['max_depth'] <= $args['depth'] ) {
		return;
	}

	$comment = get_comment( $comment );

	if ( empty( $post ) ) {
		$post = $comment->comment_post_ID;
	}

	$post = get_post( $post );

	if ( ! comments_open( $post->ID ) ) {
		return false;
	}

	/**
	 * Filter the comment reply link arguments.
	 *
	 * @since 4.1.0
	 *
	 * @param array   $args    Comment reply link arguments. See {@see get_comment_reply_link()}
	 *                         for more information on accepted arguments.
	 * @param object  $comment The object of the comment being replied to.
	 * @param WP_Post $post    The {@see WP_Post} object.
	 */
	$args = apply_filters( 'comment_reply_link_args', $args, $comment, $post );

	if ( get_option( 'comment_registration' ) && ! is_user_logged_in() ) {
		$link = sprintf( '<a rel="nofollow" class="comment-reply-login" href="%s">%s</a>',
			esc_url( wp_login_url( get_permalink() ) ),
			$args['login_text']
		);
	} else {
		$onclick = sprintf( 'return addComment.moveForm( "%1$s-%2$s", "%2$s", "%3$s", "%4$s" )',
			$args['add_below'], $comment->comment_ID, $args['respond_id'], $post->ID
		);

		$link = sprintf( "<a class='comment-reply-link' href='%s' onclick='%s' aria-label='%s'>%s</a>",
			esc_url( add_query_arg( 'replytocom', $comment->comment_ID ) ) . "#" . $args['respond_id'],
			$onclick,
			esc_attr( sprintf( $args['reply_to_text'], $comment->comment_author ) ),
			$args['reply_text']
		);
	}
	/**
	 * Filter the comment reply link.
	 *
	 * @since 2.7.0
	 *
	 * @param string  $link    The HTML markup for the comment reply link.
	 * @param array   $args    An array of arguments overriding the defaults.
	 * @param object  $comment The object of the comment being replied.
	 * @param WP_Post $post    The WP_Post object.
	 */
	return apply_filters( 'comment_reply_link', $args['before'] . $link . $args['after'], $args, $comment, $post );
}

/**
 * Displays the HTML content for reply to comment link.
 *
 * @since 2.7.0
 *
 * @see get_comment_reply_link()
 *
 * @param array       $args    Optional. Override default options.
 * @param int         $comment Comment being replied to. Default current comment.
 * @param int|WP_Post $post    Post ID or WP_Post object the comment is going to be displayed on.
 *                             Default current post.
 * @return mixed Link to show comment form, if successful. False, if comments are closed.
 */
function comment_reply_link($args = array(), $comment = null, $post = null) {
	echo get_comment_reply_link($args, $comment, $post);
}

/**
 * Retrieve HTML content for reply to post link.
 *
 * @since 2.7.0
 *
 * @param array $args {
 *     Optional. Override default arguments.
 *
 *     @type string $add_below  The first part of the selector used to identify the comment to respond below.
 *                              The resulting value is passed as the first parameter to addComment.moveForm(),
 *                              concatenated as $add_below-$comment->comment_ID. Default is 'post'.
 *     @type string $respond_id The selector identifying the responding comment. Passed as the third parameter
 *                              to addComment.moveForm(), and appended to the link URL as a hash value.
 *                              Default 'respond'.
 *     @type string $reply_text Text of the Reply link. Default is 'Leave a Comment'.
 *     @type string $login_text Text of the link to reply if logged out. Default is 'Log in to leave a Comment'.
 *     @type string $before     Text or HTML to add before the reply link. Default empty.
 *     @type string $after      Text or HTML to add after the reply link. Default empty.
 * }
 * @param int|WP_Post $post    Optional. Post ID or WP_Post object the comment is going to be displayed on.
 *                             Default current post.
 * @return false|null|string Link to show comment form, if successful. False, if comments are closed.
 */
function get_post_reply_link($args = array(), $post = null) {
	$defaults = array(
		'add_below'  => 'post',
		'respond_id' => 'respond',
		'reply_text' => __('Leave a Comment'),
		'login_text' => __('Log in to leave a Comment'),
		'before'     => '',
		'after'      => '',
	);

	$args = wp_parse_args($args, $defaults);

	$post = get_post($post);

	if ( ! comments_open( $post->ID ) ) {
		return false;
	}

	if ( get_option('comment_registration') && ! is_user_logged_in() ) {
		$link = sprintf( '<a rel="nofollow" href="%s">%s</a>',
			wp_login_url( get_permalink() ),
			$args['login_text']
		);
	} else {
		$onclick = sprintf( 'return addComment.moveForm( "%1$s-%2$s", "0", "%3$s", "%2$s" )',
			$args['add_below'], $post->ID, $args['respond_id']
		);

		$link = sprintf( "<a rel='nofollow' class='comment-reply-link' href='%s' onclick='%s'>%s</a>",
			get_permalink( $post->ID ) . '#' . $args['respond_id'],
			$onclick,
			$args['reply_text']
		);
	}
	$formatted_link = $args['before'] . $link . $args['after'];
	/**
	 * Filter the formatted post comments link HTML.
	 *
	 * @since 2.7.0
	 *
	 * @param string      $formatted The HTML-formatted post comments link.
	 * @param int|WP_Post $post      The post ID or WP_Post object.
	 */
	return apply_filters( 'post_comments_link', $formatted_link, $post );
}

/**
 * Displays the HTML content for reply to post link.
 *
 * @since 2.7.0
 *
 * @see get_post_reply_link()
 *
 * @param array       $args Optional. Override default options,
 * @param int|WP_Post $post Post ID or WP_Post object the comment is going to be displayed on.
 *                          Default current post.
 * @return string|bool|null Link to show comment form, if successful. False, if comments are closed.
 */
function post_reply_link($args = array(), $post = null) {
	echo get_post_reply_link($args, $post);
}

/**
 * Retrieve HTML content for cancel comment reply link.
 *
 * @since 2.7.0
 *
 * @param string $text Optional. Text to display for cancel reply link. Default empty.
 */
function get_cancel_comment_reply_link( $text = '' ) {
	if ( empty($text) )
		$text = __('Click here to cancel reply.');

	$style = isset($_GET['replytocom']) ? '' : ' style="display:none;"';
	$link = esc_html( remove_query_arg('replytocom') ) . '#respond';

	$formatted_link = '<a rel="nofollow" id="cancel-comment-reply-link" href="' . $link . '"' . $style . '>' . $text . '</a>';
	/**
	 * Filter the cancel comment reply link HTML.
	 *
	 * @since 2.7.0
	 *
	 * @param string $formatted_link The HTML-formatted cancel comment reply link.
	 * @param string $link           Cancel comment reply link URL.
	 * @param string $text           Cancel comment reply link text.
	 */
	return apply_filters( 'cancel_comment_reply_link', $formatted_link, $link, $text );
}

/**
 * Display HTML content for cancel comment reply link.
 *
 * @since 2.7.0
 *
 * @param string $text Optional. Text to display for cancel reply link. Default empty.
 */
function cancel_comment_reply_link( $text = '' ) {
	echo get_cancel_comment_reply_link($text);
}

/**
 * Retrieve hidden input HTML for replying to comments.
 *
 * @since 3.0.0
 *
 * @param int $id Optional. Post ID. Default current post ID.
 * @return string Hidden input HTML for replying to comments
 */
function get_comment_id_fields( $id = 0 ) {
	if ( empty( $id ) )
		$id = get_the_ID();

	$replytoid = isset($_GET['replytocom']) ? (int) $_GET['replytocom'] : 0;
	$result  = "<input type='hidden' name='comment_post_ID' value='$id' id='comment_post_ID' />\n";
	$result .= "<input type='hidden' name='comment_parent' id='comment_parent' value='$replytoid' />\n";

	/**
	 * Filter the returned comment id fields.
	 *
	 * @since 3.0.0
	 *
	 * @param string $result    The HTML-formatted hidden id field comment elements.
	 * @param int    $id        The post ID.
	 * @param int    $replytoid The id of the comment being replied to.
	 */
	return apply_filters( 'comment_id_fields', $result, $id, $replytoid );
}

/**
 * Output hidden input HTML for replying to comments.
 *
 * @since 2.7.0
 *
 * @param int $id Optional. Post ID. Default current post ID.
 */
function comment_id_fields( $id = 0 ) {
	echo get_comment_id_fields( $id );
}

/**
 * Display text based on comment reply status.
 *
 * Only affects users with JavaScript disabled.
 *
 * @since 2.7.0
 *
 * @param string $noreplytext  Optional. Text to display when not replying to a comment.
 *                             Default false.
 * @param string $replytext    Optional. Text to display when replying to a comment.
 *                             Default false. Accepts "%s" for the author of the comment
 *                             being replied to.
 * @param string $linktoparent Optional. Boolean to control making the author's name a link
 *                             to their comment. Default true.
 */
function comment_form_title( $noreplytext = false, $replytext = false, $linktoparent = true ) {
	global $comment;

	if ( false === $noreplytext ) $noreplytext = __( 'Leave a Reply' );
	if ( false === $replytext ) $replytext = __( 'Leave a Reply to %s' );

	$replytoid = isset($_GET['replytocom']) ? (int) $_GET['replytocom'] : 0;

	if ( 0 == $replytoid )
		echo $noreplytext;
	else {
		$comment = get_comment($replytoid);
		$author = ( $linktoparent ) ? '<a href="#comment-' . get_comment_ID() . '">' . get_comment_author() . '</a>' : get_comment_author();
		printf( $replytext, $author );
	}
}

/**
 * HTML comment list class.
 *
 * @uses Walker
 * @since 2.7.0
 */
class Walker_Comment extends Walker {
	/**
	 * What the class handles.
	 *
	 * @see Walker::$tree_type
	 *
	 * @since 2.7.0
	 * @var string
	 */
	public $tree_type = 'comment';

	/**
	 * DB fields to use.
	 *
	 * @see Walker::$db_fields
	 *
	 * @since 2.7.0
	 * @var array
	 */
	public $db_fields = array ('parent' => 'comment_parent', 'id' => 'comment_ID');

	/**
	 * Start the list before the elements are added.
	 *
	 * @see Walker::start_lvl()
	 *
	 * @since 2.7.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of comment.
	 * @param array $args Uses 'style' argument for type of HTML list.
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$GLOBALS['comment_depth'] = $depth + 1;

		switch ( $args['style'] ) {
			case 'div':
				break;
			case 'ol':
				$output .= '<ol class="children">' . "\n";
				break;
			case 'ul':
			default:
				$output .= '<ul class="children">' . "\n";
				break;
		}
	}

	/**
	 * End the list of items after the elements are added.
	 *
	 * @see Walker::end_lvl()
	 *
	 * @since 2.7.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of comment.
	 * @param array  $args   Will only append content if style argument value is 'ol' or 'ul'.
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		$GLOBALS['comment_depth'] = $depth + 1;

		switch ( $args['style'] ) {
			case 'div':
				break;
			case 'ol':
				$output .= "</ol><!-- .children -->\n";
				break;
			case 'ul':
			default:
				$output .= "</ul><!-- .children -->\n";
				break;
		}
	}

	/**
	 * Traverse elements to create list from elements.
	 *
	 * This function is designed to enhance Walker::display_element() to
	 * display children of higher nesting levels than selected inline on
	 * the highest depth level displayed. This prevents them being orphaned
	 * at the end of the comment list.
	 *
	 * Example: max_depth = 2, with 5 levels of nested content.
	 * 1
	 *  1.1
	 *    1.1.1
	 *    1.1.1.1
	 *    1.1.1.1.1
	 *    1.1.2
	 *    1.1.2.1
	 * 2
	 *  2.2
	 *
	 * @see Walker::display_element()
	 * @see wp_list_comments()
	 *
	 * @since 2.7.0
	 *
	 * @param object $element           Data object.
	 * @param array  $children_elements List of elements to continue traversing.
	 * @param int    $max_depth         Max depth to traverse.
	 * @param int    $depth             Depth of current element.
	 * @param array  $args              An array of arguments.
	 * @param string $output            Passed by reference. Used to append additional content.
	 * @return null Null on failure with no changes to parameters.
	 */
	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {

		if ( !$element )
			return;

		$id_field = $this->db_fields['id'];
		$id = $element->$id_field;

		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );

		// If we're at the max depth, and the current element still has children, loop over those and display them at this level
		// This is to prevent them being orphaned to the end of the list.
		if ( $max_depth <= $depth + 1 && isset( $children_elements[$id]) ) {
			foreach ( $children_elements[ $id ] as $child )
				$this->display_element( $child, $children_elements, $max_depth, $depth, $args, $output );

			unset( $children_elements[ $id ] );
		}

	}

	/**
	 * Start the element output.
	 *
	 * @since 2.7.0
	 *
	 * @see Walker::start_el()
	 * @see wp_list_comments()
	 *
	 * @param string $output  Passed by reference. Used to append additional content.
	 * @param object $comment Comment data object.
	 * @param int    $depth   Depth of comment in reference to parents.
	 * @param array  $args    An array of arguments.
	 */
	public function start_el( &$output, $comment, $depth = 0, $args = array(), $id = 0 ) {
		$depth++;
		$GLOBALS['comment_depth'] = $depth;
		$GLOBALS['comment'] = $comment;

		if ( !empty( $args['callback'] ) ) {
			ob_start();
			call_user_func( $args['callback'], $comment, $args, $depth );
			$output .= ob_get_clean();
			return;
		}

		if ( ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) && $args['short_ping'] ) {
			ob_start();
			$this->ping( $comment, $depth, $args );
			$output .= ob_get_clean();
		} elseif ( 'html5' === $args['format'] ) {
			ob_start();
			$this->html5_comment( $comment, $depth, $args );
			$output .= ob_get_clean();
		} else {
			ob_start();
			$this->comment( $comment, $depth, $args );
			$output .= ob_get_clean();
		}
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @since 2.7.0
	 *
	 * @see Walker::end_el()
	 * @see wp_list_comments()
	 *
	 * @param string $output  Passed by reference. Used to append additional content.
	 * @param object $comment The comment object. Default current comment.
	 * @param int    $depth   Depth of comment.
	 * @param array  $args    An array of arguments.
	 */
	public function end_el( &$output, $comment, $depth = 0, $args = array() ) {
		if ( !empty( $args['end-callback'] ) ) {
			ob_start();
			call_user_func( $args['end-callback'], $comment, $args, $depth );
			$output .= ob_get_clean();
			return;
		}
		if ( 'div' == $args['style'] )
			$output .= "</div><!-- #comment-## -->\n";
		else
			$output .= "</li><!-- #comment-## -->\n";
	}

	/**
	 * Output a pingback comment.
	 *
	 * @access protected
	 * @since 3.6.0
	 *
	 * @see wp_list_comments()
	 *
	 * @param object $comment The comment object.
	 * @param int    $depth   Depth of comment.
	 * @param array  $args    An array of arguments.
	 */
	protected function ping( $comment, $depth, $args ) {
		$tag = ( 'div' == $args['style'] ) ? 'div' : 'li';
?>
		<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
			<div class="comment-body">
				<?php _e( 'Pingback:' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?>
			</div>
<?php
	}

	/**
	 * Output a single comment.
	 *
	 * @access protected
	 * @since 3.6.0
	 *
	 * @see wp_list_comments()
	 *
	 * @param object $comment Comment to display.
	 * @param int    $depth   Depth of comment.
	 * @param array  $args    An array of arguments.
	 */
	protected function comment( $comment, $depth, $args ) {
		if ( 'div' == $args['style'] ) {
			$tag = 'div';
			$add_below = 'comment';
		} else {
			$tag = 'li';
			$add_below = 'div-comment';
		}
?>
		<<?php echo $tag; ?> <?php comment_class( $this->has_children ? 'parent' : '' ); ?> id="comment-<?php comment_ID(); ?>">
		<?php if ( 'div' != $args['style'] ) : ?>
		<div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
		<?php endif; ?>
		<div class="comment-author vcard">
			<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
			<?php printf( __( '<cite class="fn">%s</cite> <span class="says">says:</span>' ), get_comment_author_link() ); ?>
		</div>
		<?php if ( '0' == $comment->comment_approved ) : ?>
		<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ) ?></em>
		<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)' ), '&nbsp;&nbsp;', '' );
			?>
		</div>

		<?php comment_text( get_comment_id(), array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>

		<?php
		comment_reply_link( array_merge( $args, array(
			'add_below' => $add_below,
			'depth'     => $depth,
			'max_depth' => $args['max_depth'],
			'before'    => '<div class="reply">',
			'after'     => '</div>'
		) ) );
		?>

		<?php if ( 'div' != $args['style'] ) : ?>
		</div>
		<?php endif; ?>
<?php
	}

	/**
	 * Output a comment in the HTML5 format.
	 *
	 * @access protected
	 * @since 3.6.0
	 *
	 * @see wp_list_comments()
	 *
	 * @param object $comment Comment to display.
	 * @param int    $depth   Depth of comment.
	 * @param array  $args    An array of arguments.
	 */
	protected function html5_comment( $comment, $depth, $args ) {
		$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
?>
		<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent' : '' ); ?>>
			<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
				<footer class="comment-meta">
					<div class="comment-author vcard">
						<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
						<?php printf( __( '%s <span class="says">says:</span>' ), sprintf( '<b class="fn">%s</b>', get_comment_author_link() ) ); ?>
					</div><!-- .comment-author -->

					<div class="comment-metadata">
						<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">
							<time datetime="<?php comment_time( 'c' ); ?>">
								<?php printf( _x( '%1$s at %2$s', '1: date, 2: time' ), get_comment_date(), get_comment_time() ); ?>
							</time>
						</a>
						<?php edit_comment_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?>
					</div><!-- .comment-metadata -->

					<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></p>
					<?php endif; ?>
				</footer><!-- .comment-meta -->

				<div class="comment-content">
					<?php comment_text(); ?>
				</div><!-- .comment-content -->

				<?php
				comment_reply_link( array_merge( $args, array(
					'add_below' => 'div-comment',
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
					'before'    => '<div class="reply">',
					'after'     => '</div>'
				) ) );
				?>
			</article><!-- .comment-body -->
<?php
	}
}

/**
 * List comments.
 *
 * Used in the comments.php template to list comments for a particular post.
 *
 * @since 2.7.0
 *
 * @see WP_Query->comments
 *
 * @param string|array $args {
 *     Optional. Formatting options.
 *
 *     @type object $walker            Instance of a Walker class to list comments. Default null.
 *     @type int    $max_depth         The maximum comments depth. Default empty.
 *     @type string $style             The style of list ordering. Default 'ul'. Accepts 'ul', 'ol'.
 *     @type string $callback          Callback function to use. Default null.
 *     @type string $end-callback      Callback function to use at the end. Default null.
 *     @type string $type              Type of comments to list.
 *                                     Default 'all'. Accepts 'all', 'comment', 'pingback', 'trackback', 'pings'.
 *     @type int    $page              Page ID to list comments for. Default empty.
 *     @type int    $per_page          Number of comments to list per page. Default empty.
 *     @type int    $avatar_size       Height and width dimensions of the avatar size. Default 32.
 *     @type string $reverse_top_level Ordering of the listed comments. Default null. Accepts 'desc', 'asc'.
 *     @type bool   $reverse_children  Whether to reverse child comments in the list. Default null.
 *     @type string $format            How to format the comments list.
 *                                     Default 'html5' if the theme supports it. Accepts 'html5', 'xhtml'.
 *     @type bool   $short_ping        Whether to output short pings. Default false.
 *     @type bool   $echo              Whether to echo the output or return it. Default true.
 * }
 * @param array $comments Optional. Array of comment objects.
 */
function wp_list_comments( $args = array(), $comments = null ) {
	global $wp_query, $comment_alt, $comment_depth, $comment_thread_alt, $overridden_cpage, $in_comment_loop;

	$in_comment_loop = true;

	$comment_alt = $comment_thread_alt = 0;
	$comment_depth = 1;

	$defaults = array(
		'walker'            => null,
		'max_depth'         => '',
		'style'             => 'ul',
		'callback'          => null,
		'end-callback'      => null,
		'type'              => 'all',
		'page'              => '',
		'per_page'          => '',
		'avatar_size'       => 32,
		'reverse_top_level' => null,
		'reverse_children'  => '',
		'format'            => current_theme_supports( 'html5', 'comment-list' ) ? 'html5' : 'xhtml',
		'short_ping'        => false,
		'echo'              => true,
	);

	$r = wp_parse_args( $args, $defaults );

	/**
	 * Filter the arguments used in retrieving the comment list.
	 *
	 * @since 4.0.0
	 *
	 * @see wp_list_comments()
	 *
	 * @param array $r An array of arguments for displaying comments.
	 */
	$r = apply_filters( 'wp_list_comments_args', $r );

	// Figure out what comments we'll be looping through ($_comments)
	if ( null !== $comments ) {
		$comments = (array) $comments;
		if ( empty($comments) )
			return;
		if ( 'all' != $r['type'] ) {
			$comments_by_type = separate_comments($comments);
			if ( empty($comments_by_type[$r['type']]) )
				return;
			$_comments = $comments_by_type[$r['type']];
		} else {
			$_comments = $comments;
		}
	} else {
		if ( empty($wp_query->comments) )
			return;
		if ( 'all' != $r['type'] ) {
			if ( empty($wp_query->comments_by_type) )
				$wp_query->comments_by_type = separate_comments($wp_query->comments);
			if ( empty($wp_query->comments_by_type[$r['type']]) )
				return;
			$_comments = $wp_query->comments_by_type[$r['type']];
		} else {
			$_comments = $wp_query->comments;
		}
	}

	if ( '' === $r['per_page'] && get_option('page_comments') )
		$r['per_page'] = get_query_var('comments_per_page');

	if ( empty($r['per_page']) ) {
		$r['per_page'] = 0;
		$r['page'] = 0;
	}

	if ( '' === $r['max_depth'] ) {
		if ( get_option('thread_comments') )
			$r['max_depth'] = get_option('thread_comments_depth');
		else
			$r['max_depth'] = -1;
	}

	if ( '' === $r['page'] ) {
		if ( empty($overridden_cpage) ) {
			$r['page'] = get_query_var('cpage');
		} else {
			$threaded = ( -1 != $r['max_depth'] );
			$r['page'] = ( 'newest' == get_option('default_comments_page') ) ? get_comment_pages_count($_comments, $r['per_page'], $threaded) : 1;
			set_query_var( 'cpage', $r['page'] );
		}
	}
	// Validation check
	$r['page'] = intval($r['page']);
	if ( 0 == $r['page'] && 0 != $r['per_page'] )
		$r['page'] = 1;

	if ( null === $r['reverse_top_level'] )
		$r['reverse_top_level'] = ( 'desc' == get_option('comment_order') );

	if ( empty( $r['walker'] ) ) {
		$walker = new Walker_Comment;
	} else {
		$walker = $r['walker'];
	}

	$output = $walker->paged_walk( $_comments, $r['max_depth'], $r['page'], $r['per_page'], $r );
	$wp_query->max_num_comment_pages = $walker->max_pages;

	$in_comment_loop = false;

	if ( $r['echo'] ) {
		echo $output;
	} else {
		return $output;
	}
}

/**
 * Output a complete commenting form for use within a template.
 *
 * Most strings and form fields may be controlled through the $args array passed
 * into the function, while you may also choose to use the comment_form_default_fields
 * filter to modify the array of default fields if you'd just like to add a new
 * one or remove a single field. All fields are also individually passed through
 * a filter of the form comment_form_field_$name where $name is the key used
 * in the array of fields.
 *
 * @since 3.0.0
 *
 * @param array       $args {
 *     Optional. Default arguments and form fields to override.
 *
 *     @type array $fields {
 *         Default comment fields, filterable by default via the 'comment_form_default_fields' hook.
 *
 *         @type string $author Comment author field HTML.
 *         @type string $email  Comment author email field HTML.
 *         @type string $url    Comment author URL field HTML.
 *     }
 *     @type string $comment_field        The comment textarea field HTML.
 *     @type string $must_log_in          HTML element for a 'must be logged in to comment' message.
 *     @type string $logged_in_as         HTML element for a 'logged in as [user]' message.
 *     @type string $comment_notes_before HTML element for a message displayed before the comment form.
 *                                        Default 'Your email address will not be published.'.
 *     @type string $comment_notes_after  HTML element for a message displayed after the comment form.
 *                                        Default 'You may use these HTML tags and attributes ...'.
 *     @type string $id_form              The comment form element id attribute. Default 'commentform'.
 *     @type string $id_submit            The comment submit element id attribute. Default 'submit'.
 *     @type string $class_submit         The comment submit element class attribute. Default 'submit'.
 *     @type string $name_submit          The comment submit element name attribute. Default 'submit'.
 *     @type string $title_reply          The translatable 'reply' button label. Default 'Leave a Reply'.
 *     @type string $title_reply_to       The translatable 'reply-to' button label. Default 'Leave a Reply to %s',
 *                                        where %s is the author of the comment being replied to.
 *     @type string $cancel_reply_link    The translatable 'cancel reply' button label. Default 'Cancel reply'.
 *     @type string $label_submit         The translatable 'submit' button label. Default 'Post a comment'.
 *     @type string $format               The comment form format. Default 'xhtml'. Accepts 'xhtml', 'html5'.
 * }
 * @param int|WP_Post $post_id Post ID or WP_Post object to generate the form for. Default current post.
 */
function comment_form( $args = array(), $post_id = null ) {
	if ( null === $post_id )
		$post_id = get_the_ID();

	$commenter = wp_get_current_commenter();
	$user = wp_get_current_user();
	$user_identity = $user->exists() ? $user->display_name : '';

	$args = wp_parse_args( $args );
	if ( ! isset( $args['format'] ) )
		$args['format'] = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';

	$req      = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$html5    = 'html5' === $args['format'];
	$fields   =  array(
		'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
		            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
         /* Nexmo - Added phone number for verification */
		'phone'  => '<p class="comment-form-phone"><label for="phone">' . __( 'Phone' ) . ( $req ? ' <span class="required">*</span>' : '' ) .'</label> ' .
		            '<input id="phone" name="phone" '. ( $html5 ? 'type="phone"' : 'type="text"' ) .' value="' . esc_attr( $commenter['comment_author_phone'] ) . '" size="30" aria-describedby="phone-notes"' . $aria_req . ' /></p>',

	);

	$required_text = sprintf( ' ' . __('Required fields are marked %s'), '<span class="required">*</span>' );

	/**
	 * Filter the default comment form fields.
	 *
	 * @since 3.0.0
	 *
	 * @param array $fields The default comment fields.
	 */
	$fields = apply_filters( 'comment_form_default_fields', $fields );
	$defaults = array(
		'fields'               => $fields,
		'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label> <textarea id="comment" name="comment" cols="45" rows="8" aria-describedby="form-allowed-tags" aria-required="true"></textarea></p>',
		/** This filter is documented in wp-includes/link-template.php */
		'must_log_in'          => '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
		/** This filter is documented in wp-includes/link-template.php */
		'logged_in_as'         => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ), get_edit_user_link(), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
		'comment_notes_before' => '<p class="comment-notes"><span id="email-notes">' . __( 'Your email address will not be published.' ) . '</span>'. ( $req ? $required_text : '' ) . '</p>',
		//'verifyform'=>'<script>$(document).ready(function() { $("form#commentform").submit(function() {$("#verify").show();$("#respond").hide();})});</script>',
		
		'comment_notes_after'  => '<p class="form-allowed-tags" id="form-allowed-tags">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s' ), ' <code>' . allowed_tags() . '</code>' ) . '</p>',
		'id_form'              => 'commentform',
		'id_submit'            => 'submit',
		'class_submit'         => 'submit',
		'name_submit'          => 'submit',
		'title_reply'          => __( 'Leave a Reply' ),
		'title_reply_to'       => __( 'Leave a Reply to %s' ),
		'cancel_reply_link'    => __( 'Cancel reply' ),
		'label_submit'         => __( 'Post Comment' ),
		'format'               => 'xhtml',
	);

	/**
	 * Filter the comment form default arguments.
	 *
	 * Use 'comment_form_default_fields' to filter the comment fields.
	 *
	 * @since 3.0.0
	 *
	 * @param array $defaults The default comment form arguments.
	 */
	$args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) );

	?>
		<?php if ( comments_open( $post_id ) ) : ?>
			<?php
			/**
			 * Fires before the comment form.
			 *
			 * @since 3.0.0
			 */
			do_action( 'comment_form_before' );
			?>
			
			<div id="respond" class="comment-respond" >



        <h3 id="reply-title" class="comment-reply-title"><?php comment_form_title( $args['title_reply'], $args['title_reply_to'] ); ?> <small><?php cancel_comment_reply_link( $args['cancel_reply_link'] ); ?></small></h3>
    

				
				<?php if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) : ?>
					<?php echo $args['must_log_in']; ?>
					<?php
					/**
					 * Fires after the HTML-formatted 'must log in after' message in the comment form.
					 *
					 * @since 3.0.0
					 */
					do_action( 'comment_form_must_log_in_after' );
					?>
				<?php else : ?>

				<div id="respondPhoneNumber" class="comment-respond" >
					<form action="<?php echo site_url( '/wp-comments-post.php' ); ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>" class="comment-form"<?php echo $html5 ? ' novalidate' : ''; ?>>
						<?php
						/**
						 * Fires at the top of the comment form, inside the form tag.
						 *
						 * @since 3.0.0
						 */
						do_action( 'comment_form_top' );
						?>


						<?php if ( is_user_logged_in() ) : ?>
							<?php
							/**
							 * Filter the 'logged in' message for the comment form for display.
							 *
							 * @since 3.0.0
							 *
							 * @param string $args_logged_in The logged-in-as HTML-formatted message.
							 * @param array  $commenter      An array containing the comment author's
							 *                               username, email, and URL.
							 * @param string $user_identity  If the commenter is a registered user,
							 *                               the display name, blank otherwise.
							 */
							echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity );
							?>
							<?php
							/**
							 * Fires after the is_user_logged_in() check in the comment form.
							 *
							 * @since 3.0.0
							 *
							 * @param array  $commenter     An array containing the comment author's
							 *                              username, email, and URL.
							 * @param string $user_identity If the commenter is a registered user,
							 *                              the display name, blank otherwise.
							 */
							do_action( 'comment_form_logged_in_after', $commenter, $user_identity );
							?>
						<?php else : ?>
						
							<?php echo $args['comment_notes_before'];?>
							<?php
							/**
							 * Fires before the comment fields in the comment form.
							 *
							 * @since 3.0.0
							 */
							do_action( 'comment_form_before_fields' );
							foreach ( (array) $args['fields'] as $name => $field ) {
								/**
								 * Filter a comment form field for display.
								 *
								 * The dynamic portion of the filter hook, `$name`, refers to the name
								 * of the comment form field. Such as 'author', 'email', or 'url'.
								 *
								 * @since 3.0.0
								 *
								 * @param string $field The HTML-formatted output of the comment form field.
								 */
								echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";
							}
							/**
							 * Fires after the comment fields in the comment form.
							 *
							 * @since 3.0.0
							 */
							do_action( 'comment_form_after_fields' );
							?>
						<?php endif; ?>
						<?php
						/**
						 * Filter the content of the comment textarea field for display.
						 *
						 * @since 3.0.0
						 *
						 * @param string $args_comment_field The content of the comment textarea field.
						 */
						echo apply_filters( 'comment_form_field_comment', $args['comment_field'] );
						?>
						<?php echo $args['comment_notes_after']; ?>

						<p class="form-submit">
							<input name="<?php echo esc_attr( $args['name_submit'] ); ?>" type="submit" id="<?php echo esc_attr( $args['id_submit'] ); ?>" class="<?php echo esc_attr( $args['class_submit'] ); ?>" value="<?php echo esc_attr( $args['label_submit'] ); ?>" />
							<?php comment_id_fields( $post_id ); ?>
						</p>
						


<?php

						
						/**
						 * Fires at the bottom of the comment form, inside the closing </form> tag.
						 *
						 * @since 1.5.0
						 *
						 * @param int $post_id The post ID.
						 */

						do_action( 'comment_form', $post_id );

						?>

					</form>
				</div>
<div class="comment-respond" style="display:none;" id="verify">

 <form  role="form" method="POST" action="#" class="comment-form"<?php echo $html5 ? ' novalidate' : '';?>>
 	
        <h3 id="reply-title" class="comment-reply-title">Confirm Your Verification Code<small><?php cancel_comment_reply_link( $args['cancel_reply_link'] ); ?></small></h3>
        <br>
    
    
      <!--  Nexmo - Added phone number for verification */ -->
        
        <input name="code" type="text"  placeholder="Confirm code" required autofocus>
        <br>
        <button  type="submit">Confirm</button>
        <?php if(isset($text)): ?>
            <div class="alert alert-info" role="alert">
                <p><?php echo $text; ?></p>
            </div>
        <?php endif; ?>
    </form>
</div>

				<?php endif; ?>
			</div><!-- #respond -->

							
 


<?php

			
									
			/**
			 * Fires after the comment form.
			 *
			 * @since 3.0.0
			 */
			//do_action( 'comment_form_after' );
			
	
		else :
			/**
			 * Fires after the comment form if comments are closed.
			 *
			 * @since 3.0.0
			 */
			do_action( 'comment_form_comments_closed' );

		endif;
}
 




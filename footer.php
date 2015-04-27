<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript">
/* Nexmo - Added phone number for verification */
$(document).ready(function() {
	
var hashStr	= location.hash;
console.log(hashStr);
if( hashStr ) {
	var ary	= hashStr.split("-");
	if( ary[0] == "#comment" ) {
		
		$('#respondPhoneNumber').hide();
		$('#verify').show();
	}
}
}); 
</script>
<?php
session_start();
echo '<link href="'. plugins_url('/Nexmopress/style.css' ). '" rel="stylesheet" type="text/css" />';


    //echo "Session code".$_SESSION['code'];
if(isset($_POST['code'])){

    if($_SESSION['code'] == $_POST['code']){

$args = array(
	'status' => 'hold',
	'number' => '1'
	);
$comments = get_comments($args);
foreach($comments as $comment) :
	$commentid=($comment->comment_ID);

endforeach;

$commentarr = array();
$commentarr['comment_ID'] = $commentid;
$commentarr['comment_approved'] = 1;
wp_update_comment( $commentarr );

echo "<script>alert('Comment Approved');</script>";
?>
<script type="text/javascript">window.location= <?php echo "'" . $location . "'"; ?></script>
<?php
}


else {
        
echo "<script>alert('Invalid code entered, please try again!');</script>";

    }
}
?>


		</div><!-- #main -->
	


		<footer id="colophon" class="site-footer" role="contentinfo">
			<?php get_sidebar( 'main' ); ?>

			<div class="site-info">
				<?php do_action( 'twentythirteen_credits' ); ?>
				<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'twentythirteen' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'twentythirteen' ); ?>"><?php printf( __( 'Proudly powered by %s', 'twentythirteen' ), 'WordPress' ); ?></a>
			</div><!-- .site-info -->
		</footer><!-- #colophon -->
	</div><!-- #page -->

	<?php wp_footer(); ?>
</body>
</html>
<?php
/**
 * Plugin Name:       BeeyPublish Plugin
 * Plugin URI:        https://beey.io/
 * Description:       Allows you to publish media and transcription from Beey.
 * Version:           0.1.2
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Newton Technologies
 * Author URI:        https://www.newtontech.net
 * License:           All rights reserved.
 * Text Domain:       beey-publish
 * Domain Path:       /
 */
 
 
/**
 * Activate the plugin.
 */
function beeyPublish_activate() { 
    // Clear the permalinks after the post type has been registered.
    flush_rewrite_rules(); 
}
register_activation_hook( __FILE__, 'beeyPublish_activate' );

/**
 * Deactivation hook.
 */
function beeyPublish_deactivate() {
    // Clear the permalinks to remove our post type's rules from the database.
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'beeyPublish_deactivate' );

function beeyPublish_loadBlocks() {
  wp_enqueue_script(
    'beey-publish',
    plugin_dir_url(__FILE__) . 'block.js',
    array('wp-blocks','wp-editor'),
    true
  );
}
add_action('enqueue_block_editor_assets', 'beeyPublish_loadBlocks');

/**
* Admin menu
*/
function beeyPublish_admin_menu() {
	add_menu_page(
		'BeeyPublish',
		'BeeyPublish',
		'manage_options',
		'sample-page',
		'beeyPublish_admin_page_contents',
		'dashicons-schedule',
	);
}
add_action('admin_menu', 'beeyPublish_admin_menu');
function beeyPublish_admin_page_contents() {
	?>
	<h1>Beey Publish</h1>
	<?php
	ini_set('display_errors',1);
        error_reporting(E_ALL);
	$target_dir = "../wp-content/beeyPublish/";
	$randomId = rand();
	$target_file = $target_dir . $randomId. "/";
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	if(isset($_FILES["trsxFile"])) {
		mkdir($target_dir . $randomId, 0777, true);
		if (move_uploaded_file($_FILES["mediaFile"]["tmp_name"], $target_file."media.mp4"))
			echo "The file ". htmlspecialchars( basename( $_FILES["mediaFile"]["name"])). " has been uploaded.<br/>";
		else 
			echo "Sorry, there was an error uploading your file.<br/>";
		if (move_uploaded_file($_FILES["trsxFile"]["tmp_name"], $target_file."subs.trsx"))
			echo "The file ". htmlspecialchars( basename( $_FILES["trsxFile"]["name"])). " has been uploaded.<br/>";
		else
			echo "Sorry, there was an error uploading your file.<br/>";
		if (move_uploaded_file($_FILES["subtitles"]["tmp_name"], $target_file."sub.vtt"))
			echo "The file ". htmlspecialchars( basename( $_FILES["subtitles"]["name"])). " has been uploaded.<br/>";
		else
			echo "Sorry, there was an error uploading your file.<br/>";
		echo "Project added under id ".$randomId."</br>";
	}
	?>
	<h2>Create new:</h2>
	<form method="POST" enctype="multipart/form-data">
		Media file: <input type="file" name="mediaFile" /><br/>
        Trsx file: <input type="file" name="trsxFile" /><br/>
		Subtitles: <input type="file" name="subtitles" /><br/>
                <input type="submit" />
	</form>
	<hr />
	<h2>Files uploaded:</h2>
	<ul>
		<?php
		if (!is_dir("../wp-content/beeyPublish"))
			mkdir("../wp-content/beeyPublish", 0777, true);
		foreach (scandir("../wp-content/beeyPublish") as $f) {
			if ($f[0] == ".") continue;
			echo "<li><a href='../wp-content/beeyPublish/".$f."/media.mp4'>".$f."</a></li>";
		}
		?>
	</ul>
	<hr />
	<h2>Having problems uploading?</h2>
    <p>If you are having problems with upload, please check that your files do not exceed these limits:</p>
    <table>
        <tr><td>Max request size:</td><td><?php echo(ini_get('post_max_size')); ?></td></tr>
        <tr><td>Max single file size:</td><td><?php echo(ini_get('upload_max_filesize')); ?></td></tr>
        <tr><td>RAM memory limit:</td><td><?php echo(ini_get('memory_limit')); ?></td></tr>
    </table>
    <p>The lowest value will limit the upload size.</p>
    <p>If you need to increase these limits, search for increasing PHP 'post_max_size', 'upload_max_filesize' and 'memory_limit' values.</p>

	<?php
}

/**
* Enqueue beeyPublish JS
*/

function beeyPublish_enqueue_scripts() {
	wp_enqueue_script(
		'beeyPublish',
        plugin_dir_url(__FILE__) . 'beeyPublish.js',
		true
	);
}
add_action('wp_enqueue_scripts', 'beeyPublish_enqueue_scripts');

function add_stylesheet_to_head() {
    echo "<link href='https://unpkg.com/@beey/publish@latest/dist/beey-publish.min.css' rel='stylesheet' type='text/css'>";
}
 
add_action( 'wp_head', 'add_stylesheet_to_head' );

function add_attribute_to_script_tag($tag, $handle) {
	if ( 'beeyPublish' === $handle ) {
        $tag = str_replace('src', 'type="module" defer="defer" src', $tag);
    }
    return $tag;
 }

add_filter('script_loader_tag', 'add_attribute_to_script_tag' , 10, 3);

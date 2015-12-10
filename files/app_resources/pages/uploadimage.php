<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Upload image</title>
		<style type="text/css">
		</style>
	</head>
	<body>
		<?php
		if (isset($_FILES['image'])) {
			if (isset($_FILES['image']['error'])) {
				echo '<p>';
				switch ($_FILES['image']['error']) {
					case 1: // UPLOAD_ERR_INI_SIZE
					case 2: // UPLOAD_ERR_FORM_SIZE
						echo '<p>' . translate('toobigphpini', (ini_get('upload_max_filesize') / 1024));
						break;
					case 3: // UPLOAD_ERR_PARTIAL
						echo '<p>' . translate('partialupload');
						break;
	
					case 4: // UPLOAD_ERR_NO_FILE
						echo '<p>' . translate('uploadfailed');
						break;
	
					case 6: // UPLOAD_ERR_NO_TMP_DIR
						echo '<p>' . translate('notmpdir');
						break;
	
					default:
						if ($_FILES['avatar']['size'] == 0) {
							echo '<p>' . translate('uploadfailed');
						}
						break;
				}
				echo ' (<a href="' . $base_config['baseurl'] . '/extensions/uploadimage">' . translate('tryagain') . '</a>)</p>';
			} else {
				?>
				<p>Your image: <input type="text" readonly="readonly" value="[img]<?php echo $base_config['baseurl']; ?>/static/userimages[/img]" /><br /><a href="<?php echo $base_config['baseurl']; ?>/extensions/uploadimage">Upload another image</a></p>
				<?php
			}
		} else {
			?>
		<form action="<?php echo $base_config['baseurl']; ?>/extensions/uploadimage" method="post" enctype="multipart/form-data">
			<p>Upload image: <input type="file" name="image" accept="image/*" /><br />(.png, .gif, .jpg accepted)</p>
		</form>
			<?php
		}
		?>
	</form>
</html>
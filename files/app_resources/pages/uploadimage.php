<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Upload image</title>
		<link rel="stylesheet" href="<?php echo $base_config['baseurl']; ?>/styles/default.css" />
	</head>
	<body>
		<div id="futurebb">
			<?php
			if (isset($_FILES['image']) && $futurebb_user['g_upload_images']) {
				if (isset($_FILES['image']['error']) && $_FILES['image']['error'] != 0) {
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
							if ($_FILES['image']['size'] == 0) {
								echo '<p>' . translate('uploadfailed');
							}
							break;
					}
					echo ' (<a href="' . $base_config['baseurl'] . '/extensions/uploadimage">' . translate('tryagain') . '</a>)</p>';
				} else if ($_FILES['image']['size'] > $futurebb_config['user_image_maxsize'] * 1024) {
					echo '<p>The image you uploaded is too big. The maximum allowed size is ' . $futurebb_config['user_image_maxsize'] . ' KiB. (<a href="' . $base_config['baseurl'] . '/extensions/uploadimage">' . translate('tryagain') . '</a>)</p>';
				} else {
					list($width, $height, $type,) = @getimagesize($_FILES['image']['tmp_name']);
					$ext_mappings = array(
						IMAGETYPE_GIF => 'gif',
						IMAGETYPE_JPEG => 'jpg',
						IMAGETYPE_PNG => 'png'
					);
					if (empty($width) || empty($height) || $width > $futurebb_config['user_image_maxwidth'] || $height > $futurebb_config['user_image_maxheight']) {
						echo '<p>The image you uploaded is too big. The maximum allowed dimensions are ' . $futurebb_config['user_image_maxwidth'] . 'x' . $futurebb_config['user_image_maxheight'] . ' pixels. (<a href="' . $base_config['baseurl'] . '/extensions/uploadimage">' . translate('tryagain') . '</a>)</p>';
					} else if (!array_key_exists($type, $ext_mappings)) {
						?>
						<p>The file you uploaded does not appear to be a valid image. (<a href="<?php echo $base_config['baseurl']; ?>/extensions/uploadimage"><?php echo translate('tryagain'); ?></a>)</p>
						<?php
					} else {
						$ext = $ext_mappings[$type];
						$db->query('INSERT INTO `#^userimages`(filename,user,ip_addr,time,extension) VALUES(\'' . $db->escape(basename($_FILES['image']['name'])) . '\',' . $futurebb_user['id'] . ',\'' . $db->escape($_SERVER['REMOTE_ADDR']) . '\',' . time() . ',\'' . $db->escape($ext) . '\')') or enhanced_error('Failed to insert image', true);
						move_uploaded_file($_FILES['image']['tmp_name'], FORUM_ROOT . '/static/userimages/' . intval($db->insert_id()) . '.' . $ext);
						?>
						<p>Your image: <br /><img src="<?php echo $base_config['baseurl']; ?>/static/userimages/<?php echo $db->insert_id(); ?>.<?php echo htmlspecialchars($ext); ?>" alt="<?php echo htmlspecialchars($_FILES['image']['name']); ?>" style="max-width:48px; max-height:48px" /><br /><input type="text" readonly="readonly" value="[img]<?php echo htmlspecialchars($base_config['baseurl']); ?>/static/userimages/<?php echo $db->insert_id() . '.' . $ext; ?>[/img]" size="50" /><br /><a href="<?php echo $base_config['baseurl']; ?>/extensions/uploadimage">Upload another image</a></p>
						<?php
					}
				}
			} else {
				?>
			<form action="<?php echo $base_config['baseurl']; ?>/extensions/uploadimage" method="post" enctype="multipart/form-data">
				<p>Upload image: <input type="file" name="image" accept="image/*" /><br />(.png, .gif, .jpg accepted) <input type="submit" value="<?php echo translate('submit'); ?>" /></p>
				<?php
				$result = $db->query('SELECT id,extension,filename FROM `#^userimages` WHERE time>' . (time() - 60 * 60 * 24) . ' AND user=' . $futurebb_user['id'] . ' ORDER BY time DESC') or enhanced_error('Failed to get recent images', true);
				if ($db->num_rows($result)) {
					echo '<p style="font-weight:bold">Your recent images</p>';
					echo '<table border="0px">';
					echo '<tr><th>Image</th><th>Code</th></tr>';
					while ($img = $db->fetch_assoc($result)) {
						echo '<tr><td><img src="' . htmlspecialchars($base_config['baseurl']) . '/static/userimages/' . $img['id'] . '.' . $img['extension'] . '" alt="' . htmlspecialchars($img['filename']) . '" style="max-width:48px; max-height:48px" /></td><td><input type="text" readonly="readonly" value="[img]' . htmlspecialchars($base_config['baseurl']) . '/static/userimages/' . $img['id'] . '.' . $img['extension'] . '[/img]" size="50" /></td></tr>';
					}
					echo '</table>';
				}
				echo '<p><a href="' . $base_config['baseurl'] . '/myimages" target="_BLANK">View all of your images</a></p>';
				?>
			</form>
				<?php
			}
			?>
		</div>
	</body>
	
</html>
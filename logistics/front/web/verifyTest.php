<?php
// See the password_hash() example to see where this came from.
$hash = '$2y$13$LcwDZoeaWm1HVglBwhNvQuX3H7c5GXO98B6hYOgKA9sRZ4WiYYTfW';

if (password_verify('lj2016', $hash)) {
	echo 'Password is valid!';
} else {
	echo 'Invalid password.';
}
?>
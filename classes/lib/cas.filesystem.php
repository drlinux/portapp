<?php
class CasFilesystem
{
	public function listDirectories ($path = '.')
	{
		$arr = array();
		$ignore = array('cgi-bin', '.', '..', '.htaccess');
		if (is_dir($path)) {
			if ($dh = opendir($path)) {
				while (($file = readdir($dh)) !== false) {
					if (!in_array($file, $ignore)) {
						//echo "filename: $file : filetype: " . filetype($path . $file) . "<br/>";
						$arr[$file] = $file;
					}
				}
				closedir($dh);
			}
		}
		return ($arr);
	}

	public function getDirectory ($path = '.', $level = 0)
	{

		$ignore = array('cgi-bin', '.', '..');
		// Directories to ignore when listing output. Many hosts
		// will deny PHP access to the cgi-bin.

		$dh = @opendir( $path );
		// Open the directory to the handle $dh

		while( false !== ( $file = readdir( $dh ) ) ){
			// Loop through the directory

			if( !in_array( $file, $ignore ) ){
				// Check that this file is not to be ignored

				$spaces = str_repeat( '&nbsp;', ( $level * 4 ) );
				// Just to add spacing to the list, to better
				// show the directory tree.

				if( is_dir( "$path/$file" ) ){
					// Its a directory, so we need to keep reading down...

					echo "<strong>$spaces $file</strong><br />";
					$this->getDirectory( "$path/$file", ($level+1) );
					// Re-call this same function but on a new directory.
					// this is what makes function recursive.

				} else {

					echo "$spaces $file<br />";
					// Just print out the filename

				}

			}

		}

		closedir( $dh );
		// Close the directory handle

	}

}
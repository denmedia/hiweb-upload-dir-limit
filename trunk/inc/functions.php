<?php
	
	function hw_uploadDirLimit_getUploadSize(){
		$uploadDir = wp_upload_dir();
		$path = str_replace($uploadDir['subdir'],'',$uploadDir['path']);
		return hw_uploadDirLimit_folderSize($path);
	}
	
	
	function hw_uploadDirLimit_folderSize($path) {
		$total_size = 0;
		$files = scandir($path);
		$cleanPath = rtrim($path, '/'). '/';
		
		foreach($files as $t) {
			if ($t<>"." && $t<>"..") {
				$currentFile = $cleanPath . $t;
				if (is_dir($currentFile)) {
					$size = hw_uploadDirLimit_folderSize($currentFile);
					$total_size += $size;
				}
				else {
					$size = filesize($currentFile);
					$total_size += $size;
				}
			}
		}
		
		return $total_size;
	}
	
	
	function hw_uploadDirLimit_formatSize($size) {
		$units = array('b','Kb','Mb','Gb');
		
		$mod = 1024;
		
		for ($i = 0; $size > $mod; $i++) {
			$size /= $mod;
		}
		
		$endIndex = strpos($size, ".")+3;
		
		return substr( $size, 0, $endIndex).' '.$units[$i];
	}
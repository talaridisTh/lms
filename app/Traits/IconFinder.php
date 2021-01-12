<?php

namespace App\Traits;

trait IconFinder {

	public function fileIcon() {

		$icons = [
			"mp3" => "mdi-music-clef-treble",
			"ev3" => "mdi-robot-industrial",
			"pdf" => "mdi-file-pdf-outline text-danger",
			"html" => "mdi-language-html5 text-danger",
			"odg" => "mdi-file-pdf text-danger",
			"doc" => "mdi-file-document-outline text-teal",
			"odt" => "mdi-file-document-outline text-teal",
			"rtf" => "mdi-file-document-outline text-teal",
			"xl" => "mdi-file-table-box text-success",
			"ods" => "mdi-file-table-box text-success",
			"pp" => "mdi-file-powerpoint-outline text-orange",
			"odp" => "mdi-file-powerpoint-outline text-orange",
			"sb3" => "mdi-cat text-orange",
			"zip" => "mdi-folder-zip-outline text-warning",
			"rar" => "mdi-folder-zip-outline text-warning",
		];
		
		foreach( $icons as $type => $icon ) {
			if ( fnmatch("$type*", $this->ext ) ) {
				return $icon;
			}
		}
	}
}
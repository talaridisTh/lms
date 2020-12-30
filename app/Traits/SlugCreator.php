<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait SlugCreator {

	public function createSlug($title, $id = 0) {
		$slug = STR::slug($title);
		$allSlugs = $this->getRelatedSlugs($slug, $id);
		if ( ! $allSlugs->contains('slug', $slug) ){
			return $slug;
		}
	
		$i = 2;
		$exist = true;
		do {
			$newSlug = $slug . '-' . $i;
			if (!$allSlugs->contains('slug', $newSlug)) {
				$exist = false;
				return $newSlug;
			}
			$i++;
		} while ($exist);
	}

	protected function getRelatedSlugs($slug, $id = 0)
	{
		return $this::select('slug')->where('slug', 'like', $slug.'%')
			->where('id', '<>', $id)->get();
	}
}
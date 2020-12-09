<?php
namespace App\Init;

use Doctrine\Common\Collections\ArrayCollection;

class QcmCollection
{
	public static function _init($collections) :? ArrayCollection
	{
		if(!is_array($collections))
			throw new Exception("Le type de paramètre passé en argument doit être de type tableau", 1);

		return new ArrayCollection($collections);			
	}
}
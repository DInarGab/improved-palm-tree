<?

namespace Reaspekt;

use Reaspekt\Converters\ImageManipulator;
use Reaspekt\File\Interfaces\ImgFileInterface;

class Helpers
{
	public static function convertToWebp(ImgFileInterface $imgFile)
	{
		$converter = new ImageManipulator();
		return $converter->convertToWebp($imgFile);
	}
}
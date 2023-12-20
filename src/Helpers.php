<?

namespace Reaspekt;

use Reaspekt\Converters\WebpConverter;
use Reaspekt\File\Interfaces\ImgFileInterface;

class Helpers
{
	public static function convertToWebp(ImgFileInterface $imgFile)
	{
		$converter = new WebpConverter();
		return $converter->convertToWebp($imgFile);
	}
}
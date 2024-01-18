<?


namespace Reaspekt\Resizers;

use Reaspekt\File\ImgFile;

interface ResizerInterface
{
    public function resize(ImgFile $imgFile, $width, $height);
}
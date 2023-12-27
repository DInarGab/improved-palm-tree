<?


namespace Reaspekt\Resizers;

use Reaspekt\File\AbstractImgFile;

interface ResizerInterface {
    public function resize(AbstractImgFile $imgFile, $width, $height);
}
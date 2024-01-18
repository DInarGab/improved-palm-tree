<?

namespace Reaspekt;

use Reaspekt\Converters\Converter;
use Reaspekt\File\ImgFile;
use Reaspekt\Resizers\ResizerInterface;

class ImageManipulator
{
    /**
     * Resizer object used to resize input image
     * @var ResizerInterface
     */
    private ResizerInterface $resizer;


    public function setResizer(ResizerInterface $resizer)
    {
        $this->resizer = $resizer;
    }

    public function resize(ImgFile $img, $width, $height)
    {
        if (isset($this->resizer)) {
            return $this->resizer->resize($img, $width, $height);
        }
        throw new \Exception("Resizer is not set, use setResizer to set resizer obj");
    }

    public function convertToWebp(ImgFile $img)
    {
        return Converter::convertToWebp($img);
    }

    public function resizerIsSet()
    {
        return isset($this->resizer);
    }

}
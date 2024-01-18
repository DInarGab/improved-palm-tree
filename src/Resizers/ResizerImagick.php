<?

namespace Reaspekt\Resizers;
use Reaspekt\File\ImgFile;

class ResizerImagick implements ResizerInterface
{
    public function resize(ImgFile $imageFile, $width, $height)
    {
        $imagePathParts = pathinfo($imageFile->getPath());
        $newImageName = $imagePathParts['filename'] . "-" . $width . "-" . $height . "." .  $imagePathParts["extension"];
        $newImagePath = str_ireplace($imageFile->getFileName(), $newImageName, $_SERVER["DOCUMENT_ROOT"] . $imageFile->getPath());
        $newImageSrc = str_ireplace($imageFile->getFileName(), $newImageName, $imageFile->getPath());
        if (!file_exists($newImagePath)) {
            $imagick = new \Imagick(realpath($imageFile->getAbolutePath()));
            $imagick->resizeImage($width, $height, \Imagick::FILTER_LANCZOS, 1, true);
            $imagick->writeImage($newImageName);
            $imagick->clear();
            $imagick->destroy;
        }
        return new ImgFile($newImageSrc, true);
    }
}
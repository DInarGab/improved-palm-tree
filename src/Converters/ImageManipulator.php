<?



namespace Reaspekt\Converters;

use Reaspekt\File\AbstractImgFile;
use Reaspekt\File\ImgFile;

class ImageManipulator
{
    private AbstractImgFile $imageFile;

    private AbstractImgFile $originalImageFile;

    private $quality = "70";

    public function __construct(AbstractImgFile $originalImageFile)
    {
        $this->originalImageFile = $originalImageFile;
    }

    /**
     * Converts input ImgFileInterface to webp file 
     * @param \Reaspekt\File\AbstractImgFile $originalImageFile
     * @return AbstractImgFile
     */
    public function convertToWebp()
    {
        $webpPath = str_ireplace([".jpg", ".jpeg", ".png"], ".webp", $this->originalImageFile->getPath());
        if (!file_exists($webpPath)) {
            if ($this->originalImageFile->getMimeType() == 'image/png') {
                $image = $this->fromPng();
            } elseif ($this->originalImageFile->getMimeType() == 'image/jpeg') {
                $image = $this->fromJpg();
            }
            imagewebp($image, $_SERVER['DOCUMENT_ROOT'] . $webpPath, $this->quality);
            imagedestroy($image);
    
            if (filesize($_SERVER['DOCUMENT_ROOT'] . $webpPath) % 2 == 1) {
                file_put_contents($_SERVER['DOCUMENT_ROOT'] . $webpPath, "\0", FILE_APPEND);
            }
        }
        return new ImgFile($webpPath, true);
    }

    public function resize(AbstractImgFile $image, $width, $height)
    {
        $imagePathParts = pathinfo($image->getPath());
        $newImageName = $imagePathParts['filename'] . "_" . $width . "-" . $height . $imagePathParts["extension"];
        $newImagePath = str_ireplace($image->getFileName(), $newImageName, $_SERVER["DOCUMENT_ROOT"] . $image->getPath());
        if (!file_exists($newImagePath)) {
            $imagick = new \Imagick(realpath($image->getAbolutePath()));
            $imagick->resizeImage($width, $height, \Imagick::FILTER_LANCZOS, 1, true);
            $imagick->writeImage($newImageName);
            $imagick->clear();
            $imagick->destroy;
        }
        return new ImgFile($newImagePath, true);
    }


    private function fromJpg()
    {
        $image = imagecreatefromjpeg($_SERVER['DOCUMENT_ROOT'] . $this->originalImageFile->getPath());
        return $image;
    }

    private function fromPng()
    {
        $image = imagecreatefrompng($_SERVER['DOCUMENT_ROOT'] . $this->originalImageFile->getPath());
        imagepalettetotruecolor($image);
        imagealphablending($image, true);
        imagesavealpha($image, true);
        return $image;
    }

    /**
     * @param int $quality 
     * @return self
     */
    public function setQuality(int $quality): self
    {
        if (!is_numeric($quality) || $quality > 100 || $quality <= 0) {
            throw new \InvalidArgumentException("Must be a number higher than zero and lower or equal to 100");
        }
        $this->quality = $quality;
        return $this;
    }
}
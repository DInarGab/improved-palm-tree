<?



namespace Reaspekt\Converters;

use Reaspekt\File\Interfaces\ImgFileInterface;
use Reaspekt\File\ImgFile;

class WebpConverter
{
    private ImgFileInterface $imageFile;

    private ImgFileInterface $originalImageFile;

    private $quality = "70";

    public function convertToWebp(ImgFileInterface $originalImageFile)
    {
        $this->originalImageFile = $originalImageFile;
        $webpPath = str_ireplace([".jpg", ".jpeg", ".png"], ".webp", $this->originalImageFile->getPath());
        if (!file_exists($webpPath)) {
            if ($this->originalImageFile->getMimeType() == 'image/png') {
                $image = $this->pngToWebp();
            } elseif ($this->originalImageFile->getMimeType() == 'image/jpeg') {
                $image = $this->jpgToWebp();
            }
            imagewebp($image, $_SERVER['DOCUMENT_ROOT'] . $webpPath, $this->quality);
            imagedestroy($image);
    
            if (filesize($_SERVER['DOCUMENT_ROOT'] . $webpPath) % 2 == 1) {
                file_put_contents($_SERVER['DOCUMENT_ROOT'] . $webpPath, "\0", FILE_APPEND);
            }
        }
        $this->imageFile = new ImgFile($webpPath, true);
        return $this->imageFile;
    }


    private function jpgToWebp()
    {
        $image = imagecreatefromjpeg($_SERVER['DOCUMENT_ROOT'] . $this->originalImageFile->getPath());
        return $image;
    }

    private function pngToWebp()
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
<?



namespace Reaspekt\Converters;

use Reaspekt\File\ImgFile;

class Converter
{
    private const QUALITY = 80;

    /**
     * Converts input ImgFileInterface to webp file 
     * @param \Reaspekt\File\ImgFile $originalImageFile
     * @return ImgFile
     */
    public static function convertToWebp(ImgFile $image)
    {
        $webpPath = str_ireplace([".jpg", ".jpeg", ".png"], ".webp", $image->getPath());
        if (!file_exists($webpPath)) {
            if ($image->getMimeType() == 'image/png') {
                $image = static::fromPng($image);
            } elseif ($image->getMimeType() == 'image/jpeg') {
                $image = static::fromJpg($image);
            }
            imagewebp($image, $_SERVER['DOCUMENT_ROOT'] . $webpPath, self::QUALITY);
            imagedestroy($image);
    
            if (filesize($_SERVER['DOCUMENT_ROOT'] . $webpPath) % 2 == 1) {
                file_put_contents($_SERVER['DOCUMENT_ROOT'] . $webpPath, "\0", FILE_APPEND);
            }
        }
        return new ImgFile($webpPath, true);
    }


    private static function fromJpg(ImgFile $imageFile)
    {
        $image = imagecreatefromjpeg($imageFile->getAbolutePath());
        return $image;
    }

    private static function fromPng($imageFile)
    {
        $image = imagecreatefrompng($imageFile->getAbolutePath());
        imagepalettetotruecolor($image);
        imagealphablending($image, true);
        imagesavealpha($image, true);
        return $image;
    }

}
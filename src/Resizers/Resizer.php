<?

namespace Reaspekt\Resizers;

use Reaspekt\File\AbstractImgFile;
use Reaspekt\File\ImgFile;

class Resizer implements ResizerInterface
{

    /**
     * Resizes input Image saving aspect ratio, saves new Image in same folder, adds suffix to filename with input width and height. 
     * Resulting image might have different width and height than provided params to correctly save aspect ration of image.
     * @param \Reaspekt\File\AbstractImgFile $imgFile
     * @param mixed $width output image width
     * @param mixed $height output image height
     * @return ImgFile
     */
    public function resize(AbstractImgFile $imgFile, $width, $height)
    {
        $imagePathParts = pathinfo($imgFile->getPath());
        $newImageName = $imagePathParts['filename'] . "-" . $width . "-" . $height . "." .  $imagePathParts["extension"];
        $newImagePath = str_ireplace($imgFile->getFileName(), $newImageName, $_SERVER["DOCUMENT_ROOT"] . $imgFile->getPath());
        $newImageSrc = str_ireplace($imgFile->getFileName(), $newImageName, $imgFile->getPath());
        if (!file_exists($newImagePath)) {

            $aspectRatio = $imgFile->getWidth() / $imgFile->getHeight();
            if ($width / $height > $aspectRatio) {
                $newWidth = $height * $aspectRatio;
                $newHeight = $height;
            } else {
                $newWidth = $width;
                $newHeight = $width / $aspectRatio;
            }
            switch ($imgFile->getMimeType()) {
                case "image/png":
                    $imageGd = imagecreatefrompng($imgFile->getAbolutePath());
                break;
                default:
                    $imageGd = imagecreatefromjpeg($imgFile->getAbolutePath());
                break;
            }
            $newImage = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($newImage, $imageGd, 0, 0, 0, 0, $newWidth, $newHeight, $imgFile->getWidth(), $imgFile->getHeight());
            switch ($imgFile->getMimeType()) {
                case "image/png":
                    imagepalettetotruecolor($newImage);
                    imagealphablending($newImage, true);
                    imagesavealpha($newImage, true);
                    imagepng($newImage, $newImagePath);
                break;
                default:
                    imagejpeg($newImage, $newImagePath);
                break;
            }
            imagedestroy($newImage);
        }
        return new ImgFile($newImageSrc, true);
    }
}

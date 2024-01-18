<?

namespace Reaspekt;

use Reaspekt\File\ImgFile;
use Reaspekt\ImageManipulator;

class PictureRenderer
{
    public ImageManipulator $imageManipulator;

    public function __construct(ImageManipulator $imageManipulator)
    {
        if (!$imageManipulator->resizerIsSet()) {
            throw new InvalidArgumentException("Image Manipulator must have resizer");
        }
        $this->imageManipulator = $imageManipulator;
    }
    public function render(ImgFile $imgFile, array $sizes) {

        $resizedImgsArray = $this->batchResizeAndConvert($imgFile, $sizes);
        return $this->renderPicture($resizedImgsArray);
    }

    private function batchResizeAndConvert($img, array $sizes) {
        $images = [];
        foreach ($sizes as $media => $size) {
            list($width, $height) = $size;
            $resizedImage = $this->imageManipulator->resize($img, $width, $height);
            $resizedWebp = $this->imageManipulator->convertToWebp($resizedImage);
            $images[$media] = [
                'resized_webp' => $resizedWebp,
                'resized' => $resizedImage
            ];
        }
        return $images;
    }
    private function renderPicture($resizedImgsArray) {
        $pictureTag = '<picture>%s</picture>';

        $sourceTag = '<source srcset="%s" media="%s" type="%s" />';
        $imgTag = '<img src="%s" alt="">';
        $result = '';
        foreach ($resizedImgsArray as $media => $resizedImg) {
            $webpImg = $resizedImg["resized_webp"];
            $img = $resizedImg["resized"];
            //adding Source Tags
            $result .= sprintf($sourceTag, $webpImg->getPath(), $media, $webpImg->getMimeType());
            $result .= sprintf($sourceTag, $img->getPath(), $media, $img->getMimeType());
            if (array_key_last($resizedImgsArray) == $media) {
                //Adding img tag as last item
                $result .= sprintf($imgTag, $img->getPath());
            }
        }
        return sprintf($pictureTag, $result); 
    }
}
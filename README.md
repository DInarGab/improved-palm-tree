
## About

Just test library

## How To Use


Основной объект ImageManipulator, пока имеет 2 метода:


- resize - метод уменьшает размер изображения. Работает с jpg и png. Работает только если предварительно установлен Resizer методом setResizer. Пока можно использовать стандартный Resizer, который создает изменяет размер изображения стандартными функциями PHP и ResizerBitrix, который использует CFile::ResizeImageGet (для работы необходимо передать объект типа BitrixImg Adapter)

- convertToWebp - метод конвертирует изображение в .webp формат.

Пока оба метода сохраняют изображения в той же директории, что и оригинальный файл (кроме случая с битриксом: resize сохраняет изображение в папку upload/resize_cache/далее путь изображения)

### Пример использования: 

Создаем изображение
```php
$imgFile = new ImgFile('/upload/mechanoobrab_service.jpg');
``` 
Создаем объект класса ImageManipulator
```php
$imageManipulator = new ImageManipulator();
```
Создаем один из доступных ресайзеров и устанавливаем его в ImageManipulator:
 - Resizer - использует стандартные php методы требуется только GD Библиотеки
 - ResizerBitrix - использует ресайзер Битрикса под капотом.
 - ResizerImagick - использует Imagick Extension
```php
$imageManipulator->setResizer(new Resizer());
```
Конвертируем изображение в WebP
```php
$webpImage = $imageManipulator->convertToWebp($imgFile);
```
Ресайз изображения
```php
$resizedImage = $imageManipulator->resize($imgFile, 300, 400);
```
Конвертирование ресайзнутого изображения в Webp
```php
$webpResized = $imageManipulator->convertToWebp($resizedImage);
```
Отрисовка изображения - PictureRenderer принимает на вход объект класса ImageManipulator с установленным Ресайзером и использует ImageManipulator для генерации файлов и дальнейшего рендера тега picture 
```php
$pictureRenderer = new PictureRenderer($imageManipulator);
```
В метод render передаем оригинальный файл и массив с параметрами: ключи массива значения media атрибута, значения - массив из 2х элементов ширины и высоты нового изображения
```php
$pictureTag = $pictureRenderer->render($imgFile, [
    '(max-width: 650px)' => [
        200, 100
    ],
    '(max-width: 1080px)' => [
        300, 150
    ],
    '(min-width: 1080px)' => [
        500, 300
    ]
]);
```
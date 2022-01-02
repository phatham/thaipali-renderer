<?php
require __DIR__ . '/vendor/autoload.php';
use Jcupitt\Vips;
$text = 'นโม ตสฺส ภควโต อรหโต สมฺมาสมฺพุทธสฺส ฯ';
if(isset($_GET['input']) && strlen($_GET['input']) <= 500){
        $text = $_GET['input'];
}
if(isset($_GET['noligature'])){
        $text = str_replace('ญ', 'ญฃ', $text);
        $text = str_replace('ฐ', 'ฐฃ', $text);
}
// fast thumbnail generator
$mask = Vips\Image::text($text,
    ['dpi' => 300, 'font' => 'TH Sarabun Pali', 'fontfile' => 'THSarabunPali.ttf']);
if(isset($_GET['pad'])){
        $mask = $mask->embed(20, 10, $mask->width + 40, $mask->height + 20, ['extend' => Vips\Extend::BLACK]);
}
$image = $mask->ifthenelse([0,0,0], [255,255,255], ['blend' => true]);
header('Content-type: image/png');
echo $image->writeToBuffer('.png');

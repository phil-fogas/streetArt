<?php

function convert_data_url($data_url) {
   // Assumes the data URL represents a JPEG image
   $image = base64_decode( str_replace('data:image/jpeg;base64,', '', $data_url));
   save_to_file($image);
}

function save_to_file($image) {
   $fp = fopen('monimage.jpg', 'w');
   fwrite($fp, $image);
   fclose($fp);
}

convert_data_url($file);
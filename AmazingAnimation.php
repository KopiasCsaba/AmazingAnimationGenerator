#!/usr/bin/php
<?php
/**
 *
 * Copyright 2012 Kopiás Csaba [ http://kopiascsaba.hu ]
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 */

$options = getopt("", array("frames:", "wdir:", "help"));

if (!isset($argv[1]) || isset($options['help'])) {
    print "
Amazing Animation Generator

--frames The glob mask for the image sequence
--wdir   The output directory, by default /tmp

Example:
 ./AmazingAnimation.php  --frames 'demo/render/*' --wdir demo/final
 ./AmazingAnimation.php  --frames 'demo/render/kcs*.png' --wdir demo/final

";
    exit(0);
}


$options["wdir"] = $options["wdir"] == "" ? '/tmp/' : $options["wdir"];
if (!file_exists($options["wdir"])) {
    mkdir($options["wdir"], 0777, true);
}

$frameFiles = glob($options['frames']);
sort($frameFiles);
$frameCount = count($frameFiles);
if ($frameCount == 0) {
    print "No image have been found!\n";
    exit(1);
}
list($w, $h) = getimagesize($frameFiles[0]);
$columnCount = floor($w / ($frameCount));


printf("Creating Amazing Animation\nSize: %sx%s, Frame count: %s, Output Directory: %s\nFiles:\n%s\n\n",
    $w, $h, $frameCount, $options['wdir'], implode("   \n", $frameFiles));


/*
 * CREATING THE MASK
 */
$mask = imagecreatetruecolor($w, $h);
imagealphablending($mask, false);
imagesavealpha($mask, true);
imagefill($mask, 0, 0, imagecolorallocatealpha($mask, 255, 255, 255, 127));

$black = imagecolorallocate($mask, 0, 0, 0);

$x = 0;
for ($col = 0; $col < $columnCount; $col++) {
    imagefilledrectangle($mask, $x, 0, $x + $frameCount - 2, $h, $black);
    $x += $frameCount;
}
imagepng($mask, $options['wdir'] . "/mask.png");


/*
 * CREATING THE BASE
 */

$base = imagecreatetruecolor($w, $h);
imagefill($base, 0, 0, imagecolorallocate($base, 255, 255, 255));
$black = imagecolorallocate($base, 0, 0, 0);


foreach ($frameFiles as $frameNumber => $fileName) {
    print "Processing $fileName\n";

    $frame = imagecreatefrompng($fileName);

    $x = 0;
    for ($col = 0; $col < $columnCount; $col++) {
        $srcx = ($col * $frameCount);
        $dstx = ($col * $frameCount) + $frameNumber;
        imagecopy($base, $frame, $dstx, 0, $srcx, 0, 1, $h);
    }
}

imagepng($base, $options['wdir'] . "/sum.png");


/**
 * PUTTING THE TEST HTML OUT
 */

$html = <<<NEVERUSEHEREDOC
<head>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
<script>

    $(function() {
        $( "#mask" ).draggable({'axis':'x'});
    });
</script>
</head><body style='margin:0px;'>

<img src='sum.png'>
   <div id='mask' style='position:absolute;left:0px;top:0px;'>
<img  src='mask.png'>
</div>
NEVERUSEHEREDOC;

file_put_contents($options['wdir'] . "/test.html", $html);

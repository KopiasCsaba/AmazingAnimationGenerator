# AmazingAnimationGenerator
This is a PHP CLI script, that creates the base image and the mask for this special optical illusion.

This script takes an animation's frames, and outputs the Amazing Animation as made popular (or at least known to me)
by brusspup: https://youtube.com/watch?v=UW5bcsax78I

If you print the two images (the mask should be printed on a transparent foil) then it will look awesome in real life too.

# Demo

There is a demo rendering and output included:
<br>
<img src='https://raw.githubusercontent.com/KopiasCsaba/AmazingAnimationGenerator/master/docs/conversion.png' width=250> 

The output is two files, the mask and the base image and a test.html which let's you drag and drop the mask above the base, see it in action here:
http://youtube.com/watch?v=Kt-P-qZyrTo

# Usage

```
$ ./AmazingAnimation.php --help
Amazing Animation Generator  
--frames The glob mask for the image sequence  
--wdir   The output directory, by default /tmp                                                                                   

Example:
./AmazingAnimation.php  --frames 'demo/render/*' --wdir demo/final
./AmazingAnimation.php  --frames 'demo/render/kcs*.png' --wdir demo/final
```


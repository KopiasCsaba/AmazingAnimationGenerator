# AmazingAnimationGenerator
This is a PHP CLI script, that creates the base image and the mask for this special optical illusion.

This script takes an animation's frames, and outputs the Amazing Animation as made popular (or at least known to me)
by brusspup: https://www.youtube.com/watch?v=UW5bcsax78I

# Demo

There is a demo rendering and output included:
<img src='https://raw.githubusercontent.com/KopiasCsaba/AmazingAnimationGenerator/master/docs/conversion.png' width=250> 

<iframe width="560" height="315" src="https://www.youtube.com/embed/Kt-P-qZyrTo" frameborder="0" allowfullscreen></iframe>

# Usage

```
$ ./AmazingAnimation.php --help
Amazing Animation Generator                                                                                                       --frames The glob mask for the image sequence                                                                                     --wdir   The output directory, by default /tmp                                                                                   

Example:                                                                                                                          ./AmazingAnimation.php  --frames 'demo/render/*' --wdir demo/final                                                                ./AmazingAnimation.php  --frames 'demo/render/kcs*.png' --wdir demo/final
```


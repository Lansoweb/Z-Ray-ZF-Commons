Z-Ray-ZF-Commons
================

Z-Ray extension for Zf-Commons

#### Z-Ray
Z-Ray is an awesome resource from Zend Server that provides several information about the request, errors and the framework. It also has the possibility to add your own informations, so i added the StaticLogger messages to it.

More information can be seen [here](http://www.zend.com/en/products/server/z-ray-top-7-features).

Warning: The Z-Ray extensions works only on Zend Server 8 or greater.

##### Installation
To use this extension with Z-Ray, follow these steps:

1- Locate the zray extension directory on your zend server. 

For example on Mac/Linux, it can be found on:
/usr/local/zend/var/zray/extensions

2- Create a directory called ZF-Commons

3- Copy the zray.php and logo.png to this directory

The final result should be:
```
ls /usr/local/zend/var/zray/extensions/ZF-Commons/
logo.png	zray.php
```

And you're done. Now whenever you access a page with ZfcUser for example, you can see a new tab on the Z-Ray.

Some print screens can be found in the samples folder.

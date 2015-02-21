# util-bundle
A symfony2 bundle witch provide util classes to use with other bundles and a UtilController
that has some alias methods to simplify things.

# Installation

- Include this in your composer.json
```
    "repositories": [{
        "type": "vcs",
        "url": "https://github.com/OfCoding/util-bundle.git"
    }],
```
- Add next line to "require" section in composer.json:
```
    "ofcoding/util-bundle": "dev-master"
```
- Install the bundle via composer:
```
$ composer update
```
- Add next line to bundles array in app/AppKernel.php:
``` php
     new OfCoding\UtilBundle\OFCUtilBundle()
```

You're done!

# Usage

- UtilController: To use it just extend from this controller in any controller you want.
    Example
``` php
namespace OfCoding\ExampleBundle\Controller;

// Import UtilController
use OfCoding\UtilBundle\Controller\UtilController;

class ExampleController extends UtilController {
    ...
}
```
Now you can send an email, add a flash message and use doctrine from your controller like this:
``` php
public function exampleAction(Request $req) {
    // Send an email.
    $this->mailing($subject, $from, $to, $view);
    // Add flash message
    $this->flashMsg($type, $msg);
    // Use doctrine repository
    $this->doctrineRepo('OFCExampleBundle:Example')->loadExample();
}
``` 

- Util Entities: There are several util classes for strings, time, images and browser.
``` php
// Import StrUtil
use OfCoding\UtilBundle\Entity\StrUtil;
// Import ImgUtil
use OfCoding\UtilBundle\Entity\ImgUtil;

class ExampleController extends UtilController {
    ...
    public function saveWhatEver() {
        // Let's create a slug...
        $name = "What Ever's name";
        $slug = StrUtil::slug($name) // Resulting slug would be "what-ever-s-name"
        
        // Resize any Image to a Fixed Size
        ImgUtil::resizeFixedSize($src_file, $dst_file, $dst_width, $dst_height);
    }
    ...
}
```


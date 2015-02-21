# util-bundle
A symfony2 bundle witch provide util classes to use with other bundles and a UtilController
that has some alias methods to simplify things.

# Installation

- Include this in your composer.json
```
    "repositories": [{
        "type": "vcs",
        "url": "https://github.com/josecash/util-bundle.git"
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
// Import StrUtil to create a slug.
use OfCoding\UtilBundle\Entity\StrUtil;

class ExampleController extends UtilController {
    ...
    public function saveWhatEver() {
        $name = "What Ever's name";
        $whatEver = new Object();
        $whatEver->setName($name);
        // StrUtil Resulting slug would be "what-evers-name"
        $whatEver->setSlug(StrUtil::slug($name));
    }
    ...
}
```


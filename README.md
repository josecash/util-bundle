# util-bundle
A symfony2 bundle with util classes to use with other bundles.

# Installation

- Include this in your composer.json<br/>
    "repositories": [{
        "type": "vcs",
        "url": "https://github.com/josecash/util-bundle.git"
    }],

- Add next line to "require" section in composer.json:
    "ofcoding/util-bundle": "dev-master"

- Add next line to bundles array in app/AppKernel.php:
     new OfCoding\UtilBundle\OFCUtilBundle()

You're done!

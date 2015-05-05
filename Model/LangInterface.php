<?php

namespace Kimerikal\UtilBundle\Model;

use Symfony\Component\HttpFoundation\Request;

interface LangInterface {
    public function checkLang(Request $request);
}

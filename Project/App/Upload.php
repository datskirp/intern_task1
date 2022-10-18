<?php

namespace App;

class Upload
{
    private $validator;
    private $view;
    private $validatorRules;

    public function __construct(Validator\Validator $validator, View $view, $validatorRules)
    {
        $this->validator = $validator;
        $this->view = $view;
        $this->validatorRules = $validatorRules;
    }

    public function index()
    {
        $this->view->renderHtml('Upload.html.twig');
    }

    public function upload(?array $file, string $fileName)
    {
        if (is_null($file)) {
            return $this->view->render400();
        }
        $this->validator->validate($file[$fileName], $this->validatorRules);
    }

}
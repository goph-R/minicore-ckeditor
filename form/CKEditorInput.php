<?php

class CKEditorInput extends Input {
    
    private $baseUrl;
    private $options = [];
    
    public function __construct(Framework $framework, $name, $defaultValue = '') {
        parent::__construct($framework, $name, $defaultValue);
        /** @var Router $router */
        $router = $framework->get('router');
        $this->baseUrl = $router->getBaseUrl();
    }
    
    public function setOptions($options) {
        $this->options = $options;
    }

    public function fetch() {        
        $result = '<textarea ';
        $result .= ' id="'.$this->getId().'"';
        $result .= ' name="'.$this->form->getName().'['.$this->getName().']"';
        $result .= $this->getClassHtml();
        $result .= '>'.$this->getValue().'</textarea>';
        $this->addScript();
        return $result;
    }
    
    private function addScript() {
        $optionsJson = json_encode($this->options);
        $script = "<script>";
        $script .= "ClassicEditor";
        $script .= ".create(document.querySelector('#".$this->getId()."'), ".$optionsJson.")";
        $script .= ".catch(error => { console.error( error ); } );";
        $script .= "</script>\n";
        $this->view->addScript($this->baseUrl.'modules/minicore-ckeditor/static/ckeditor.js');
        $this->view->appendBlock('scripts');
        $this->view->write($script);
        $this->view->endBlock();        
    }

}

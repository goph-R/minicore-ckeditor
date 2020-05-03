<?php

class CkEditorInput extends Input {
    
    private $options = [];
    
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
        $this->view->addScript('/modules/minicore-ckeditor/static/ckeditor.js');
        $optionsJson = json_encode($this->options);
        $script = "<script>";
        $script .= "ClassicEditor";
        $script .= ".create(document.querySelector('#".$this->getId()."'), ".$optionsJson.")";
        $script .= ".catch(error => { console.error( error ); } );";
        $script .= "</script>\n";
        $this->view->appendBlock('scripts');
        $this->view->write($script);
        $this->view->endBlock();
    }

}

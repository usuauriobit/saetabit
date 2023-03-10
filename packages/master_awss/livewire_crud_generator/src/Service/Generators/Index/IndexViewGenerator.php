<?php
namespace MasterAWSS\LivewireCrudGenerator\Service\Generators\Index;

use MasterAWSS\LivewireCrudGenerator\Service\Getters\Index\IndexViewGetter;

class IndexViewGenerator extends IndexViewGetter{
    public function __construct($name, $options){
        parent::__construct($name, $options);
    }
    public function build(){

        $template_paths = $this->getTemplatePaths();

        foreach ($template_paths as $template_path) {
            $this->setFileTemplate(
                $this->getViewTemplateVariables(),
                $template_path['template_path'],
                $template_path['destination_path']
            );
        }
    }
}

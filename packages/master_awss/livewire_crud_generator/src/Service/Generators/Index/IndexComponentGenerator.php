<?php
namespace MasterAWSS\LivewireCrudGenerator\Service\Generators\Index;

use MasterAWSS\LivewireCrudGenerator\Service\BaseGenerator;
use MasterAWSS\LivewireCrudGenerator\Service\Getters\Index\IndexComponentGetter;

class IndexComponentGenerator extends IndexComponentGetter{
    public function __construct($name, $options){
        parent::__construct($name, $options);
    }
    public function build(){
        $template_paths = $this->getComponentPaths();

        // dd($template_paths);
        foreach ($template_paths as $template_path) {
            $this->setFileTemplate(
                $this->getComponentTemplateVariables(),
                $template_path['template_path'],
                $template_path['destination_path']
            );
        }
    }
}

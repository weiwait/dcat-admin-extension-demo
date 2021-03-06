<?php

namespace Weiwait\DcatVue\Field;

use Dcat\Admin\Form\Field;
use Dcat\Admin\Support\Helper;

class Tag extends Field\Tags
{
    protected $view = 'weiwait.dcat-vue::tag';

    public function render()
    {
        /****************************** parent ************************************/
        $value = Helper::array($this->value());

        if ($this->options instanceof \Closure) {
            $this->options(
                $this->options->call($this->values(), $value, $this)
            );
        }

        if ($this->keyAsValue) {
            $options = $value + $this->options;
        } else {
            $options = array_unique(array_merge($value, (array) $this->options));
        }

        $this->addVariables([
            'options'    => $options,
            'keyAsValue' => $this->keyAsValue,
        ]);

        /****************************** end parent ************************************/

        /****************************** field ************************************/

        if (!$this->shouldRender()) {
            return '';
        }

        $this->setDefaultClass();

        $this->callComposing();

        $this->withScript();

        /****************************** end field ************************************/

        $this->withProvides();

        $this->addVariables([
            'provides' => $this->variables(),
        ]);

        return view($this->view(), $this->variables());
    }

    protected function formatAttributes()
    {
        return $this->attributes;
    }

    protected function withProvides()
    {
        $this->addVariables([
            'component' => 'Tag',
       ]);
    }

    public function max(int $max): self
    {
        $this->addVariables(['max' => $max]);

        return $this;
    }
}

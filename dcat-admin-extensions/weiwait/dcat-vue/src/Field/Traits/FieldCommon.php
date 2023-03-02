<?php

namespace Weiwait\DcatVue\Field\Traits;

trait FieldCommon
{
    protected string $vid;

    public function __construct($column, $arguments = [])
    {
        parent::__construct($column, $arguments);

        $this->view = 'weiwait.dcat-vue::common';

        $this->makeVid();
    }

    public function makeVid(): static
    {
        $this->vid = 'vid' . md5(uuid_create());

        $this->addVariables([
            'vid' => $this->vid,
        ]);

        return $this;
    }

    public function vid(): string
    {
        return $this->vid;
    }
}

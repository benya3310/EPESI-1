<?php


class Base_Theme_TemplateStub
{
    public $vars = array();

    public function assign($key, $value)
    {
        $this->vars[$key] = $value;
    }

    public function __get_vars()
    {
        return $this->vars;
    }

    public function __assign_vars($obj)
    {
        foreach ($this->vars as $k => $v) {
            call_user_func_array(array($obj, 'assign'), array($k, $v));
        }
    }

}
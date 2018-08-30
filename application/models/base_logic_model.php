<?php

class Base_logic_model extends MY_Model
{
    protected $CI;

    function __construct()
    {
        $this->CI =& get_instance();
    }

}
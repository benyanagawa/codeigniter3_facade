<?php

class Test_model extends MY_Model
{


    public function __construct()
    {
        parent::__construct();
    }

    public function get_by_primary_key()
    {
        return true;
    }

}
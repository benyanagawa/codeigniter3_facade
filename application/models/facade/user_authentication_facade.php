<?php

require_once(APPPATH . '/models/base_facade_model' . EXT);

class User_authentication_facade extends Base_facade_model
{

    public function __construct()
    {
        parent::__construct();

        $this->CI->load->model('logic/user_authentication_logic');
    }

    public function index()
    {
        $result = $this->CI->user_authentication_logic->auth();

        return $result;
    }
}
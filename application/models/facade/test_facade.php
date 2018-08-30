<?php

require_once(APPPATH . '/models/base_facade_model' . EXT);

class Test_facade extends Base_facade_model
{

    public function __construct()
    {
        parent::__construct();

        $this->CI->load->model('logic/test_logic');
    }

    public function test()
    {
        $result_logic = $this->CI->test_logic->test();

        $result['result_logic'] = $result_logic;

        return $result;
    }
}
<?php

require_once(APPPATH . '/models/base_logic_model' . EXT);

class Test_logic extends Base_logic_model
{

    public function __construct()
    {
        parent::__construct();

        $this->CI->load->model('dao/test_model');
        $this->CI->load->model('dao/works_model');
    }

    public function test()
    {
        $result = $this->CI->test_model->get_by_primary_key();

var_dump(get_date('Y-m-d H:i:s', $this->CI->current_time));
exit;

        $result = $this->CI->works_model->get();

        return $result;
    }
}

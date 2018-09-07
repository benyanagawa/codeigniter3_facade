<?php
class Test extends CI_Controller
{

    /**
     * index template output
     */
    public function index() {
        if (!file_exists(APPPATH . 'views/test/' . __FUNCTION__ . '.php')) {
            show_404();
        }
        $data['title'] = ucfirst(__FUNCTION__);

        $this->load->view('templates/header', $data);
        $this->load->view('test/' . __FUNCTION__, $data);
        $this->load->view('templates/footer', $data);
    }


    /**
     * Controller Facade Logic Dao and json output
     */
    public function facade()
    {
        $this->load->model('facade/test_facade');
        $result = $this->test_facade->test();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

}

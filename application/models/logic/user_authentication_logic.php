<?php

require_once(APPPATH . '/models/base_logic_model' . EXT);

class User_authentication_logic extends Base_logic_model
{

    public function __construct()
    {
        parent::__construct();

        $this->CI->load->model('dao/user_authentications_model');

        //load google login library
        $this->CI->load->library('Google');
    }

    public function auth()
    {
        $data = null;

        if (isset($_GET['code'])) {
            //authenticate user
            $this->google->getAuthenticate();

            //get user info from google
            $gpInfo = $this->google->getUserInfo();

            //preparing data for database insertion
            $userData['oauth_provider'] = 'google';
            $userData['oauth_uid']      = $gpInfo['id'];
            $userData['first_name']     = $gpInfo['given_name'];
            $userData['last_name']      = $gpInfo['family_name'];
            $userData['email']          = $gpInfo['email'];
            $userData['gender']         = !empty($gpInfo['gender']) ? $gpInfo['gender'] : '';
            $userData['locale']         = !empty($gpInfo['locale']) ? $gpInfo['locale'] : '';
            $userData['profile_url']    = !empty($gpInfo['link']) ? $gpInfo['link'] : '';
            $userData['picture_url']    = !empty($gpInfo['picture']) ? $gpInfo['picture'] : '';

            //insert or update user data to the database
            $userID = $this->CI->user_authentications_model->checkUser($userData);

            //store status & user info in session
            $this->session->set_userdata('loggedIn', true);
            $this->session->set_userdata('userData', $userData);

            //redirect to profile page
            // redirect('user_authentication/profile/');
        }

        //google login url
        $data['loginURL'] = $this->google->loginURL();

        return $data;
    }
}

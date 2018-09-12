<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
|  Google API Configuration
| -------------------------------------------------------------------
|  client_id         string   Your Google API Client ID.
|  client_secret     string   Your Google API Client secret.
|  redirect_uri      string   URL to redirect back to after login.
|  application_name  string   Your Google application name.
|  api_key           string   Developer key.
|  scopes            string   Specify scopes
*/
$config['google']['client_id']        = '359946061792-kks22ks0bta7mchispg9g0b986307m7o.apps.googleusercontent.com';
$config['google']['client_secret']    = 'eCqcDPhxquQKRS1g78gu8rII';
$config['google']['redirect_uri']     = 'http://127.0.0.1:3000/user_authentication';
$config['google']['application_name'] = 'uroboros';
$config['google']['api_key']          = '';
$config['google']['scopes']           = [
    'https://www.googleapis.com/auth/userinfo.profile',
    'https://www.googleapis.com/auth/userinfo.email',
];
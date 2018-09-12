<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_authentications_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->primary_key = 'id';
    }

    public function checkUser($data = [])
    {
        $this->db->select($this->primary_key);
        $this->db->from($this->table_name);

        $where = [
            'oauth_uid' => $data['oauth_uid']
        ];

        $this->db->where($where);

        $query = $this->db->get();
        $check = $query->num_rows();

        if ($check > 0) {
            $result = $query->row_array();
            $data['modified'] = date("Y-m-d H:i:s");

            $update = [
                'id' => $result['id']
            ];

            $update = $this->db->update($this->table_name, $data, $update);
            $userID = $result['id'];
        } else {
            $data['created'] = date("Y-m-d H:i:s");
            $data['modified']= date("Y-m-d H:i:s");
            $insert = $this->db->insert($this->table_name, $data);
            $userID = $this->db->insert_id();
        }

        return $userID ? $userID : false;
    }
}
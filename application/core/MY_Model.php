<?php

class MY_Model extends CI_Model
{

    protected $table_name = null;

    private $CI;

    public function __construct()
    {
        parent::__construct();

        if ($this->table_name !== false) {
            $this->set_table_name($this->table_name);
        }
        $this->CI = &get_instance();
    }

    /**
     * model名からテーブル名をセットする
     * @param string $table_name テーブル名
     */
    public function set_table_name($table_name)
    {
        if (empty($table_name)) {
            $class = get_class($this);

            if ($class == "MY_Model") {
                $this->table_name = false;
            } else {
                $this->table_name = preg_replace("/_model$/", "", strtolower($class));
            }

        } else {
            $this->table_name = $table_name;
        }

        if (empty($this->table_name)) {

            if ($this->table_name !== false) {
                show_error(['message' => 'Undefined table name.', 'code' => $this->CI->status_code_ini['MODEL_ERROR']]);
            }

        }
    }

    /**
     * 範囲を指定して取得する
     * @param  integer  $limit          リミット
     * @param  integer  $offset         オフセット
     * @param  boolean  $without_delete 削除フラグを除外するか
     * @return array                    レコード配列
     */
    public function get($limit = null, $offset = null, $without_delete = true)
    {
        if (empty($this->table_name)) {
            throw new Exception(__CLASS__ . ':行数:' . __LINE__ . " this Model doesn't use Database.");
        }

        // 削除レコード除外時のみ条件をつける
        if ($without_delete) {
            // $this->where('delete_time', null);
        }

        return $this->db->get($this->table_name, $limit, $offset)->result_array();

    }

    /**
     * レコードを1件取得する
     * @param  array   $where          key valueでのwhere
     * @param  boolean $without_delete 削除フラグを除外するか
     * @return array                   レコード配列
     */
    public function get_record($where = null, $without_delete = true)
    {
        if (empty($this->table_name)) {
            throw new Exception(__CLASS__ . ':行数:' . __LINE__ . " this Model doesn't use Database.");
        }

        // 削除レコード除外時のみ条件をつける
        if ($without_delete) {
            // $this->where('delete_time', null);
        }

        if (!empty($where)) {
            $this->db->where($where);
        }

        return $this->db->get_record($this->table_name)->result_array();
    }


    /**
     * レコードをすべて取得する
     * @param  boolean $without_delete 削除フラグを除外するか
     * @return array                   レコード配列
     */
    public function get_list($without_delete = true)
    {
        if (empty($this->table_name)) {
            throw new Exception(__CLASS__ . ':行数:' . __LINE__ . " this Model doesn't use Database.");
        }

        // 削除レコード除外時のみ条件をつける
        if ($without_delete) {
            // $this->where('delete_time', null);
        }

        return $this->db->get_list($this->table_name)->result_array();

    }

    /**
     * レコードの挿入
     * @param  array   $data 挿入データ
     * @return integer       挿入件数
     */
    public function insert($data = null)
    {
        if (empty($this->table_name)) {
            throw new Exception(__CLASS__ . ':行数:' . __LINE__ . " this Model doesn't use Database.");
        }

        return (int) $this->db->insert($this->table_name, $data);
    }


    /**
     * レコードの更新
     * @param  array   $data  こうし
     * @param  array   $where where句
     * @param  integer $limit リミット
     * @return integer        更新件数
     */
    public function update($data = null, $where = null, $limit = null)
    {
        if (empty($this->table_name)) {
            throw new Exception(__CLASS__ . ':行数:' . __LINE__ . " this Model doesn't use Database.");
        }

        if (!empty($data)) {
            $this->db->set($data);
        }

        if (!empty($where)) {
            $this->db->where($where);
        }

        // 日付を自動で入れる。 time helper使用
        $update_time = '';
        if (isset($this->CI->current_time)) {
            $update_time = get_date('Y-m-d H:i:s', $this->CI->current_time);
        } else {
            $update_time = get_date('Y-m-d H:i:s');
        }
        $this->db->set('update_at', $update_time);

        return $this->db->update($this->table_name);
    }
}
<?php

class Commondb extends CI_Model {

    private $table_name;
    private $return;
    private $data_field;
    private $data_conditions;
    private $data_args;
    private $data_order;
    private $data_limit;
    private $data_offset;
    private $data_order_direction;

    function __construct() {
        parent::__construct();
        $this->table_name = '';
        $this->return = FALSE;
        $this->data_limit = 10;
        $this->data_offset = 0;
    }

    public function limit_offset($limit, $offset) {
        $this->data_limit = $limit;
        $this->data_offset = $offset;
        return $this;
    }

    public function table_name($table) {
        $this->table_name = $table;
        return $this;
    }

    public function orderBy($field) {
        $this->data_order = $field;
        return $this;
    }

    public function orderDir($direction) {
        $this->data_order_direction = $direction;
        return $this;
    }

    public function data_request($data) {
        $this->data_field = $data;
        return $this;
    }

    public function condition($condition) {
        $this->data_conditions = $condition;
        return $this;
    }

    public function args($args) {
        $this->data_args = $args;
        return $this;
    }

    function do_delete() {
        $this->return = false;
        if ($this->db->delete($this->table_name, $this->data_conditions)) {
            $this->return = TRUE;
        }
        return $this->return;
    }
    function do_empty() {
        $this->return = false;
        if ($this->db->empty_table($this->table_name)) {
            $this->return = TRUE;
        }
        return $this->return;
    }

    public function do_update() {

        if ($this->db->update($this->table_name, $this->data_field, $this->data_conditions)) {
            $this->return = TRUE;
        }
        return $this->return;
    }

    function do_insert($return = 'result') {
        $fields = array();
        $insert = array_merge($fields, $this->data_field);

        if ($this->db->insert($this->table_name, $insert)) {
            if ($return == 'result') {
                $this->return = TRUE;
            } elseif ($return == 'lastid') {
                $insert_id = $this->db->insert_id();
                $this->return = $insert_id;
            }
        }
        return $this->return;
    }

    function _update($table, $data, $conditions) {
        if ($this->db->update($table, $data, $conditions)) {
            $this->return = TRUE;
        }
        return $this->return;
    }

    function _save($table, $data, $return = 'result') {
        $fields = array();
        $insert = array_merge($fields, $data);

        if ($this->db->insert($table, $insert)) {
            if ($return == 'result') {
                $this->return = TRUE;
            } elseif ($return == 'lastid') {
                $insert_id = $this->db->insert_id();
                $this->return = $insert_id;
            }
        }
        return $this->return;
    }

    public function do_read($return = 'object') {
        if (!empty($this->data_conditions)) {
            foreach ($this->data_conditions as $key => $where) {
                $this->db->where($key, $where);
            }
        }

        if (!empty($this->data_order)) {
            if (!empty($this->data_order_direction)) {
                $this->db->order_by($this->data_order, $this->data_order_direction);
            } else {
                $this->db->order_by($this->data_order, "DESC");
            }
        }

        if ($this->data_limit != -1) {
            $this->db->limit($this->data_limit, $this->data_offset);
        }

        $query = $this->db->get($this->table_name);

        if ($return == 'object') {
            return $query->result();
        } else {
            return $query->result_array();
        }
    }

    public function _read($args = NULL, $tableName = NULL, $return = 'object') {


        if (array_key_exists("post_parent", $args)) {
            $this->db->where("post_parent", $args["post_parent"]);
        }

        if (array_key_exists("status", $args)) {
            $this->db->where("post_status", $args["status"]);
        }

        if (array_key_exists("condition", $args)) {
            foreach ($args['condition'] as $key => $where) {
                $this->db->where($key, $where);
            }
        }

        if (array_key_exists("post_type", $args)) {
            $this->db->where("post_type", $args["post_type"]);
        }

        if (array_key_exists("order_key", $args)) {
            if (array_key_exists("order_sort", $args)) {
                $this->db->order_by($args["order_key"], $args["order_sort"]);
            } else {
                $this->db->order_by($args["order_key"], "DESC");
            }
        }

        if (array_key_exists("limit", $args)) {
            if (array_key_exists("perpage", $args)) {
                $this->db->limit($args["offset"], $args["limit"]);
            } else {
                $this->db->limit($args["limit"]);
            }
        } else {
            if (array_key_exists("perpage", $args)) {
                $this->db->limit($args["offset"], 50000);
            }
        }

        $query = $this->db->get($tableName);
        if ($return == 'object') {
            return $query->result();
        } else {
            return $query->result_array();
        }
    }

}

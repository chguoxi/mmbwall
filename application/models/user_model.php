<?php
class User_model extends Base_model{
	public $user;
	public $tablename = 'users';
	public function __construct(){
		parent::__construct();
	}
	
	function initialize() {
		$is_anonymous = true;
		$sid = $this->session->userdata('session_id');
		$this->db->select(array('sid', 'uid', 'ipaddress', 'useragent', 'timestamp'));
		$this->db->where('sid', $sid);
		$query = $this->db->get('shared_sessions');
		if ($query->num_rows() > 0) {
			$item = current($query->result());
			if ($item->uid > 0) {
				$this->user = $item;
				$this->user = (object)array_merge((array)$this->user, (array)$this->load($this->user->uid));
				$is_anonymous = false;
			}
		}
		
		if ($is_anonymous) {
			$this->user = $this->anonymoususer();
		}
	}
	
	function anonymoususer() {
		$user = new stdClass();
		$user->uid = 0;
		$user->sid = $this->session->userdata('session_id');
		$user->ipaddress = $this->session->userdata('ip_address');
		$user->useragent = $this->session->userdata('user_agent');
		$user->timestamp = $this->session->userdata('timestamp');
		$user->roles[1] = 'anonymous user';
		
		return $user;
	}
	
	function load($uid) {
		$item = new stdClass();
		$this->db->select(array('u.*', 'a.name_'.$this->init->item('langID').' as country', 'a1.name_'.$this->init->item('langID').' as province', 'a2.name_'.$this->init->item('langID').' as city', 'i.name_'.$this->init->item('langID').' as industry'));
		$this->db->where('uid', $uid);
		$this->db->from($this->dbprefix('users').' u');
		$this->db->join($this->dbprefix('area').' a', 'a.aid = u.country_id', 'left');
		$this->db->join($this->dbprefix('area').' a1', 'a1.aid = u.province_id', 'left');
		$this->db->join($this->dbprefix('area').' a2', 'a2.aid = u.city_id', 'left');
		$this->db->join($this->dbprefix('industry').' i', 'i.iid = u.industry_id', 'left');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$item = current($query->result());
		}
		return $item;
	}
	
	function load_role(&$user) {
		if ($user->uid == 0) {
			return;
		}
		$user->permission = array();
		$user->roles = array();
		$user->roles[2] = 'authenticated user';
		
		$this->db->select(array('r.rid', 'r.name_'.$this->init->item('langID').' as name', 'r.permission'));
		$this->db->from($this->dbprefix('users_roles').' ur');
		$this->db->join($this->dbprefix('role').' r', 'r.rid = ur.rid', 'left');
		$this->db->where('ur.uid', $user->uid);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			foreach($query->result() as $item) {
				$user->roles[$item->rid] = $item->name;
				$user->permission = array_merge($user->permission, explode('|', $item->permission));
				$user->permission = array_unique($user->permission);
			}
		}
		$query->free_result();
	}
	
	function get($where, $fieldname = NULL) {
		$this->db->where($where);
		$query = $this->db->get($this->dbprefix('users'));
		if ($query->num_rows() > 0) {
			$item = current($query->result());
			if (is_null($fieldname)) {
				return $item;
			} else {
				return $item->$fieldname;
			}
		}
		return NULL;
	}
	
	function insert($data) {
		$this->db->insert($this->dbprefix('users'), $data);
		return $this->db->insert_id();
	}
	
	function update($data, $uid) {
		$this->db->where('uid', $uid);
		$this->db->update($this->dbprefix('users'), $data);
	}
	
	function exist($where = array(), $tablename = 'users') {
		$this->db->where($where);
		$query = $this->db->get($this->tablename);
		if ($query->num_rows() > 0) {
			return true;
		}
		return false;
	}

}
<?php if (!defined("BASEPATH")){ exit("No direct script access allowed"); }
/**
 * 
 * This model is based on Jamie Rumbelow's model with some personal modifications
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */


    
class Base_model extends CI_Model {

	public $tablename;
	protected $dbprefix;
	private $ci;
	
	function __construct()
	{
		parent::__construct();
		//$this->switch_database();
		$this->format_data();
	}
	

	function format_data() {
		if ( empty($this->tablename) ){
			$this->tablename = str_replace('_model', '', strtolower(get_class($this)));
		}
		$this->tablename = $this->dbprefix($this->tablename);
	}
	
	public function dbprefix($table){
		$this->ci = &get_instance();
		$shared_tables = $this->ci->config->item('shared_table');
		$mobile_tables = $this->ci->config->item('mobile_table');
		if (in_array($table, $shared_tables)){
			$tablename  = 'shared_'.$table;
		}
		elseif (in_array($table, $mobile_tables)){
			$tablename  = 'm_'.$table;
		}
		else {
			$tablename = $this->ci->config->item('lang_id').'_'.$table;
		}
		return $tablename;
	}
	
	function switch_database(){
		if (SITE_LANG != 'zh-cn'){
			//$this->load->database('aws',TRUE);
		}
	}
	
	function load_value($fieldname, $filterexpressions = NULL) {
		$this->format_filterexpressions($filterexpressions);
		$query = $this->db->get($this->tablename);
		if ($query->num_rows() > 0) {
			$item = current($query->result());
			if (isset($item->$fieldname)) {
				return $item->$fieldname;
			}
		}
		$query->free_result();
		return NULL;
	}
	
	function load_item($filterexpressions = NULL) {
		$item = new stdClass();
		$this->format_filterexpressions($filterexpressions);
		$query = $this->db->get($this->tablename);
		if ($query->num_rows() > 0) {
			$item = current($query->result());
		}
		$query->free_result();
		return $item;
	}
	
	function load_items($filterexpressions = NULL, $limitparameters = array(), &$totalcount = 0) {
		$items = array();
		$args = func_get_args();
		if (isset($args[2])) {
			$this->format_filterexpressions($filterexpressions);
			$this->db->from($this->tablename);
			$totalcount = $this->db->count_all_results();
		}
	
		if (is_array($limitparameters) && isset($limitparameters['rows'])) {
			$rows = $limitparameters['rows'];
			if (isset($limitparameters['offset'])) {
				$offset = $limitparameters['offset'];
			} else {
				$offset = 0;
			}
			$this->db->limit($rows, $offset);
		}
		$this->format_filterexpressions($filterexpressions);
		$this->db->from($this->tablename);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			foreach($query->result() as $item) {
				$items[] = $item;
			}
		}
		$query->free_result();
		return $items;
	}
	
	function load_totalcount($filterexpressions = NULL) {
		$this->format_filterexpressions($filterexpressions);
		return $this->db->count_all_results($this->tablename);
	}
	
	function exist($filterexpressions = NULL) {
		$this->format_filterexpressions($filterexpressions);
		$totalcount = $this->db->count_all_results($this->tablename);
		return $totalcount > 0 ? TRUE : FALSE;
	}
	
	function insert_by_primarykey($data, $primarykey = NULL) {
		if ($this->exist($primarykey)) {
			$this->update($data, $primarykey);
		} else {
			$this->insert($data);
		}
	}
	
	function insert_batch($data) {
		$this->db->insert_batch($this->tablename, $data);
	}
	
	function insert($data) {
		$this->db->insert($this->tablename, $data);
		return $this->db->insert_id();
	}
	
	function update_batch($data, $primarykey) {
		$this->db->update_batch($this->tablename, $data, $primarykey);
	}
	
	function update($data, $filterexpressions = NULL) {
		$this->format_filterexpressions($filterexpressions);
		$this->db->update($this->tablename, $data);
	}
	
	function delete($filterexpressions = NULL) {
		$this->format_filterexpressions($filterexpressions);
		$this->db->delete($this->tablename);
	}
	
	function format_filterexpressions($filterexpressions = NULL) {
		if (!is_null($filterexpressions) && is_array($filterexpressions)) {
			foreach($filterexpressions as $name => $filterexpression) {
				switch($name) {
					case 'distinct':
						$this->db->distinct();
						break;
					case 'where_in':
						foreach($filterexpression as $fieldname => $filterarray) {
							$this->db->where_in($fieldname, $filterarray);
						}
						break;
					case 'where_not_in':
						foreach($filterexpression as $fieldname => $filterarray) {
							$this->db->where_not_in($fieldname, $filterarray);
						}
						break;
					case 'limit':
						$this->db->limit($filterexpressions['limit'][0], $filterexpressions['limit'][1]);
						break;
					case 'order_by':
						foreach($filterexpression as $key => $value) {
							$this->db->order_by($key, $value);
						}
						break;
					case 'group_by':
						$this->db->group_by($filterexpression);
						break;
					case 'join':
						foreach($filterexpression as $key => $expression) {
							$this->db->join($expression[0], $expression[1], isset($expression[2]) ? $expression[2] : '');
						}
						break;
					default:
						$this->db->$name($filterexpression);
						break;
				}
			}
		}
	}
}
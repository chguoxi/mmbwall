<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

class LED_Session extends CI_Session {
	
	
	function get_uid() {
		$session = $this->CI->input->cookie($this->sess_cookie_name);
		$this->CI->load->model('Sessions_model','Msessions');
		$user = $this->CI->Msessions->load_item(array('where'=>array('sid'=>$session['sid'])));
		return isset($user->uid) ?$user->uid:0;
	}
	
	/**
	 * Fetch the current session data if it exists
	 *
	 * @access	public
	 * @return	bool
	 */
	function sess_read()
	{
		// Fetch the cookie
		$session = $this->CI->input->cookie($this->sess_cookie_name);
		
		// No cookie?  Goodbye cruel world!...
		if ($session === FALSE)
		{
			log_message('debug', 'A session cookie was not found.');
			return FALSE;
		}
		
		// Decrypt the cookie data
		if ($this->sess_encrypt_cookie == TRUE)
		{
			$session = $this->CI->encrypt->decode($session);
		}
		else
		{
			// encryption was not used, so we need to check the md5 hash
			$hash	 = substr($session, strlen($session)-32); // get last 32 chars
			$session = substr($session, 0, strlen($session)-32);

			// Does the md5 hash match?  This is to prevent manipulation of session data in userspace
			if ($hash !==  md5($session.$this->encryption_key))
			{
				log_message('error', 'The session cookie data did not match what was expected. This could be a possible hacking attempt.');
				$this->sess_destroy();
				return FALSE;
			}
		}
		
		// Unserialize the session array
		$session = $this->_unserialize($session);
	
		// Is the session data we unserialized an array with the correct format?
		if ( ! is_array($session) OR ! isset($session['sid']) OR ! isset($session['ipaddress']) OR ! isset($session['useragent']) OR ! isset($session['timestamp']))
		{
			$this->sess_destroy();
			return FALSE;
		}
		
		// Is the session current?
		if (($session['timestamp'] + $this->sess_expiration) < $this->now)
		{
			$this->sess_destroy();
			return FALSE;
		}
		
		// Does the IP Match?
		if ($this->sess_match_ip == TRUE AND $session['ipaddress'] != $this->CI->input->ip_address())
		{
			$this->sess_destroy();
			return FALSE;
		}
		
		// Does the User Agent Match?
		if ($this->sess_match_useragent == TRUE AND trim($session['useragent']) != trim(substr($this->CI->input->user_agent(), 0, 120)))
		{
			$this->sess_destroy();
			return FALSE;
		}
		
		// Is there a corresponding session in the DB?
		if ($this->sess_use_database === TRUE)
		{
			$this->CI->db->where('sid', $session['sid']);
	
			if ($this->sess_match_ip == TRUE)
			{
				$this->CI->db->where('ipaddress', $session['ipaddress']);
			}
	
			if ($this->sess_match_useragent == TRUE)
			{
				$this->CI->db->where('useragent', $session['useragent']);
			}
	
			$query = $this->CI->db->get($this->sess_table_name);
			// No result?  Kill it!
			if ($query->num_rows() == 0)
			{
				$this->sess_destroy();
				return FALSE;
			}
			
			// Is there custom data?  If so, add it to the main session array
			$row = $query->row();
			if (isset($row->user_data) AND $row->user_data != '')
			{
				$custom_data = $this->_unserialize($row->user_data);
	
				if (is_array($custom_data))
				{
					foreach ($custom_data as $key => $val)
					{
						$session[$key] = $val;
					}
				}
			}
		}
		
		// Session is valid!
		$this->userdata = $session;
		unset($session);
	
		return TRUE;
	}
	
	// --------------------------------------------------------------------
	/**
	 * Write the session data
	 *
	 * @access	public
	 * @return	void
	 */
	function sess_write()
	{
		// Are we saving custom data to the DB?  If not, all we do is update the cookie
		if ($this->sess_use_database === FALSE)
		{
			$this->_set_cookie();
			return;
		}
		
		// set the custom userdata, the session data we will set in a second
		$custom_userdata = $this->userdata;
		$cookie_userdata = array();
	
		// Before continuing, we need to determine if there is any custom data to deal with.
		// Let's determine this by removing the default indexes to see if there's anything left in the array
		// and set the session data while we're at it
		foreach (array('sid','ipaddress','useragent','timestamp') as $val)
		{
			unset($custom_userdata[$val]);
			$cookie_userdata[$val] = $this->userdata[$val];
		}
	
		// Did we find any custom data?  If not, we turn the empty array into a string
		// since there's no reason to serialize and store an empty array in the DB
		if (count($custom_userdata) === 0)
		{
			$custom_userdata = '';
		}
		else
		{
			// Serialize the custom data array so we can store it
			$custom_userdata = $this->_serialize($custom_userdata);
		}
	
		// Run the update query
		$this->CI->db->where('sid', $this->userdata['sid']);
		$this->CI->db->update(
				$this->sess_table_name, 
				array(
					'timestamp' => $this->userdata['timestamp'], 
					'userdata' => $custom_userdata
					)
				);
	
		// Write the cookie.  Notice that we manually pass the cookie data array to the
		// _set_cookie() function. Normally that function will store $this->userdata, but
		// in this case that array contains custom data, which we do not want in the cookie.
		$this->_set_cookie($cookie_userdata);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Create a new session
	 *
	 * @access	public
	 * @return	void
	 */
	function sess_create()
	{
		$sessid = '';
		while (strlen($sessid) < 32)
		{
			$sessid .= mt_rand(0, mt_getrandmax());
		}
	
		// To make the session ID even more secure we'll combine it with the user's IP
		$sessid .= $this->CI->input->ip_address();
	
		$this->userdata = array(
				'sid'	=> md5(uniqid($sessid, TRUE)),
				'uid'   => 0,
				'authid'=>'',
				'ipaddress'	=> $this->CI->input->ip_address(),
				'useragent'	=> substr($this->CI->input->user_agent(), 0, 120),
				'timestamp'	=> $this->now,
				
		);
	
	
		// Save the data to the DB if needed
		if ($this->sess_use_database === TRUE)
		{
			$this->CI->db->query($this->CI->db->insert_string($this->sess_table_name, $this->userdata));
		}
	
		// Write the cookie
		$this->_set_cookie();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Update an existing session
	 *
	 * @access	public
	 * @return	void
	 */
	function sess_update()
	{
		// We only update the session every five minutes by default
		if (($this->userdata['timestamp'] + $this->sess_time_to_update) >= $this->now)
		{
			return;
		}
	
		// Save the old session id so we know which record to
		// update in the database if we need it
		$old_sessid = $this->userdata['sid'];
		$new_sessid = '';
		while (strlen($new_sessid) < 32)
		{
			$new_sessid .= mt_rand(0, mt_getrandmax());
		}
	
		// To make the session ID even more secure we'll combine it with the user's IP
		$new_sessid .= $this->CI->input->ip_address();
	
		// Turn it into a hash
		$new_sessid = md5(uniqid($new_sessid, TRUE));
	
		// Update the session data in the session data array
		$this->userdata['sid'] = $new_sessid;
		$this->userdata['timestamp'] = $this->now;
	
		// _set_cookie() will handle this for us if we aren't using database sessions
		// by pushing all userdata to the cookie.
		$cookie_data = NULL;
	
		// Update the session ID and last_activity field in the DB if needed
		if ($this->sess_use_database === TRUE)
		{
			// set cookie explicitly to only have our session data
			$cookie_data = array();
			foreach (array('sid','ipaddress','useragent','timestamp') as $val)
			{
				$cookie_data[$val] = $this->userdata[$val];
			}
	
			$this->CI->db->query($this->CI->db->update_string($this->sess_table_name, array('timestamp' => $this->now, 'sid' => $new_sessid), array('sid' => $old_sessid)));
		}
	
		// Write the cookie
		$this->_set_cookie($cookie_data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Destroy the current session
	 *
	 * @access	public
	 * @return	void
	 */
	function sess_destroy()
	{
		// Kill the session DB row
		if ($this->sess_use_database === TRUE && isset($this->userdata['sid']))
		{
			$this->CI->db->where('sid', $this->userdata['sid']);
			$this->CI->db->delete($this->sess_table_name);
		}
	
		// Kill the cookie
		setcookie(
		$this->sess_cookie_name,
		addslashes(serialize(array())),
		($this->now - 31500000),
		$this->cookie_path,
		$this->cookie_domain,
		0
		);
	
		// Kill session data
		$this->userdata = array();
	}
	
	/**
	 * Garbage collection
	 *
	 * This deletes expired session rows from database
	 * if the probability percentage is met
	 *
	 * @access	public
	 * @return	void
	 */
	function _sess_gc()
	{
		if ($this->sess_use_database != TRUE)
		{
			return;
		}
	
		srand(time());
		if ((rand() % 100) < $this->gc_probability)
		{
			$expire = $this->now - $this->sess_expiration;
	
			$this->CI->db->where("timestamp < {$expire}");
			$this->CI->db->delete($this->sess_table_name);
	
			log_message('debug', 'Session garbage collection performed.');
		}
	}
}
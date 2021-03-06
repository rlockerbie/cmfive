<?php
class RestService extends DbService {
	
	function getTokenJson($username, $password, $api) {
		global $REST_API_KEY;
		
		if ($api && $api == $REST_API_KEY) {
			$user = $this->w->Auth->login($username,$password,null,true);
			if ($user) {
				$session = new RestSession($this->w);
				$session->setUser($user);
				$session->insert();
				return $this->successJson($session->token);
			} else {
				return $this->errorJson("authentication failed for ".$username.", ".$password.", ".$api);
			}
		} else {
			return $this->errorJson("wrong API key");
		}
	}
	
	/**
	 * Check whether rest access to objects of this class is allowed at all
	 * 
	 * @param unknown $classname
	 * @return boolean
	 */
	function checkClassAccessAllowed($classname) {
		if (!array_search($classname, Config::get("system.rest_include"))) {
			return $this->errorJson("restful access to {$classname} not allowed");
		}
	}
	
	/**
	 * Will check if token exists and set the REST user
	 * in the authentication service to facilitate all
	 * normal permission checks
	 * 
	 * returns JSON message if error.
	 * 
	 * @param unknown $token
	 * @return unknown
	 */
	function checkTokenJson($token) {
		if (!$token) {
			return $this->errorJson("missing token");
		}
		$session = $this->getObject("RestSession", array("token"=>$token));
		if ($session) {
			$user = $session->getUser();
			$this->w->Auth->setRestUser($user); 
		} else {
			return $this->errorJson("no session associated with this token");
		}
		return null;
	}
	
	function getJson($classname, $id, $token) {
		$error = $this->checkTokenJson($token);
		if ($error) {
			return $error;
		}
		
		$o = $this->getObject($classname, $id);
		if ($o && $o->canView($this->w->Auth->user())) {
			return $this->successJson($o->toArray());
		}
	}
		
	function listJson($classname, $where, $token) {
		$error = $this->checkTokenJson($token);
		if ($error) {
			return $error;
		}
				
		$os = $this->getObjects($classname, $where);
		if ($os) {
			foreach ($os as $o) {
				if ($o->canView($this->w->Auth->user())) {
					$ar[] = $o->toArray();
				}
			}
			return $this->successJson($ar);
		}
		
	}
	
	
	function findJson($classname, $query, $token) {
		$error = $this->checkTokenJson($token);
		if ($error) {
			return $error;
		}
				
	}
	
	
	function createJson($classname, $json, $token) {
		$error = $this->checkTokenJson($token);
		if ($error) {
			return $error;
		}
				
	}
	
	
	function updateJson($classname, $id, $json, $token) {
		$error = $this->checkTokenJson($token);
		if ($error) {
			return $error;
		}
				
		$o = $this->getObject($classname, $id);
		if ($o && $o->canEdit($this->w->Auth->user())) {
			// convert json into array and update object
			$ar = json_decode($json,true);
			$o->fill($ar);
			$o->update();
		}		
	}
	
	
	function deleteJson($classname, $id, $token) {
		$error = $this->checkTokenJson($token);
		if ($error) {
			return $error;
		}
				
		$o = $this->getObject($classname, $id);
		if ($o && $o->canDelete($this->w->Auth->user())) {
			$o->delete();
		}
	}
	
	function errorJson($message) {
		return json_encode(array("error" => $message));
	}
	
	function successJson($results) {
		return json_encode(array("success" => $results));
	}
	
}
<?php

/**
 * This class is responsible for storing and accessing 
 * the configurations for each class with case insensitive keys. 
 *
 * Config getting and setting is done using the dot syntax i.e.
 *     Config::set("admin.topmenu", true);
 * Translates to:
 *     $register["admin"]["topmenu"] = true;
 * Then the inverse function also works:
 *     Config::get("admin.topmenu"); // returns true
 * 
 * If any keys aren't found in set then they are created, also the value
 * itself can be an array, of which the values within can then be subsequently
 * retrieved with the abovementioned get function and dot syntax.
 * 
 * Note: When calling Config::get, if a key is not found NULL is returned so it 
 * is important to check that condition when fetching config keys.
 * 
 * @author Adam Buckley
 */

class Config {
    
    // Storage array
    private static $register = array();
	private static $_cache = array();
    
    /**
     * This function will set a key in an array
     * to the value given
     *
     * @param string $key
     * @param mixed $value
     * @return null
     */
    public static function set($key, $value) {
        $exploded_key = explode('.', $key);
        if (!empty($exploded_key)) {
            $register = &self::$register;
            // Loop through each key
            foreach($exploded_key as $ekey) {
                $i_ekey = strtolower($ekey);
                if (!array_key_exists($i_ekey, $register)) {
                    $register[$i_ekey] = array();
                }
                $register = &$register[$i_ekey];
            }
            $register = $value;
        }
    }
    
    /**
     * This function will attempt to return a
     * key out of the array
     *
     * @param string $key
     * @return Mixed the value
     */
    public static function get($key) {
		if(empty(self::$_cache['get_keys'])) {
			self::$_cache['get_keys'] = array();
		}
		if(!empty(self::$_cache['get_keys'][$key])) {
			return self::$_cache['get_keys'][$key];
		}
        $exploded_key = explode('.', $key);
		$register = &self::$register;
		if (!empty($exploded_key)) {
			if(array_key_exists($exploded_key[0], $register)) {
				if(!isset($exploded_key[1]) == 1) {
					self::$_cache['get_keys'][$key] = &$register[$exploded_key[0]];
					return self::$_cache['get_keys'][$key];
				}
				if(array_key_exists($exploded_key[1], $register[$exploded_key[0]])) {
					self::$_cache['get_keys'][$key] = &$register[$exploded_key[0]][$exploded_key[1]];
					return self::$_cache['get_keys'][$key];
				}
			}
		}
		return NULL;
    }
    
    /**
     * A small helper function for web to get the list of keys (modules)
     * 
     * @return array
     */
    public static function keys($getAll = false) {
        if ($getAll === true) {
            return array_keys(self::$register);
        }
		if(!empty(self::$_cache['keys'])) {
			return self::$_cache['keys'];
		}
        $required = array("topmenu", "active", "path");
        $req_count = count($required);
        $modules = array_filter(self::$register, function($var) use ($required, $req_count) {
            return ($req_count === count(array_intersect_key($var, array_flip($required))));
        });
		self::$_cache['keys'] = array_keys($modules);
        return self::$_cache['keys'];
    }
    
    /**
     * A function to append a value to an array, if target is not an array this function 
     * will overwrite the current targets value so use with caution!
     * 
     * If value to write is also an array, this function will merge the target with the value
     * 
     * @param string $key
     * @param mixed $value
     * @return null
     */
    public static function append($key, $value) {
        $target_value = self::get($key);
        
        // If target isn't set then set it
        if (empty($target_value)) {
            if (is_array($value)) {
                self::set($key, $value);
            } else {
                self::set($key, array($value));
            }
        } else {
            if (is_array($target_value)) {
                if (is_array($value)) {
                    self::set($key, array_merge($target_value, $value));
                } else {
                    $target_value[] = $value;
                    self::set($key, $target_value);
                }
            } else {
                // Overwrite target value
                if (is_array($value)) {
                    self::set($key, $value);
                } else {
                    self::set($key, array($value));
                }
            }
        }
    }
    
    // Sanity checking
    public static function dump() {
        var_dump(self::$register);
    }
}
    
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {
// --------------------------------------------------------------------
	
	/**
	 * Prepare rules
	 *
	 * Re-orders the provided rules in order of importance, so that
	 * they can easily be executed later without weird checks ...
	 *
	 * "Callbacks" are given the highest priority (always called),
	 * followed by 'required' (called if callbacks didn't fail),
	 * and then every next rule depends on the previous one passing.
	 *
	 * @param	array	$rules
	 * @return	array
	 */
	protected function _prepare_rules($rules)
	{
		return $rules;
		/*$new_rules = array();
		$callbacks = array();

		foreach ($rules as &$rule)
		{
			// Let 'required' always be the first (non-callback) rule
			if ($rule === 'required')
			{
				array_unshift($new_rules, 'required');
			}
			// 'isset' is a kind of a weird alias for 'required' ...
			elseif ($rule === 'isset' && (empty($new_rules) OR $new_rules[0] !== 'required'))
			{
				array_unshift($new_rules, 'isset');
			}
			// The old/classic 'callback_'-prefixed rules
			elseif (is_string($rule) && strncmp('callback_', $rule, 9) === 0)
			{
				$callbacks[] = $rule;
			}
			// Proper callables
			elseif (is_callable($rule))
			{
				$callbacks[] = $rule;
			}
			// "Named" callables; i.e. array('name' => $callable)
			elseif (is_array($rule) && isset($rule[0], $rule[1]) && is_callable($rule[1]))
			{
				$callbacks[] = $rule;
			}
			// Everything else goes at the end of the queue
			else
			{
				$new_rules[] = $rule;
			}
		}
		print_r($rules);
		print_r(array_merge($new_rules, $callbacks));die;
		print_r($new_rules);
		print_r($callbacks);die;
		return array_merge($new_rules, $callbacks);*/
	}
}
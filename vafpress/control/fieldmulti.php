<?php

/**
 * The smallest unit of an item, the field it self.
 */
abstract class VP_Control_FieldMulti extends VP_Control_Field
{

	protected $_items = array();

	protected $_bind;

	/**
	 * Basic self setup of the object
	 * @param  SimpleXMLElement $simpleXML SimpleXML object representation of the field
	 * @return VP_Control_FieldMulti Field object
	 */
	protected function _basic_make($arr)
	{
		parent::_basic_make($arr);

		if (!empty($arr['items']))
		{
			if(isset($arr['items']['data']))
			{
				foreach ($arr['items']['data'] as $data)
				{
					if($data['source'] == 'function')
					{
						$function = $data['value'];
						$params   = explode(',', !empty($data['params']) ? $data['params'] : '');

						if(function_exists($function))
						{
							$items = call_user_func_array($function, $params);
							$arr['items'] = array_merge($arr['items'], $items);
						}
					}
					else if($data['source'] == 'bind')
					{
						$function = $data['value'];
						$field    = $data['field'];
						$this->set_bind($function . '|' . $field);
					}
				}
				unset($arr['items']['data']);
			}
			foreach ($arr['items'] as $item)
			{
				$the_item = new VP_Control_Field_Item_Generic();
				$the_item->value($item['value'])
					 	 ->label($item['label']);
				$this->add_item($the_item);
			}
		}
		if (!empty($arr['default']))
		{
			$this->_process_default($arr['default'], $arr['items']);
		}
		return $this;
	}

	protected function _process_default($arr_default, $arr_items)
	{
		$defaults = array();
		foreach ($arr_default as $def)
		{
			switch ($def)
			{
				case '{{all}}':
					$defaults = array_merge($defaults, VP_Util_Array::deep_values($arr_items, 'value'));
					break;
				case '{{first}}':
					$first = VP_Util_Array::first($arr_items);
					$defaults[] = $first['value'];
					break;
				case '{{last}}':
					$last = end($arr_items);
					$defaults[] = $last['value'];
					break;
				default:
					$defaults[] = $def;
					break;
			}
		}
		$defaults = array_unique($defaults);
		$this->set_default($defaults);
	}

	protected function _setup_data()
	{
		parent::_setup_data();
		$this->add_single_data('head_info', 'bind', $this->get_bind());
		$this->add_data('items', $this->get_items());
	}

	public function add_items($items)
	{
		$this->_items = array_merge($this->_items, $items);
	}

	/**
	 * Add single item
	 * @param VP_Control_Field_Item_ $opt Single item item
	 */
	public function add_item($opt)
	{
		$this->_items[] = $opt;
	}

	/**
	 * Getter for $_items
	 *
	 * @return Array array of items {value, label}
	 */
	public function get_items() {
		return $this->_items;
	}
	
	/**
	 * Setter for $_items
	 *
	 * @param Array $_items array of items
	 */
	public function set_items($_items) {
		$this->_items = $_items;
		return $this;
	}

	public function set_items_from_array($_items) {
		if(is_array($_items))
		{
			foreach ($_items as $item)
			{
				$the_item = new VP_Control_Field_Item_Generic();
				$the_item->value($item['value'])
					 	 ->label($item['label']);
				$this->add_item($the_item);
			}
		}
	}

	/**
	 * Get $_bind
	 *
	 * @return String bind rule string
	 */
	public function get_bind() {
	    return $this->_bind;
	}
	
	/**
	 * Set $_bind
	 *
	 * @param String $_bind bind rule string
	 */
	public function set_bind($_bind) {
	    $this->_bind = $_bind;
	    return $this;
	}

}

/**
 * EOF
 */
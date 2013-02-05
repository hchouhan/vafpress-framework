<?php

/**
 * The smallest unit of an option, the field it self.
 */
abstract class VP_Control_Field implements iFactory
{

	/**
	 * Unique name of the field
	 * @var String
	 */
	protected $_name;

	/**
	 * Label for the field
	 * @var String
	 */
	protected $_label;

	/**
	 * Description on what the field about
	 * @var String
	 */
	protected $_description;

	/**
	 * Validation pattern string
	 * @var String
	 */
	protected $_validation;

	/**
	 * Default value for the field
	 * @var String|Array
	 */
	protected $_default;

	/**
	 * Maximum height of the field
	 * @var Integer
	 */
	protected $_field_max_height;

	/**
	 * Value for the field
	 * @var String|Array
	 */
	protected $_value;

	/**
	 * Data to be rendered
	 * @var Array
	 */
	protected $_data;

	/**
	 * Extra Classes for the container
	 * @var String
	 */
	protected $_container_extra_classes;

	/**
	 * Class Constructor
	 */
	public function __construct()
	{
		$this->_data = array();
	}

	abstract public function render();

	/**
	 * Setup and return needed attribute as array
	 * @return Array Data array
	 */
	protected function _setup_data()
	{
		// Set Basic Data
		$this->add_data('name', $this->get_name());
		$this->add_data('default', $this->get_default());
		$this->add_data('value', $this->get_value());

		// Determine Type
		$type = 'vp-' . strtolower(substr(get_class($this), strrpos(get_class($this), '_') + 1));

		// Set Control Head Data
		$this->add_data('head_info', array(
			'name'                    => $this->get_name(),
			'type'                    => $type,
			'container_extra_classes' => $this->get_container_extra_classes(),
			'validation'              => $this->get_validation(),
			'label'                   => $this->get_label(),
			'description'             => VP_Util_Text::parse_md($this->get_description())
		));
	}

	/**
	 * Basic self setup of the object
	 * @param  Array $arr Array representation of the field
	 * @return VP_Control_Field Field object
	 */
	protected function _basic_make($arr)
	{
		$this->set_name(isset($arr['name']) ? $arr['name'] : '')
			 ->set_label(isset($arr['label']) ? $arr['label'] : '')
			 ->set_default(isset($arr['default']) ? $arr['default'] : '')
			 ->set_description(isset($arr['description']) ? $arr['description'] : '')
			 ->set_validation(isset($arr['validation']) ? $arr['validation'] : '');
		return $this;
	}

	/**
	 * Add value to render data array
	 * @param Mixed $item Value to be added to render data arary
	 */
	public function add_data($key, $value)
	{
		$this->_data[$key] = $value;
	}

	/**
	 * Get render data
	 *
	 * @return Array Render data array
	 */
	public function get_data() {
	    return $this->_data;
	}
	
	/**
	 * Set render data
	 *
	 * @param Array $_data Render data array
	 */
	public function set_data($_data) {
	    $this->_data = $_data;
	    return $this;
	}

	/**
	 * Set single render data
	 *
	 * @param Array $_data Render data array
	 */
	public function set_single_data($key, $_data) {
	    $this->_data[$key] = $_data;
	    return $this;
	}

	/**
	 * Get single render data
	 *
	 * @param Array $_data Render data array
	 */
	public function get_single_data($key) {
	   	return $this->_data[$key];
	}

	/**
	 * Add value to render data array
	 * @param Mixed $item Value to be added to render data arary
	 */
	public function add_single_data($p_key, $key, $value)
	{
		$this->_data[$p_key][$key] = $value;
	}

	/**
	 * Getter for $_name
	 *
	 * @return String unique name of the field
	 */
	public function get_name() {
		return $this->_name;
	}
	
	/**
	 * Setter for $_name
	 *
	 * @param String $_name unique name of the field
	 */
	public function set_name($_name) {
		$this->_name = $_name;
		return $this;
	}

	/**
	 * Getter for $_label
	 *
	 * @return String label of the field
	 */
	public function get_label() {
		return $this->_label;
	}
	
	/**
	 * Setter for $_label
	 *
	 * @param String $_label label of the field
	 */
	public function set_label($_label) {
		$this->_label = $_label;
		return $this;
	}

	/**
	 * Getter for $_description
	 *
	 * @return String description of the field
	 */
	public function get_description() {
		return $this->_description;
	}
	
	/**
	 * Setter for $_description
	 *
	 * @param String $_description description of the field
	 */
	public function set_description($_description) {
		$this->_description = $_description;
		return $this;
	}

	/**
	 * Getter for $_validation
	 *
	 * @return String validation pattern in string
	 */
	public function get_validation() {
		return $this->_validation;
	}
	
	/**
	 * Setter for $_validation
	 *
	 * @param String $_validation validation pattern in string
	 */
	public function set_validation($_validation) {
		$this->_validation = $_validation;
		return $this;
	}

	/**
	 * Getter for $_default
	 *
	 * @return mixed default value of the field
	 */
	public function get_default() {
		return $this->_default;
	}
	
	/**
	 * Setter for $_default
	 *
	 * @param mixed $_default default value of the field
	 */
	public function set_default($_default) {
		$this->_default = $_default;
		return $this;
	}

	/**
	 * Get field value
	 *
	 * @return String|Array Value of field
	 */
	public function get_value() {
	    return $this->_value;
	}
	
	/**
	 * Set field value
	 *
	 * @param String|Array $_value Value of field
	 */
	public function set_value($_value) {
	    $this->_value = $_value;
	    return $this;
	}

	/**
	 * Getter of $_field_max_height
	 *
	 * @return Integer Max height of the field
	 */
	public function get_field_max_height() {
		return $this->_field_max_height;
	}
	
	/**
	 * Setter of $_field_max_height
	 *
	 * @param Integer $_field_max_height Max height of the field
	 */
	public function set_field_max_height($_field_max_height) {
		$this->_field_max_height = $_field_max_height;
		return $this;
	}

	/**
	 * Getter of $_container_extra_classes
	 *
	 * @return String Extra Classes for the container
	 */
	public function get_container_extra_classes() {
		return $this->_container_extra_classes;
	}
	
	/**
	 * Setter of $_container_extra_classes
	 *
	 * @param Integer $_container_extra_classes Extra Classes for the container
	 */
	public function set_container_extra_classes($_container_extra_classes) {
		$this->_container_extra_classes = $_container_extra_classes;
		return $this;
	}

}

/**
 * Interface to force implementation of the 'factory' pattern method for each field class
 * to enable easier instantiation of each field class.
 */
interface iFactory
{
	static function withArray($arr);
}

/**
 * EOF
 */
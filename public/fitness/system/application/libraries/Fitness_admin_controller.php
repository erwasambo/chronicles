<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 *
 * @package         Codeingiter shopping cart v1.1
 * @author          Shin Okada
 * @copyright       Copyright (c) 2010
 * @license         http://www.gnu.org/licenses/lgpl.html
 * @link            http://www.okadadesign.no/blog
 * 
 */

// ---------------------------------------------------------------------------

/**
 * Fitness_admin_controller
 *
 * Extends the Admin_controller class so I can declare special Shop_admin controllers
 *
 * @package      
 * @subpackage     Controllers
 */

class Fitness_Admin_Controller extends Admin_Controller
{
	function Fitness_Admin_Controller()
	{
		parent::Admin_Controller();

		// Loading libraries instead of autoload
		$this->load->library('form_validation');
		$this->load->library('validation'); // for BEP 0.6
		
		// Loading helpers 
		$this->load->helper('form');
		$this->load->helper('security');
		$this->load->helper('mytools' );

		
		// Load the FITNESSADMIN asset group
		$this->bep_assets->load_asset_group('FITNESSADMIN');
		
		
	}
}

/* End of Shop_controller.php */
/* Location: ./system/application/libraries/Shop_controller.php */

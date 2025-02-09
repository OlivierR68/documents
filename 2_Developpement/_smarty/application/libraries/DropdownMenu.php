<?php defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * Class DropdownMenu
 * Librairie Perso permettant l'affichage du Menu déroulant dans tout le site grâce à l'autoload
 * @author Olivier Ravinasaga
 */
class DropdownMenu
{

    function __construct()
    {

        $ci = get_instance();

        $ci->load->model('Category_class');
        $ci->load->model('Categories_manager');

        $data_manager = new Categories_manager();
        $cat_data_list = $data_manager->findAllCat(true);
        $dropdown_menu = array();

        foreach ($cat_data_list as $cat_data) {
            $cat_obj = new Category_class();
            $cat_obj->hydrate($cat_data);

            $dropdown_menu[] = $cat_obj;

        }

        $ci->smarty->assign('dropdown_menu', $dropdown_menu);


    }


}
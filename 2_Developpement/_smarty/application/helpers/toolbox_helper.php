<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Collection de fonction plus ou moins pratique
 * @author Olivier Ravinasaga
 * @version  version 1
 *
 */


/**
 * Fonction permettant qui renvoi 'bn_active' quand la condition est validée, est utilisée dans les navs
 * @param $controller string  chaine de charactère a valider
 * @param $return string chaine de charactère retoruner si validée
 * @param $settings int 1 determine le controller de la page, 2 la méthode de la page
 * @return string chaine de charactère $return
 */

function active_page($controller, $return = 'active', $settings = 0)
{
    $ci = get_instance();
    switch ($settings) {

        case 1:
            $uri = $ci->uri->rsegments['1'];
            break;
        case 2:
            $uri = $ci->uri->rsegments['2'];
            break;
        default:
            $uri = $ci->uri->rsegments['1'] . "/" . $ci->uri->rsegments['2'];
    }

    if ($uri == $controller) return $return;


}


/**
 * Fonction qui retourne de le nom de la méthode de la page actuelle
 * @return string le nom de la méthode
 */
function page_name()
{
    $ci = get_instance();
    return $ci->uri->rsegments['2'];

}

/**
 * Fonction qui retourne de le nom du controller de la page actuelle
 * @return string le nom du Controller de la page
 */
function ctrl_name()
{
    $ci = get_instance();
    return $ci->uri->rsegments['1'];

}

/**
 * Fonction permettant de récupérer les données de session temporaire
 * @param string $name nom de la donnée de session
 * @return mixed retourne la donnée de session
 */

function flash_data($name)
{
    $ci = get_instance();
    return $ci->session->flashdata($name);
}

/**
 * Fonction permettant l'affichage du controller actuelle, avec son nom "humain"
 * @return string
 */

function ctrl_slug()
{
    $ctrl = ctrl_name();

    switch ($ctrl) {
        case "dashboard"    :
            $slug = "Tableau de bord";
            break;
        case "events"       :
            $slug = "Événements";
            break;
        case "images"       :
            $slug = "Galerie d'image";
            break;
        case "pages"        :
            $slug = "Pages";
            break;
        case "prestations"  :
            $slug = "Prestations";
            break;
        case "slides"       :
            $slug = "Slider page d'accueil";
            break;
        case "users"        :
            $slug = "Utilisateurs";
            break;
        case "newsletter"   :
            $slug = "Newsletter";
            break;
    }

    return $slug;
}

/**
 * Fonction permettant la redirrection  vers la page de connection si l'utilisateur cherche a acceder au backoffice sans être connecter.
 */
function please_reconnect()
{
    $ci = get_instance();

    if (isset($ci->session->login) && $ci->session->login < 2) {

        redirect('users/login', 'refresh');

    }
}

/**
 * La fonction de Morand !
 * HEURE D'OUVERTURE ET FEMETURE
 */
function the_morand_function()
{
    function isWebsiteOpen()
    {
        date_default_timezone_set('Europe/Paris'); //evite le decalage horraire

        //date ('Gi') --> heure --> ex : 900 = 9h00min
        //date('N') --> jour --> ex : 6 = samedi

        // de 9h00 à 18h00
        if (date('Gi') >= 900 && date('Gi') < 1800 || date('N') > 6 && date('Gi') >= 000 && date('Gi') < 001) {
            return true;
        } else {
            return false;
        }

    }

    if (isWebsiteOpen() === true) {
        return "<span class='text-success'>Ouvert</span>";
    } else {
        return "<span class='text-danger'>Fermé</span>";
    }



}





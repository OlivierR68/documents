<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Users
 * @author  Steven Robert
 * @author  Olivier Ravinasaga
 * @version 1
 *
 */

class Images extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Images_manager");
        $this->load->model("Images_class");
        $this->load->library('upload');
    }

    /** Front : Fonction permettant d'afficher la galerie photos  */
    public function index()
    {
        $data['preTITLE'] = "Consultez notre";
        $data['TITLE'] = "Galerie Photos";
        $data['headerImg'] = base_url("assets/img/img-gallerie.jpg");

        $images = $this->Images_manager->findAll(true);
        $imagesToDisplay = array();
        foreach ($images as $image) {
            $objImage = new Images_class();
            $objImage->hydrate($image);
            $imagesToDisplay[] = $objImage;
        }

        if (!empty($this->input->post())) {


            $obj_image = new Images_class();
            $obj_image->hydrate($this->input->post());

            if ($_FILES['img']['size'] > 0) {

                $config['upload_path'] = './uploads/album/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size'] = 2048;

                $this->upload->initialize($config);
                if (!$this->upload->do_upload('img')) {
                    $data['ERROR'] = $this->upload->display_errors();

                } else {

                    $upload_data = $this->upload->data();
                    $obj_image->setSrc($upload_data['file_name']);
                    $obj_image->setAuthor($this->session->id);

                }

            }


                $insertId = $this->Images_manager->new($obj_image);
                $this->session->set_flashdata("success", "Votre image a bien été envoyé,<br> elle sera mis en ligne après modération.");

                redirect('images/', 'refresh');

        }

        $data['arrImages'] = $imagesToDisplay;

        $data['CONTENT'] = $this->smarty->fetch('front/images.tpl', $data);
        $this->smarty->display('front/templates/content.tpl', $data);

    }

    /** Back : Fonction permettant d'afficher la liste des images  */
    public function ListPage()
    {
        $data['TITLE'] = "Liste des images";
        $images = $this->Images_manager->findAll();
        $imagesToDisplay = array();
        foreach ($images as $image) {
            $objImage = new Images_class();
            $objImage->hydrate($image);
            $imagesToDisplay[] = $objImage;
        }

        $data['arrImages'] = $imagesToDisplay;

        $data['CONTENT'] = $this->smarty->fetch('back/imagesList.tpl', $data);
        $this->smarty->display('back/templates/content.tpl', $data);

    }

    /** Fonction permettant de créer ou de modifier une image
     * @param int $id identifiant bdd de l'image
     */

    public function addEdit($id = -1)
    {

        /*
            var $id par défault à -1 les id étant toujours positifs,
            c'est comme cela que l'on vérifie si on est sur page de création ou modification
            -1 = page de création | 1+ = page de modification
        */

        // Création d'un objet image qu'on utilisera tout au long de la fonction
        $objImage = new Images_class();

        // On vérifie si la page a un id, on l'hydrate en récupérant les infos dans la bdd
        if ($id >= 0) {

            $objImage->hydrate($this->Images_manager->findOne($id));
        }

        // on vérifie si il y des choses qui ont été envoyés par le formulaire ($_POST)
        if (!empty($this->input->post())) {

            // on hydrate avec ce qu'il y dans $_POST
            $objImage->hydrate($this->input->post());

            // on vérifie si une image a été envoyée
            if ($_FILES['img']['size'] > 0) {

                //  on configure l'upload de l'image
                $config['upload_path'] = './uploads/album/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size'] = 2048;

                // l'upload de l'image est lancé  ici
                $this->upload->initialize($config);

                // si il y a un problème sur l'image on envoi une erreur
                if (!$this->upload->do_upload('img')) {
                    $data['ERROR'] = $this->upload->display_errors();

                } else {

                    // si tout c'est bien passé on indique le nom de l'image dans l'objet
                    $upload_data = $this->upload->data();
                    $objImage->setSrc($upload_data['file_name']);
                    $objImage->setAuthor($this->session->id);

                }

            }

            if ($_FILES['img']['size'] <= 0 && $id < 0) {
                /*
                si on dans la page de création et qu'il n'y pas d'image uploadé on assigne une image par défault,
                attention ce n'est pas valable partout, pour la galerie par exemple il faudra refuser la création si il n'y pas d'image
                */
                $objImage->setId('album/photos-1.jpg');

            }


            // crée ou on modifie une image selon si on est dans la page de création ou modification
            if ($id < 0) {
                $insertId = $this->Images_manager->new($objImage); // on crée et récupère l'id sur l'image
                $this->session->set_flashdata("success", "L'image' <b>{$objImage->getId()}</b> a été ajouté"); // on crée et envoi un message de succes sur la prochaine page

                redirect('images/AddEdit/' . $insertId, 'refresh'); // redirection sur la page modification

            } else {

                $insertId = $this->Images_manager->update($objImage);
                $data['SUCCESS'] = "L'image' <b>{$objImage->getId()}</b> a été modifié";
            }
        }

        $data['objImage'] = $objImage;

        if ($id > 0) { // modification de l'affichage selon on se trouve

            $data['TITLE'] = "Modifier l'image :" . $objImage->getLibelle();
            $data['buttonSubmit'] = "Modifier";
            $data['buttonCancel'] = "Revenir à la liste";

        } else {

            $data['TITLE'] = "Ajouter une nouvelle image";
            $data['buttonSubmit'] = "Ajouter l'image";
            $data['buttonCancel'] = "Annuler";

        }

        $data['CONTENT'] = $this->smarty->fetch('back/imagesAdd.tpl', $data);
        $this->smarty->display('back/templates/content.tpl', $data);

    }

    /** Fonction permettant de supprimer une image et de rediriger sur la page de la liste
     * @param int $id identifiant bdd de l'image
     */
    public function delete($id)
    {
        $obj_img = new Images_class();
        $obj_img->hydrate($this->Images_manager->findOne($id));

        $previous_img = "./uploads/album/".$obj_img->getSrc();
        if (file_exists($previous_img)) unlink($previous_img);

        $this->Images_manager->delete($id);
        $this->session->set_flashdata('error', "L'image #$id a été supprimé");
        redirect($this->agent->referrer(), 'refresh');

    }

    /** Fonction permettant de copier une image et de rediriger sur la page de la liste
     * @param int $id identifiant bdd de l'image
     */
    public function copy($id)
    {

        $this->Images_manager->copy($id);
        $this->session->set_flashdata('success', "L'image #$id a été copié");
        redirect('images/ListPage', 'refresh');

    }


    public function accept($id)
    {

        $this->Images_manager->accept($id);
        $this->session->set_flashdata('success', "L'image #$id est maintenant visible au public");
        redirect('dashboard', 'refresh');

    }


    /** Fonction permettant l'affichage de la page Ajout/Modification des événements
     * @param int $id identifiant bdd de l'image
     */
    public function user_addEdit($id = -1)
    {

        $objImage = new Images_class();

        if ($id >= 0) {

            $objImage->hydrate($this->Images_manager->findOne($id));
        }

        if (!empty($this->input->post())) {

            $objImage->hydrate($this->input->post());

            if ($_FILES['img']['size'] > 0) {


                $config['upload_path'] = './uploads/album/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size'] = 2048;


                $this->upload->initialize($config);


                if (!$this->upload->do_upload('img')) {
                    $data['ERROR'] = $this->upload->display_errors();

                } else {


                    $upload_data = $this->upload->data();
                    $objImage->setSrc($upload_data['file_name']);

                }

            }


            if ($id < 0) {
                $insertId = $this->Images_manager->new($objImage);
                $this->session->set_flashdata("success", "L'image' <b>{$objImage->getId()}</b> a été ajouté");

                redirect('images/AddEdit/' . $insertId, 'refresh');

            }

            $data['objImage'] = $objImage;

            if ($id > 0) {

                $data['TITLE'] = "Ajouter une nouvelle image";
                $data['buttonSubmit'] = "Ajouter l'image";
                $data['buttonCancel'] = "Annuler";

            }

            $data['CONTENT'] = $this->smarty->fetch('front/images.tpl', $data);
            $this->smarty->display('front/templates/content.tpl', $data);

        }
    }
}
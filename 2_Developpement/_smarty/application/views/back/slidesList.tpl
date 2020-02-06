<a class="btn btn-primary mb-3" href="{site_url('slides/addEdit')}" role="button">Ajouter un slide</a>

<div class="table-responsive">
    <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th>id</th>
            <th>Actions</th>
            <th>Libelle</th>
            <th>Image</th>
            <th>Taille</th>
            <th>Titre</th>
            <th>Sous-titre</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>id</th>
            <th>Actions</th>
            <th>Libelle</th>
            <th>Image</th>
            <th>Taille</th>
            <th>Titre</th>
            <th>Sous-titre</th>
        </tr>
        </tfoot>
        <tbody>
        {foreach from=$arrSlides item=$objSlide}
            <tr>
                <td>{$objSlide->getId()}</td>
                <td class="bn_action nowrap">

                    {* à implémenter si j'ai le temps...

                    <?php if($objSlide->getPosition() == 1) { ?>
                        <i class="fas fa-arrow-up text-muted"></i> |
                    <?php } else { ?>
                        <a href="#" title="+ Position"><i class="fas fa-arrow-up"></i></a> |
                    <?php } ?>

                    <?php if($objSlide->getPosition() == count($arrSlides)) { ?>
                        <i class="fas fa-arrow-down text-muted"></i> |slidesList.tpl
                    <?php } else { ?>
                        <a href="#" title="- Position"><i class="fas fa-arrow-down"></i></a> |
                    <?php } ?>

                    *}
                    <a href="{base_url('slides/copy/')}{$objSlide->getId()}" title="Copier"><i class="far fa-copy"></i></a>
                    {if $objSlide->getDefault() eq true}
                        <i title="slide" class="fas fa-edit text-muted"></i>
                        <i title="slide" class="fas fa-trash-alt text-muted"></i>
                    {else}
                        <a href="{base_url('slides/addEdit/')}{$objSlide->getId()}" title="Modifier"><i
                                    class="far fa-edit"></i></a>
                        <a href="{base_url('slides/delete/')}{$objSlide->getId()}"
                           data-href="{base_url('slides/delete/')}{$objSlide->getId()}"
                           data-toggle="modal" data-target="#confirm-delete"title="Supprimer"><i
                                    class="fas fa-trash-alt text-danger"></i></a>
                    {/if}
                </td>

                <td>{$objSlide->getLibelle()}</td>
                {if $objSlide->getDefault() eq true}
                    <td><a target="_blank"
                           href="{base_url('uploads/slider')}{$objSlide->getImg()}">{$objSlide->getImg()}</a></td>
                {else}
                    <td><a target="_blank"
                           href="{base_url('uploads/slides')}{$objSlide->getImg()}">{$objSlide->getImg()}</a></td>
                {/if}
                <td>{$objSlide->getTaille()}</td>
                <td>{$objSlide->getShortTitle(60)}</td>
                <td>{$objSlide->getText()}</td>
            </tr>
        {/foreach}
        </tbody>
    </table>
</div>


<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirmer la suppression
            </div>
            <div class="modal-body">
                Vous voulez vraiment supprimer le slide <b class="bn_user"></b>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>
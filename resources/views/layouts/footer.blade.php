@if(!isset($_COOKIE['valid_cookie']))
    <div id="cookies">
        <span>En poursuivant votre navigation sur ce site, vous acceptez l'utilisation de cookies afin d'améliorer son fonctionnement.</span> 
        <button class="btn btn-warning" id="valid_cookie"> J'accepte </button>
    </div>
@endif

<div class="col-6">
</div>
<div class="col-6 text-center">
    @auth
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#supportModal">
            Support utilisateur
        </button>
    @endauth
</div>

@auth
    <div class="modal fade" id="supportModal" tabindex="-1" role="dialog" aria-labelledby="supportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="support_user" action="" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="supportModalLabel">Support utilisateur</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="mt-2 alert alert-success d-none" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            Message correctement envoyé.
                        </p>
                        <p class="mt-2 alert alert-danger d-none" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            Echec de l'envoi du message
                        </p>
                        <p>Bonjour {{ Auth::user()->pseudo }},</p>
                        <p>Une question ? Une remarque ? Donnez-nous notre avis et nous vous répondrons dans les meilleurs délais !</p>
                        <textarea class="w-100 small" name="opinion" required="required"
                            placeholder="Un suivi sera établi afin de vous fournir des renseignements les plus pertinents possible."></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Envoyer le message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endauth
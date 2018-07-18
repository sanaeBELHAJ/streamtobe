<div class="modal fade" id="supportModal" tabindex="-1" role="dialog" aria-labelledby="supportModalLabel" aria-hidden="true" style="color: black;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="support_user" action="" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="supportModalLabel">Assistance utilisateur</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-left">
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
                    <p>Bonjour @auth {{ Auth::user()->pseudo }} @endauth</p>
                    <p>Une question ? Une remarque ?</p>
                    <p>Donnez-nous notre avis et nous vous répondrons dans les meilleurs délais !</p>
                    @guest
                        <label>
                            <p>Merci de nous indiquer votre adresse email : 
                                <input class="form-control border" type="email" name="exped" required="required"></p>
                        </label>
                    @endguest
                    <textarea class="w-100 small form-control border" name="opinion" required="required"
                                placeholder="Un suivi sera établi afin de vous fournir les renseignements les plus pertinents possible."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Envoyer le message</button>
                </div>
            </form>
        </div>
    </div>
</div>
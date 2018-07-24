<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" 
        aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog col-12 col-md-6" role="document">
        <div class="modal-content">
            <div class="form-group">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center" id="reportModalLabel">Encouragez votre streamer favori en lui faisant un don !</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <span id="gift_banner" style="background-image:url(<?php echo asset('storage/content/gift.jpg'); ?>)"></span>
                <div class="modal-body">
                    <p>Faire un don de 
                        <input id="giveaway_change" type="number" min="1" max="10000" value="1" placeholder="Montant du don" required> €
                            pour {{ $streamer->pseudo }}.
                    </p>
                    <textarea id="giveaway_message" class="w-100 mb-4" placeholder="Message personnalisé à destination du streamer."></textarea>
                    <p>Vous pouvez lui proposer de chanter un morceau souhaité :</p>
                    <textarea id="giveaway_song" class="w-100 mb-4" placeholder="Veuillez indiquer le titre de la chanson (l'utilisateur est libre d'interprêter ou non le morceau)."></textarea>
                    <div class="text-center" id="paypal-button" for="submit1"></div>
                </div>
            </div>
        </div>
    </div>
</div>
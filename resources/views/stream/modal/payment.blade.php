<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" 
        aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="form-group">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportModalLabel">Effectuer une transaction</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Faire un don de <input id="giveaway_change" type="number" min="0" max="10000" value="1" placeholder="Montant du don"> €</p>
                    <p>De la part de : <input id="pseudo" type="text" value="{{ Auth::user()->pseudo }}"></p>
                    <textarea id="giveaway_message" class="w-100 mb-4" placeholder="Message personnalisé à destination du streamer"></textarea>
                    <div id="paypal-button"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
</div>
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
                    <p>Express checkout</p>
                    Pay $20 via:
                    <a href="{{ route('paypal.express-checkout', ['stream' => $streamer->pseudo]) }}" class='btn-info btn'>PayPal</a>
                    {{-- <p>Recurring payments</p>
                    Pay $20/month:
                    <a href="{{ route('paypal.express-checkout', ['stream' => $streamer->pseudo, 'recurring' => true]) }}" class='btn-info btn'>PayPal</a> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
</div>
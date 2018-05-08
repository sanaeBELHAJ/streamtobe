<h3 class="text-center">Historique de mes activités</h3>

<div class="accordion" id="accordion">
    {{-- Chaines suivies --}}
    <div class="card">
        <button class="btn" type="button" data-toggle="collapse" data-target="#collapseOne" 
                aria-expanded="true" aria-controls="collapseOne">
            <div class="card-header" id="headingOne">
                <h5 class="mb-0">Les chaînes suivies</h5>
            </div>
        </button>

        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Chaîne</th>
                            <th>Ancienneté</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($channels) > 0)
                            @foreach($channels as $channel)
                                @if($channel->is_follower == 1)
                                    <tr>
                                        <td>
                                            <img class="mh-25" src="<?php echo asset('storage/'.$channel->stream->user->avatar); ?>" 
                                                alt="" title="Image de profil">
                                        </td>
                                        <td>{{$channel->stream->user->pseudo}}</td>
                                        <td>{{ Carbon\Carbon::parse($channel->created_at)->format('d/m/Y') }}</td>
                                        <td>
                                            @if($channel->stream->status==1)
                                                {!! link_to_route('stream.show', 'En ligne', [$channel->stream->user->pseudo], ['class' => 'btn btn-success btn-block']) !!}
                                            @else
                                                {!! link_to_route('stream.show', 'Hors ligne', [$channel->stream->user->pseudo], ['class' => 'btn btn-secondary btn-block']) !!}
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-center">
                                    <i>Vous n'avez consulté aucune chaine de stream pour l'instant.</i>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Abonnements --}}
    <div class="card">
        <button class="btn" type="button" data-toggle="collapse" data-target="#collapsene" 
                aria-expanded="true" aria-controls="collapsene">
            <div class="card-header" id="headingne">
                <h5 class="mb-0">Mes abonnements</h5>
            </div>
        </button>

        <div id="collapsene" class="collapse" aria-labelledby="headingne" data-parent="#accordion">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Chaîne</th>
                            <th>Montant</th>
                            <th>Ancienneté</th>
                            <th>Renouvelable</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($subscriptions) > 0)
                            @foreach($subscriptions as $sub)
                                <tr>
                                    <td>{{$sub->viewer->stream->user->pseudo}}</td>
                                    <td>{{$sub->amount}} €</td>
                                    <td>{{ Carbon\Carbon::parse($sub->created_at)->format('d/m/Y') }}</td>
                                    <td>@if($sub->renewable==1) Oui @else Non @endif</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-center">
                                    <i>Vous ne vous êtes abonnés à aucun stream à ce jour.</i>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Dons --}}
    <div class="card">
        <button class="btn" type="button" data-toggle="collapse" data-target="#collapse1ne" 
                aria-expanded="true" aria-controls="collapse1ne">
            <div class="card-header" id="heading1ne">
                <h5 class="mb-0">Mes dons</h5>
            </div>
        </button>

        <div id="collapse1ne" class="collapse" aria-labelledby="heading1ne" data-parent="#accordion">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Chaîne</th>
                            <th>Montant</th>
                            <th>Date de l'envoi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($subscribers) > 0)
                            {{-- @foreach($subscribers as $sub)
                                <tr>
                                    <td>{{$sub->viewer->user->pseudo}}</td>
                                    <td>{{$sub->amount}} €</td>
                                    <td>{{ Carbon\Carbon::parse($sub->created_at)->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach --}}
                        @else
                            <tr>
                                <td colspan="3" class="text-center">
                                    <i>Vous n'avez effectué aucun don.</i>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
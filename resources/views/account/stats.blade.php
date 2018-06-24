{{-- Followers --}}
<table class="table mt-5">
    <thead>
        <tr>
            <th colspan="3" class="text-center">Utilisateurs qui me suivent</th>
        <tr>
            <th>Image</th>
            <th>Pseudo</th>
            <th>Ancienneté</th>
        </tr>
    </thead>
    <tbody>
        @foreach($viewers as $viewer)
            <tr>
                <td><img class='avatar_follower' src="<?php echo asset('storage/'.$viewer->user->avatar); ?>"></td>
                <td>{{$viewer->user->pseudo}}</td>
                <td>
                    {{ Carbon\Carbon::parse($viewer->created_at)->format('d/m/Y') }}
                    <span class="anciennete" data-date="{{$viewer->created_at}}"></span>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{-- Dons --}}
<table class="table mt-5">
    <thead>
        <tr>
            <th class="text-center" colspan="4">Dons reçus</th>
        </tr>
        <tr>
            <th>Utilisateur</th>
            <th>Montant</th>
            <th>Message</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @if(count($donations) > 0)
            @foreach($donations as $donation)
                <tr>
                    <td>{{$donation->viewer->stream->user->pseudo}}</td>
                    <td>{{$donation->amount}} €</td>
                    <td>{{$donation->message}}</td>
                    <td>{{ Carbon\Carbon::parse($donation->created_at)->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="4" class="text-center">
                    <i>Vous n'avez reçu aucun don pour l'instant.</i>
                </td>
            </tr>
        @endif
    </tbody>
</table>

{{-- Streams suivis --}}
<table class="table mt-5">
    <thead>
        <tr>
            <th colspan="4" class="text-center">Mes chaines suivies</th>
        </tr>
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
                            <img class="avatar_follower" src="<?php echo asset('storage/'.$channel->stream->user->avatar); ?>" 
                                alt="" title="Image de profil">
                        </td>
                        <td>{{$channel->stream->user->pseudo}}</td>
                        <td>{{ Carbon\Carbon::parse($channel->created_at)->format('d/m/Y') }}</td>
                        <td>
                            @if($channel->stream->status==1)
                                {!! link_to_route('stream.show',
                                                    'En ligne', 
                                                    [$channel->stream->user->pseudo], 
                                                    ['class' => 'btn btn-success btn-block']) !!}
                            @else
                                {!! link_to_route('stream.show', 
                                                    'Hors ligne', 
                                                    [$channel->stream->user->pseudo], 
                                                    ['class' => 'btn btn-secondary btn-block']) !!}
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
<h3 class="text-center">Dernières informations récupérées de mon stream</h3>

<h5>Mes followers :</h5>
<table class="table">
    <thead>
        <tr>
            <th>Pseudo</th>
            <th>Ancienneté</th>
        </tr>
    </thead>
    <tbody>
        @foreach($viewers as $viewer)
            <tr>
                <td>{{$viewer->user->pseudo}}</td>
                <td>{{ Carbon\Carbon::parse($viewer->created_at)->format('d/m/Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<h5>Mes abonnés :</h5>
<table class="table">
    <thead>
        <tr>
            <th>Pseudo</th>
            <th>Montant</th>
        </tr>
    </thead>
    <tbody>
        @foreach($subscribers as $sub)
            <tr>
                <td>{{$sub->viewer->user->pseudo}}</td>
                <td>{{$sub->amount}} €</td>
            </tr>
        @endforeach
    </tbody>
</table>
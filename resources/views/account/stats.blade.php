<h3 class="text-center">Dernières données récupérées de mon stream</h3>

{{-- {!! Form::model($user, ['route' => ['home.updateStats'], 'method' => 'put', 'class' => '']) !!} --}}
    
    <h5>Mes followers :</h5>
    <table>
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
                    <td>{{$viewer->created_at}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h5>Mes abonnés :</h5>
    <table>
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
{{-- {!! Form::close() !!} --}}
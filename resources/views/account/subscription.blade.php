<h3 class="text-center">Liste de tous mes abonnements</h3>

{{-- {!! Form::model($user, ['route' => ['home.updateSubscription'], 'method' => 'put', 'class' => '']) !!} --}}
    <h5>Les chaînes suivies : </h5>
    <table>
        <thead>
            <tr>
                <th>Chaîne</th>
                <th>Ancienneté</th>
            </tr>
        </thead>
        <tbody>
            @foreach($channels as $channel)
                <tr>
                    <td>{{$channel->stream->user->pseudo}}</td>
                    <td>{{$channel->created_at}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h5>Mes abonnements :</h5>
    <table>
        <thead>
            <tr>
                <th>Chaîne</th>
                <th>Montant</th>
                <th>Ancienneté</th>
                <th>Renouvelable</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subscriptions as $sub)
                <tr>
                    <td>{{$sub->viewer->stream->user->pseudo}}</td>
                    <td>{{$sub->amount}} €</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h5>Mes dons :</h5>
    <table>
        <thead>
            <tr>
                <th>Chaîne</th>
                <th>Montant</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach($subscribers as $sub)
                <tr>
                    <td>{{$sub->viewer->user->pseudo}}</td>
                    <td>{{$sub->amount}} €</td>
                </tr>
            @endforeach --}}
        </tbody>
    </table>
{{-- {!! Form::close() !!} --}}
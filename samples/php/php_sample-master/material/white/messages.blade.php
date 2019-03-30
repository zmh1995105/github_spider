
@foreach($messages as $type => $group)

    <ul class="message-group {{ $type }}">

        @foreach($group->all() as $message)

            <li class="message">{{ $message }}</li>

        @endforeach

    </ul>

@endforeach
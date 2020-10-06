@foreach($messages as $m)
<li class="message clearfix">
    <div class="{{ $m->from == Auth::user()->user_id ? 'sent' : 'received' }}">
        <p>{{$m->content}}</p>
        <p class="date">{{date('d M y, h:i a', strtotime($m->created_at))}}</p>
    </div>
</li>
@endforeach
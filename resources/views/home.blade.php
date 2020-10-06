@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="user-wrapper">
                <ul class="users">
                    @foreach($users as $u)
                    <li class="user">
                        <input type="" name="" value="{{$u->user_id}}">
                        <a type="button" class="chatWith" data-userId="{{$u->user_id}}" id="{{$u->user_id}}">
                            @foreach($login_user as $l_u)
                            <span class="pending">{{$l_u->countUnreadMessage->where('from', $u->user_id)->count()}}</span>
                            @endforeach

                        <div class="media">
                            <div class="media-left">
                                <img src="https://via.placeholder.com/150" alt="user image" class="media-object">
                            </div>

                            <div class="media-body">
                                <p class="name">{{$u->name}}</p>
                                <p class="email">{{$u->email}}</p>

                            </div>
                        </div>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="col-md-8" id="messages">
            <div class="message-wrapper">
                <ul class="messages">
                    {{-- <li class="message clearfix">
                        <div class="sent">
                            <p>Lorem ispum</p>
                            <p class="date">1 sep 2020</p>
                        </div>
                    </li>

                    <li class="message clearfix">
                        <div class="received">
                            <p>Lorem ispum</p>
                            <p class="date">1 sep 2020</p>
                        </div>
                    </li> --}}
                </ul>
            </div>

            <div class="input-text">
                <input type="text" name="message" class="submit">
                <input type="submit" name="submit" value="Gửi">
            </div>

        </div>
    </div>
</div>
@endsection
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        var id = '';// id người nhận
        var my_id = {{Auth::user()->user_id}};
        $(document).ready(function(){
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                }
            });

            // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('e7712c981f46dee9d839', {
      cluster: 'eu'
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
      // var datas = JSON.stringify(data);
      if(data.message.from == my_id)
      {
        $('#' + data.message.to).click();
      }
      // khi mình ở vị trí là người nhận tin nhắn
      else if(my_id == data.message.to)
      {
        if(id == my_id) // nếu mình đã đọc rồi thì chắc chắn đã nhấn vào tin nhắn của ng đó thì id lúc này sẽ được set là id người nhận( có thể xem .chatwith bên dưới)
        {
            $('#' + data.message.from).click();
        }
        else // ở trường hợp này là chưa đọc tin nhắn, sẽ hiển thị có bao nhiêu tin nhắn chưa đọc .pending
        {
            var pending = parseInt($('#' + data.message.from).find('.pending').html());
            if(pending)
            {
                $('#' + data.message.from).find('.pending').html(pending + 1);
            }
            else
            {
                $('#' + data.message.from).find('.pending').append('<span>1</span>');
            }
            
        }
      }
    });

            $('.chatWith').on('click', function(){
                $('.chatWith').removeClass('active');
                $(this).addClass('active');
                $(this).find('.pending').remove();
                id = $(this).attr('data-userId');
                $.get('chatWith/'+id, function(content){
                    console.log("hello");
                    $('.messages').html(content);
                    scrollToBottomFunc();   
                });
            });

            $(document).on('keyup', '.input-text input', function(e){
                var message = $(this).val();

                if(e.keyCode == 13 && message != '' && id != '') // phim enter
                {
                    var datastr = "received_id=" + id + "&message=" + message;
                    $.ajax({
                        type: "post",
                        url: "message",
                        data: datastr,
                        cache: false,
                        success: function(data)
                        {
                            
                        },
                        error: function(jqXHR, status, err)
                        {

                        },
                        complete: function(){
                            scrollToBottomFunc();
                        }
                    });
                }
            });
        });

        // make a function to scroll down auto
    function scrollToBottomFunc() {
        $('.message-wrapper').animate({
            scrollTop: $('.message-wrapper').get(0).scrollHeight
        }, 50);
    }
    </script>

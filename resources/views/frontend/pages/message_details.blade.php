@extends('frontend.main_master')
@section('main')

@section('title')
Messages | TRAVELER
@endsection

<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>


<div class="container-fluid  " >
  <main class="content msg-detail" >
    <div class="container p-0 pt-4 pb-5 " >
      <div class="text-center mb-3 pb-3 pt-5">
        <h1>Conversations</h1>
      </div>
		  <div class="card" id="refreshedDiv" >     
			  <div class="row g-0 mssg">
				  <div class="col-12">
					  <div class="py-2 px-4 border-bottom d-lg-block scrollable-chat">
						  <div class="d-flex align-items-center py-1">
                <div class="position-relative">
                  <img src="{{asset($sender->image)}}" class="rounded-circle mr-1" width="40" height="40">
                </div>
							  <div class="flex-grow-1 pl-3">
								  <strong>{{$sender->name}}</strong>
							  </div>
                  @if(Auth::check())
                    @if($sender->last_seen >= now()->subMinutes(5))
                      <small class="chat-online"><span class="noti-online-chat"></span> Online</small>
                    @else
                      <small class="chat-offline"><span class="noti-offline-chat"></span> Offline</small>
                    @endif
                  @endif
						    <div>
                  @if(Auth::user()->hasRole('user'))
                    <a class="btn buttons btn-sm px-3 profile-button" href="{{route('guides.details', $sender->username)}}">View Profile</a>
                  @else
                    <a class="btn buttons btn-sm px-3 profile-button" href="{{route('local.user.details', $sender->username)}}">View Profile</a>
                  @endif
                </div>
					    </div>
				    </div>
				    <div class="position-relative chat-messages" >
              @foreach($messages as $message)
					      <div class="p4">
                  @if(Auth::user()->user_id == $message->sender_id)
						        <div class="chat-message-right">
                      <div>
                        <img src="{{asset(Auth::user()->image)}}" class="rounded-circle mr-1" >
                        <div class="text-muted small text-nowrap mt-2">{{$message->created_at->diffForHumans()}}</div>
                      </div>
							        <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
								        <div class="font-weight-bold mb-1"></div>{!! $message->content !!}</div>
							      </div>
                  @else
                    <div class="chat-message-left">
							        <div>
							          <img src="{{asset($sender->image)}}" class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40">
								        <div class="text-muted small text-nowrap mt-2">{{$message->created_at->diffForHumans()}}</div>
							        </div>
							        <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
								        <div class="font-weight-bold mb-1"></div>{!! $message->content !!}
							        </div>
						        </div>
                  @endif
					      </div>
              @endforeach
				    </div>
				    <input type="hidden" name="_token" value="{{ csrf_token() }}">
				    <div class="flex-grow-0 py-3 px-4 border-top">
					    <form id="messageForm" method="post" action="{{ route('send.message') }}">
                @csrf
						    <input type="hidden" name="is_read" value="0">
                <input type="hidden" name="recipient_id" value="{{$sender->user_id}}" autocomplete="off">
                <div class="input-group">
                  <input type="text" class="form-control" name="content" placeholder="Type your message">
                  <button class="btn buttons ml-2"><i class="fas fa-paper-plane"></i></button>
                </div>
              </form>
				    </div>
            <div class=""></div>
			    </div>
		    </div>
	    </div>
  </main>
</div>


<script>
  $(document).ready(function() {
    // Formu AJAX ile gönderme
    $('#messageForm').submit(function(event) {
      event.preventDefault(); // Sayfa yenilenmesini engelle
      var formData = $(this).serialize(); // Form verilerini al
      $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: formData,
        dataType: 'json',
        success: function(response2) {
        	
          var messageHTML2 = '<div class="p-4"><div class="chat-message-right">' +
            '<div>' +
            '<img src="{{asset(Auth::user()->image)}}" class="rounded-circle mr-1" width="40" height="40">' +
            '<div class="text-muted small text-nowrap mt-2">' + response2.created_at + '</div>' +
            '</div>' +
            '<div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">' +
            '<div class="font-weight-bold mb-1"></div>' +
            response2.content +
            '</div>' +
            '</div></div>';

          $('.chat-messages').append(messageHTML2);
					
        },
        error: function(xhr, status, error) {
          // Hata durumunda uygun hata işlemlerini yapın
          console.error('Ajax error:', error);
        }
      });
    });
  });
</script>

<script>
function markMessageAsRead(messageId) {
  $.ajax({
    type: 'POST',
    url: '/message-read',
    data: {
      _token: $('meta[name="csrf-token"]').attr('content'), // CSRF token'ını gönderin
      messageId: messageId
    },
    dataType: 'json',
    success: function (response) {
      console.log('Message marked as read:', response);
    },
    error: function (xhr, status, error) {
      console.error('Ajax error:', error);
    }
  });
}

  function fetchNewMessages() {
    $.ajax({
      type: 'GET',
      url: '/check/messages', // Sunucu tarafında bu URL'yi oluşturmalısınız
      dataType: 'json',
      success: function (response) {
        // Başarılı bir şekilde alındığında, yeni mesajları sohbet kutusuna ekleyin
        if (response && response.messages && response.messages.length > 0) {
          for (var i = 0; i < response.messages.length; i++) {
            var message = response.messages[i];
            var messageHTML = '<div class="p-4">' +
              '<div class="chat-message-left">' +
              '<div>' +
              '<img src="{{asset($sender->image)}}" class="rounded-circle mr-1" width="40" height="40">' +
              '<div class="text-muted small text-nowrap mt-2">' + message.created_at + '</div>' +
              '</div>' +
              '<div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">' +
              '<div class="font-weight-bold mb-1"></div>' + message.content +
              '</div>' +
              '</div>' +
              '</div>';

            $('.chat-messages').append(messageHTML);

            // Yeni mesajı okundu olarak işaretle
						markMessageAsRead(message.id);
          }

          // Yeni mesajlar geldiğinde sohbet kutusunu en altta tutun
          var chatMessagesDiv = document.getElementById('refreshedDiv');
          chatMessagesDiv.scrollTop = chatMessagesDiv.scrollHeight;
        }
      },
      error: function (xhr, status, error) {
        // Hata durumunda uygun hata işlemlerini yapın
        console.error('Ajax error:', error);
      }
    });
  }

  $(document).ready(function () {
    // 5 saniyede bir yeni mesajları kontrol edin
    setInterval(function () {
      fetchNewMessages();
    }, 5000); // 5000 milisaniye yani 5 saniye
  });
</script>

@endsection
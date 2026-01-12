@extends('frontend.main_master')
@section('main')

@section('title')
Messages | TRAVELER
@endsection

<meta name="csrf-token" content="{{ csrf_token() }}">


<div class="container-fluid">
	<div class="container p-0 pt-2 pb-3 my-message-con">

    <!-- Burası kullanıcıların birbirini şikayet edebileceği modalın açılmasını sağlar -->
    @foreach($senders as $item)
      <div class="modal fade" id="complaintModal{{$item->user_id}}" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog dia-modal">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"> Report User</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="post" action="{{route('report.user')}}" >
                @csrf	
                <input type="hidden" name="reported_id" value="{{$item->user_id}}" id="repo_id{{$item->user_id}}">									
                <p>Report inappropriate behavior and help other locals avoid unserious booking requests.</p>
                <div class="form-group">
                  <!-- <label  class="col-form-label d-flex">Email:</label> -->
                  <textarea name="report_message" class="form-control py-3 px-4" rows="3"   required="required"></textarea>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn buttons">Send Report</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    @endforeach

    <main class="content">
      <div class="container p-0 messa-con my-messages-div">
		    <h1 class="h3 mb-3 mess-h1">Messages</h1>
        
		    <div class="card mess-card">		
			    <div class="row g-0">
            <!-- Burada mobil halinde my-messages sayfasında kullanıcıların olduğu divi gösteriyorum -->
            @if(isset($sender_first))	
				    <div class="col-12 col-lg-5 col-xl-3 border-right linkim guide-scrol ">
					    @foreach($senders as $item)  
								    @php
									    $messageCount = $messageCountsBySender->firstWhere('sender_id', $item->user_id)->count ?? 0;
								    @endphp
								    <a href="{{ route('my.messages.details', $item->user_id) }}"  class="list-group-item list-group-item-action border-0">
                      @if($messageCount > 0)
                        <div class="badge bg-success float-right">{{ $messageCount }}</div>
                      @endif								
                      <div class="d-flex align-items-center">		
                        @if(isset($item->image))								
                          <img src="{{ asset($item->image) }}" class="rounded-circle mr-1" width="40" height="40">
                        @else
                          <img src="{{asset('frontend/img/no-image2.jpg')}}" class="rounded-circle mr-1" width="40" height="40">
                        @endif
                        <div class="flex-grow-1 ml-2 font13">{{ $item->name }}
                          @if(Auth::check())
                            @if($item->last_seen >= now()->subMinutes(5))
                              <div class="small"><span class="fas fa-circle chat-online"></span> Online</div>
                            @else
                              <div class="small"><span class="fas fa-circle chat-offline"></span> {{ Carbon\Carbon::parse($item->last_seen)->diffForHumans()}}</div>
                            @endif
                          @endif
										    </div>
									    </div>	
								    </a>
								    <hr class="d-block  mt-1 mb-0">		
					    @endforeach
					    <hr class="d-block d-lg-none mt-1 mb-0">
				    </div>
            @else
              <!-- Burada ise mobil halinde my-messages/details sayfasında kullanıcıların listesinin olduğu divi gizliyourm -->
            <div class="col-12 col-lg-5 col-xl-3 border-right linkim guide-scrol mobile-gizle">
					    @foreach($senders as $item)
								    @php
									    $messageCount = $messageCountsBySender->firstWhere('sender_id', $item->user_id)->count ?? 0;
								    @endphp
								    <a href="{{ route('my.messages.details', $item->user_id) }}"  class="list-group-item list-group-item-action border-0">
                      @if($messageCount > 0)
                        <div class="badge bg-success float-right">{{ $messageCount }}</div>
                      @endif								
                      <div class="d-flex align-items-center">		
                        @if(isset($item->image))								
                          <img src="{{ asset($item->image) }}" class="rounded-circle mr-1" width="40" height="40">
                        @else
                          <img src="{{asset('frontend/img/no-image2.jpg')}}" class="rounded-circle mr-1" width="40" height="40">
                        @endif
                        <div class="flex-grow-1 ml-2 font13">{{ $item->name }}
                          @if(Auth::check())
                            @if($item->last_seen >= now()->subMinutes(5))
                              <div class="small"><span class="fas fa-circle chat-online"></span> Online</div>
                            @else
                              <div class="small"><span class="fas fa-circle chat-offline"></span> {{ Carbon\Carbon::parse($item->last_seen)->diffForHumans()}}</div>
                            @endif
                          @endif
										    </div>
									    </div>	
								    </a>
								    <hr class="d-block  mt-1 mb-0">
									
					    @endforeach
					    <hr class="d-block d-lg-none mt-1 mb-0">
				    </div>
            @endif

            <!-- Bu kısım my-messages/details sayfasında gözüken kısım -->
				    @if(isset($sender))
				      <div class="col-12 col-lg-7 col-xl-9">
					      <div class="py-2 px-4 border-bottom  d-lg-block">
						      <div class="d-flex align-items-center py-1">
							      <div class="position-relative">
                      <span class="go-back" ><a href="{{route('my.messages')}}" style="color:#6c757d!important;"><i class="fas fa-arrow-left mr-2" style="font-size:18px;"></i></a></span>
                      @if(isset($sender->image))								
								        <img src="{{asset($sender->image)}}" class="rounded-circle mr-1" alt="" width="40" height="40">
                      @else
                        <img src="{{asset('frontend/img/no-image2.jpg')}}" class="rounded-circle mr-1" width="40" height="40">
                      @endif
							      </div>
							      <div class="flex-grow-1 pl-3 font13">
                    @if(Auth::user()->hasRole('user'))
								      <strong><a href="{{route('guides.details', $sender->username)}}">{{$sender->name}}</a></strong>
								    @else
								      <strong><a href="{{route('local.user.details', $sender->username)}}">{{$sender->name}}</a></strong>
                    @endif
							      </div>
							      <div>
                      @if(Auth::user()->hasRole('user'))
                        <a class="btn buttons btn-sm px-3 profile-button mobile-gizle" href="{{route('guides.details', $sender->username)}}">View Profile</a>
                      @else
                        <a class="btn buttons btn-sm px-3 profile-button mobile-gizle" href="{{route('local.user.details', $sender->username)}}">View Profile</a>
                      @endif
                      <ul class="ah-actions actions">
                      <li class="dropdown">
                        <a href="" data-toggle="dropdown" aria-expanded="true">
                            <i class="fa fa-bars"></i>
                        </a>
            
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li>
                              <a class="btn btn-sm deleteChat" id=""  href="{{route('delete.chats', $sender->user_id)}}" onclick="return confirm('Are you sure you want to delete this conversation?')"><i class="fas fa-trash-alt text-primary"></i> Clear Chat</a>
                            </li>
                            <li>
                              <a class="btn btn-sm" id="myButton" data-toggle="modal" data-target="#complaintModal{{$sender->user_id}}"><i class="far fa-flag text-primary"></i> Report</a>
                            </li>
                        </ul>
                    </li>
                      </ul>

                    </div>
						      </div>
					      </div>
					      <div class="position-relative">
						      <div class="chat-messages chat-pad">
                    @if(isset($messages))
						          @foreach($messages as $message)
					              <div class="p4">
                          @if(Auth::user()->user_id == $message->sender_id)
						                <div class="chat-message-right">
                              <div>
                              @if(isset(Auth::user()->image))								
                                <img src="{{asset(Auth::user()->image)}}" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
                              @else
                                <img src="{{asset('frontend/img/no-image2.jpg')}}" class="rounded-circle mr-1" width="40" height="40">
                              @endif
                                <div class="text-muted small text-nowrap mt-2">{{$message->created_at->diffForHumans()}}</div>
                              </div>
							                <div class="flex-shrink-1 bg-light rounded py-2 px-3 message-font bubble right">
								                <div class="font-weight-bold mb-1 font13" ></div>{!! $message->content !!}</div>
							              </div>
                          @else
                            <div class="chat-message-left">
                              <div>
                              @if(isset($sender->image))								
                                <img src="{{asset($sender->image)}}" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
                              @else
                                <img src="{{asset('frontend/img/no-image2.jpg')}}" class="rounded-circle mr-1" width="40" height="40">
                              @endif
                                <div class="text-muted small text-nowrap mt-2 " >{{$message->created_at->diffForHumans()}}</div>
                              </div>
                              <div class="flex-shrink-1 bg-light rounded py-2 px-3 message-font  bubble left">
                                <div class="font-weight-bold mb-1 font13"></div>{!! $message->content !!}
                              </div>
                            </div>
                          @endif
					              </div>
                      @endforeach
                    @endif
						      </div>
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
				      </div>

              <!-- Bu kısım my-messages sayfasında görünen kısım. chat kısmı -->
				    @elseif($sender_first)
            
				      <div class="col-12 col-lg-7 col-xl-9 mobile-gizle">
					      <div class="py-2 px-4 border-bottom d-none d-lg-block ">
						      <div class="d-flex align-items-center py-1">
							      <div class="position-relative">
                    @if(isset($sender_first->image))								
                      <img src="{{asset($sender_first->image)}}" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
                    @else
                      <img src="{{asset('frontend/img/no-image2.jpg')}}" class="rounded-circle mr-1" width="40" height="40">
                    @endif
							      </div>
							      <div class="flex-grow-1 pl-3 font13">
								      <strong>{{$sender_first->name}}</strong>
								      <!-- <div class="text-muted small"><em>Typing...</em></div> -->
							      </div>
							      <div>
                    @if(Auth::user()->hasRole('user'))
                        <a class="btn buttons btn-sm px-3 profile-button" href="{{route('guides.details', $sender_first->username)}}">View Profile</a>
                      @else
                        <a class="btn buttons btn-sm px-3 profile-button" href="{{route('local.user.details', $sender_first->username)}}">View Profile</a>
                      @endif
                      <ul class="ah-actions actions">
                      <li class="dropdown">
                        <a href="" data-toggle="dropdown" aria-expanded="true">
                            <i class="fa fa-bars"></i>
                        </a>
            
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li>
                              <a class="btn btn-sm deleteChat" id=""  href="{{route('delete.chats', $sender_first->user_id)}}" onclick="return confirm('Are you sure you want to delete this conversation?')"><i class="fas fa-trash-alt text-primary"></i> Clear Chat</a>
                            </li>
                            <li>
                              <a class="btn btn-sm" id="myButton" data-toggle="modal" data-target="#complaintModal{{$sender_first->user_id}}"><i class="far fa-flag text-primary"></i> Report</a>
                            </li>
                        </ul>
                    </li>
                      </ul>
                    </div>
						      </div>
					      </div>
					      <div class="position-relative ">
						      <div class="chat-messages p-4 ">
                    @if(isset($messages))
						          @foreach($messages as $message)
					              <div class="p4">
                          @if(Auth::user()->user_id == $message->sender_id)
						                <div class="chat-message-right">
                              <div>
                              @if(isset(Auth::user()->image))								
                                <img src="{{asset(Auth::user()->image)}}" class="rounded-circle mr-1" alt="" width="40" height="40">
                              @else
                                <img src="{{asset('frontend/img/no-image2.jpg')}}" class="rounded-circle mr-1" width="40" height="40">
                              @endif
                                <div class="text-muted small text-nowrap mt-2">{{$message->created_at->diffForHumans()}}</div>
                              </div>
							                <div class="flex-shrink-1 bg-light rounded py-2 px-3 message-font bubble right">
								                <div class="font-weight-bold mb-1 font13"></div>{!! $message->content !!}</div>
							              </div>
                          @else
                            <div class="chat-message-left">
							                <div>
                              @if(isset($sender_first->image))								
                                <img src="{{asset($sender_first->image)}}" class="rounded-circle mr-1" alt="" width="40" height="40">
                              @else
                                <img src="{{asset('frontend/img/no-image2.jpg')}}" class="rounded-circle mr-1" width="40" height="40">
                              @endif
								                <div class="text-muted small text-nowrap mt-2">{{$message->created_at->diffForHumans()}}</div>
							                </div>
							                <div class="flex-shrink-1 bg-light rounded py-2 px-3 message-font bubble left">
								                <div class="font-weight-bold mb-1 font13 "></div>{!! $message->content !!}
							                </div>
						                </div>
                          @endif
					              </div>
                      @endforeach
                    @endif
						      </div>
					      </div>

					      <input type="hidden" name="_token" value="{{ csrf_token() }}">
				        <div class="flex-grow-0 py-3 px-4 border-top">
					        <form id="messageForm" method="post" action="{{ route('send.message') }}">
                    @csrf
						        <input type="hidden" name="is_read" value="0">
                    <input type="hidden" name="recipient_id" value="{{$sender_first->user_id}}" autocomplete="off">
                    <div class="input-group">
                      <input type="text" class="form-control" name="content" placeholder="Type your message">
                      <button class="btn buttons ml-2"><i class="fas fa-paper-plane"></i></button>
                    </div>
                  </form>
				        </div>
				      </div>
				    @else
				    @endif
			    </div>
		    </div>	
	    </div>
    </main>
  </div>
</div>

<script>
  var chatMessages = document.querySelector('.chat-messages');

// Scrollu en altta tutmak için bir fonksiyon oluşturun
function scrollToBottom() {
    chatMessages.scrollTop = chatMessages.scrollHeight;
}
</script>

<script>
  window.onload = function() {
    scrollToBottom();
}
</script>

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
            @if(isset(Auth::user()->image))
            '<img src="{{asset(Auth::user()->image)}}" class="rounded-circle mr-1" width="40" height="40">' +
            @else
            '<img src="{{asset("frontend/img/no-image2.jpg")}}" class="rounded-circle mr-1" width="40" height="40">' +
            @endif
            '<div class="text-muted small text-nowrap mt-2">' + response2.created_at + '</div>' +
            '</div>' +
            '<div class="flex-shrink-1 bg-light rounded py-2 px-3 message-font bubble right">' +
            '<div class="font-weight-bold mb-1 font13"></div>' +
            response2.content +
            '</div>' +
            '</div></div>';

          $('.chat-messages').append(messageHTML2);
					scrollToBottom();
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
							@if(isset($sender->image))
                '<img src="{{asset($sender->image)}}" class="rounded-circle mr-1" width="40" height="40">' +
              @else
                '<img src="{{asset("frontend/img/no-image2.jpg")}}" class="rounded-circle mr-1" width="40" height="40">' +
              @endif
              '<div class="text-muted small text-nowrap mt-2">' + message.created_at + '</div>' +
              '</div>' +
              '<div class="flex-shrink-1 bg-light rounded py-2 px-3 message-font bubble left">' +
              '<div class="font-weight-bold mb-1 font13"></div>' + message.content +
              '</div>' +
              '</div>' +
              '</div>';

            $('.chat-messages').append(messageHTML);
            scrollToBottom();
            // Yeni mesajı okundu olarak işaretle
						markMessageAsRead(message.id);
          }

          // Yeni mesajlar geldiğinde sohbet kutusunu en altta tutun
          // var chatMessagesDiv = document.getElementById('refreshedDiv');
          // chatMessagesDiv.scrollTop = chatMessagesDiv.scrollHeight;
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
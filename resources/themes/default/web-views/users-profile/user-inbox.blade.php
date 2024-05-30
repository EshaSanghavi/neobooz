@extends('layouts.front-end.app')

@section('title',translate('chatting_Page'))

@section('content')
<div class="__chat-seller">

    <div class="container py-4 rtl text-align-direction">
        <div class="row">
            @include('web-views.partials._profile-aside')
            <div class="col"></div>
            <div class="col-lg-8 mx-4 ">
                <div class="bg-white Chat __shadow h-100 rounded-left-0">
                    <div class="messaging ">
                            <div class="inbox_msg position-relative">
                                <div class="mesgs">
                                    <a class="msg-user" href="#" id="reload">
                                        @if(isset($last_chat->admin_id))
                                            <img alt="" class="img" src="{{ getValidImage(path: 'storage/app/public/admin/'.$last_chat->admin->image, type: 'avatar') }}">
                                            <h5 class="m-0">{{ $last_chat->admin->name }}</h5>
                                        @endif
                                    </a>

                                    <div class=" msg_history d-flex flex-column-reverse" id="show_msg">
                                        @if (isset($chattings))
                                            @foreach($chattings as $key => $chat)
                                                @if ( $chat->sent_by_admin)
                                                    <div class="incoming_msg d-flex">
                                                        <div class="incoming_msg_img">
                                                            @if(isset($chat->sent_by_admin))
                                                                <img alt="" src="{{ getValidImage(path: 'storage/app/public/admin/'.$last_chat->admin->image, type: 'avatar') }}">
                                                            @endif
                                                        </div>
                                                        <div class="received_msg">
                                                            <div class="received_withdraw_msg">

                                                                @if($chat->message)
                                                                    <p>
                                                                        {{$chat->message}}
                                                                    </p>
                                                                @endif

                                                                @if (json_decode($chat['attachment']) !=null)
                                                                    <div class="row g-2 flex-wrap mt-3">
                                                                        @foreach (json_decode($chat['attachment']) as $index => $photo)
                                                                            <div class="col-sm-6 col-md-4 position-relative img_row{{$index}}">
                                                                                <a data-lightbox="mygallery" href="{{dynamicStorage(path: "storage/app/public/chatting/".$photo)}}"
                                                                                    class="aspect-1 overflow-hidden d-block border rounded">
                                                                                    <img class="img-fit" alt="{{ translate('chatting') }}"
                                                                                            src="{{ getValidImage(path: 'storage/app/public/chatting/'.$photo, type: 'product') }}">
                                                                                </a>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                @endif

                                                                <span class="time_date">
                                                                    {{$chat->created_at->diffForHumans()}}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="outgoing_msg">
                                                        <div class="send_msg">
                                                            @if($chat->message)
                                                            <p class="btn--primary">
                                                                {{$chat->message}}
                                                            </p>
                                                            @endif

                                                            @if (json_decode($chat['attachment']) !=null)
                                                                <div class="row g-2 flex-wrap mt-3 justify-content-end">
                                                                    @foreach (json_decode($chat['attachment']) as $index => $photo)
                                                                        <div class="col-sm-6 col-md-4 position-relative img_row{{$index}}">
                                                                            <a data-lightbox="mygallery" href="{{dynamicStorage(path: "storage/app/public/chatting/".$photo)}}"
                                                                                class="aspect-1 overflow-hidden d-block border rounded">
                                                                                <img class="img-fit" alt="{{ translate('chatting') }}"
                                                                                        src="{{ getValidImage(path: 'storage/app/public/chatting/'.$photo, type: 'product') }}">
                                                                            </a>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @endif

                                                            <span class="time_date text-end">
                                                                {{ $chat->created_at->diffForHumans() }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endForeach

                                            <div id="down"></div>

                                        @endif
                                    </div>

                                    <div class="type_msg">
                                        <div class="input_msg_write">
                                            <form class="d-flex justify-content-center align-items-center md-form form-sm active-cyan-2"
                                                    id="myForm" enctype="multipart/form-data">
                                                @csrf
                                                <label class="py-0 px-3 d-flex align-items-center m-0 cursor-pointer">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                                        <path d="M18.1029 1.83203H3.89453C2.75786 1.83203 1.83203 2.75786 1.83203 3.89453V18.1029C1.83203 19.2395 2.75786 20.1654 3.89453 20.1654H18.1029C19.2395 20.1654 20.1654 19.2395 20.1654 18.1029V3.89453C20.1654 2.75786 19.2395 1.83203 18.1029 1.83203ZM3.89453 3.20703H18.1029C18.4814 3.20703 18.7904 3.51595 18.7904 3.89453V12.7642L15.2539 9.2277C15.1255 9.09936 14.9514 9.02603 14.768 9.02603H14.7653C14.5819 9.02603 14.405 9.09936 14.2776 9.23136L10.3204 13.25L8.65845 11.5945C8.53011 11.4662 8.35595 11.3929 8.17261 11.3929C7.9957 11.3654 7.81053 11.4662 7.6822 11.6009L3.20703 16.1705V3.89453C3.20703 3.51595 3.51595 3.20703 3.89453 3.20703ZM3.21253 18.1304L8.17903 13.0575L13.9375 18.7904H3.89453C3.52603 18.7904 3.22811 18.4952 3.21253 18.1304ZM18.1029 18.7904H15.8845L11.2948 14.2189L14.7708 10.6898L18.7904 14.7084V18.1029C18.7904 18.4814 18.4814 18.7904 18.1029 18.7904Z" fill="#1455AC"/>
                                                        <path d="M8.12834 9.03012C8.909 9.03012 9.54184 8.39728 9.54184 7.61662C9.54184 6.83597 8.909 6.20312 8.12834 6.20312C7.34769 6.20312 6.71484 6.83597 6.71484 7.61662C6.71484 8.39728 7.34769 9.03012 8.12834 9.03012Z" fill="#1455AC"/>
                                                    </svg>
                                                    <input type="file" id="f_p_v_up1" class="h-100 position-absolute w-100 " hidden multiple accept="image/*">
                                                </label>
                                                @if( Request::is('chat/') )
                                                    <input type="text" id="hidden_value_dm" hidden
                                                            value="{{$last_chat->admin_id}}" name="admin_id"> 
                                                @endif
                                                <div class="w-0 flex-grow-1">
                                                    <textarea class="form-control ticket-view-control px-0 py-3" name="message" rows="8" id="msgInputValue" placeholder="{{translate('write_your_message_here')}}..." ></textarea>
                                                    <div class="d-flex gap-3 flex-wrap filearray"></div>
                                                    <div id="selected-files-container"></div>
                                                </div>

                                                <button type="submit" id="msgSendBtn" class="aSend no-gutter py-0 px-3 m-0 border-0 bg-transparent">
                                                    <svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <rect width="31" height="31" rx="6" fill="currentColor"/>
                                                        <path d="M21.2267 15.5548L10.2267 10.0548C10.1404 10.0116 10.0436 9.99437 9.94779 10.005C9.85198 10.0157 9.7613 10.0538 9.68665 10.1148C9.61536 10.1745 9.56215 10.253 9.53301 10.3413C9.50386 10.4296 9.49993 10.5243 9.52165 10.6148L10.8467 15.4998H16.5017V16.4998H10.8467L9.50165 21.3698C9.48126 21.4453 9.47888 21.5245 9.4947 21.6012C9.51052 21.6778 9.5441 21.7496 9.59273 21.8109C9.64136 21.8722 9.7037 21.9212 9.77472 21.954C9.84574 21.9868 9.92347 22.0025 10.0017 21.9998C10.0799 21.9993 10.157 21.9805 10.2267 21.9448L21.2267 16.4448C21.3086 16.4028 21.3773 16.3391 21.4253 16.2605C21.4733 16.182 21.4987 16.0918 21.4987 15.9998C21.4987 15.9077 21.4733 15.8175 21.4253 15.739C21.3773 15.6605 21.3086 15.5967 21.2267 15.5548Z" fill="white"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
    <script>
        "use strict";

        let selectedFiles = [];
        $(document).on('ready', () => {
            $("#f_p_v_up1").on('change', function () {
                for (let i = 0; i < this.files.length; ++i) {
                    selectedFiles.push(this.files[i]);
                }
                displaySelectedFiles();
            });

            function displaySelectedFiles() {
                const container = document.getElementById("selected-files-container");
                container.innerHTML = "";
                selectedFiles.forEach((file, index) => {
                    const input = document.createElement("input");
                    input.type = "file";
                    input.name = `image[${index}]`;
                    input.classList.add(`image_index${index}`);
                    input.hidden = true;
                    container.appendChild(input);
                    const blob = new Blob([file], { type: file.type });
                    const file_obj = new File([file],file.name);
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file_obj);
                    input.files = dataTransfer.files;
                });

                $(".filearray").empty();
                for (let i = 0; i < selectedFiles.length; ++i) {
                    let filereader = new FileReader();
                    let $uploadDiv = jQuery.parseHTML("<div class='upload_img_box'><span class='img-clear'><i class='tio-clear'></i></span><img src='' width='40' alt=''></div>");

                    filereader.onload = function () {
                        $($uploadDiv).find('img').attr('src', this.result);
                        let imageData = this.result;
                    };

                    filereader.readAsDataURL(selectedFiles[i]);
                    $(".filearray").append($uploadDiv);
                    $($uploadDiv).find('.img-clear').on('click', function () {
                        $(this).closest('.upload_img_box').remove();
                        selectedFiles.splice(i, 1);
                        $('.image_index'+i).remove();
                    });
                }
            }
        });

        $(document).ready(function () {
            var shop_id;
            $(".seller").click(function (e) {
                e.stopPropagation();
                shop_id = e.target.id;
                alert(shop_id);

                $('.chat_list').removeClass('active');
                $(`#user_${shop_id}`).addClass("active");

                let url;

                url = "{{ route('messages') }}";


                $.ajax({
                    type: "get",
                    url: url,
                    success: function (data) {
                        $('.msg_history').html('');
                        $('.chat_ib').find('#' + shop_id).removeClass('active-text');

                        if (data.length != 0) {
                            data.map((element, index) => {
                                let dateTime = new Date(element.created_at);
                                var month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

                                let time = dateTime.toLocaleTimeString().toLowerCase();
                                let date = month[dateTime.getMonth().toString()] + " " + dateTime.getDate().toString();

                                if (element.sent_by_customer) {

                                    $(".msg_history").append(`
                                        <div class="outgoing_msg">
                                          <div class='send_msg'>
                                            <p class="btn--primary">${element.message}</p>
                                            <span class='time_date'> ${time}    |    ${date}</span>
                                          </div>
                                        </div>`
                                    )

                                } else {
                                    let img_path = element.image == 'def.png' ? `{{ dynamicStorage(path: 'storage/app/public/shop') }}/${element.image}` : `{{ (isset($shop->delivery_man_id) && $shop->delivery_man_id) ? dynamicStorage(path: 'storage/app/public/delivery-man') : dynamicStorage(path: 'storage/app/public/shop') }}/${element.image}`;

                                    $(".msg_history").append(`
                                        <div class="incoming_msg d-flex" id="incoming_msg">
                                          <div class="incoming_msg_img" id="">
                                            <img src="${img_path}" alt="">
                                          </div>
                                          <div class="received_msg">
                                            <div class="received_withdraw_msg">
                                              <p id="receive_msg">${element.message}</p>
                                            <span class="time_date">${time}    |    ${date}</span></div>
                                          </div>
                                        </div>`
                                    )
                                }
                                $('#hidden_value').attr("value", shop_id);
                                $('#hidden_value_dm').attr("value", shop_id);
                            });
                        } else {
                            $(".msg_history").html(`<p> No Message available </p>`);
                            data = [];
                        }
                    }
                });

                $('.type_msg').css('display', 'block');
                $(".msg_history").stop().animate({scrollTop: $('.msg_history').prop("scrollHeight")}, 1000);

            });

            $("#myInput").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $(".chat_list").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            $("#msgSendBtn").click(function (e) {
                e.preventDefault();
                let formData = new FormData(document.getElementById('myForm'));
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "post",
                    url: $('#route-messages-store').data('url'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $('#msgSendBtn').attr('disabled', true);
                    },
                    success: function (respons) {
                        let imageContainer = ''
                        if(respons.image.length != 0){
                            imageContainer = '<div class="row g-2 flex-wrap mt-3 justify-content-end">';
                            respons.image.forEach(function (imageUrl, index) {
                                imageContainer += `
                                    <div class="col-sm-3 col-md-4 spartan_item_wrapper position-relative img_row${index}">
                                        <a data-lightbox="mygallery" href="${imageUrl}" class="aspect-1 overflow-hidden d-block border rounded">
                                            <img src="${imageUrl}" alt="" class="img-fit">
                                        </a>
                                    </div>`;
                            });

                            imageContainer += '</div>';
                        }

                        let message = respons.message ? `<p class="btn--primary">${respons.message}</p>` : '';

                        $(".msg_history").prepend(`
                            <div class="outgoing_msg" id="outgoing_msg">
                              <div class='send_msg'>
                                ${message}
                                ${imageContainer}
                                <span class='time_date d-flex justify-content-end'> {{ translate('now') }}</span>
                              </div>
                            </div>`
                        )
                        $(".msg_history").stop().animate({scrollTop: $(".msg_history")[0].scrollHeight}, 1000);
                        $('#myForm').trigger('reset');
                        $('#myForm').find('#msgInputValue').val('');
                        $('#myForm').find('.upload_img_box img').attr('src', '');
                        $('#myForm').find('.upload_img_box').remove();
                        $('#f_p_v_up1').val('');
                        selectedFiles = [];
                    },
                    complete: function () {
                        $('#msgSendBtn').removeAttr('disabled');
                        $('#myForm').trigger('reset');
                        $('#myForm').find('#msgInputValue').val('');
                        window.location.href = window.location.href;
                    },
                    error: function (error) {
                        if(!error == null)
                            toastr.warning(error.responseJSON)
                        else{
                            $('#myForm').trigger('reset');
                            window.location.href = window.location.href;
                        }
                    }
                });
            });
        });

        const reloadLink = document.getElementById("reload");
        reloadLink.addEventListener("click", function (event) {
            event.preventDefault(); // Prevent default link behavior (navigation)
            window.location.href = window.location.href; // Reload current URL
        });
    </script>

@endpush


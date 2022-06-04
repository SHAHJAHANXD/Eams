<div class="chat-history" style="height: 370px;">
    <ul class="m-b-0">
        @php
            $id = Auth::user()->id;
        @endphp
        @isset($room_dev)
            @foreach ($room_dev as $room_dev)
                @if ($room_dev->sender_id == $id && $room_dev->receiver_id == $receiver_id)
                    <li class="clearfix">
                        <div class="message-data text-right">
                            <span class="message-data-time">{{ $room_dev->created_at->diffForHumans() }}</span>
                            <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">
                        </div>
                        <div class="message other-message float-right">
                            {{ $room_dev->message }}
                        </div>
                    </li>
                @elseif ($room_dev->receiver_id = $id && $room_dev->sender_id == $receiver_id)
                    <li class="clearfix">
                        <div class="message-data">
                            <span class="message-data-time">{{ $room_dev->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="message my-message">{{ $room_dev->message }}</div>
                    </li>
                @endif
            @endforeach
        @endisset
    </ul>
</div>

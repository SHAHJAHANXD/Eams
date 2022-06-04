<div>
    <form wire:submit.prevent="store()" method="POST" class="bg-light" enctype="multipart/form-data">
        @csrf
        <div class="input-group">
            <input type="text" name="message" wire:model="message" placeholder="Type a message" aria-describedby="button-addon2"
                class="form-control rounded-0 border-0 py-4 bg-light">
            @if ($errors->has('message'))
                <span class="text-danger">{{ $errors->first('message') }}</span>
            @endif
            @isset($username)
                    <input type="text" hidden value="{{ $username->id }}" wire:model="receiver_id" name="receiver_id">
            @endisset
            <div class="input-group-append">
                <button  id="button-addon2" type="submit" class="btn btn-link"> <i
                        class="fa fa-paper-plane"></i></button>
            </div>
        </div>
    </form>
</div>

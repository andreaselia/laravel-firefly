<div class="modal" id="newGroupModal">
    <div class="modal-title">
        {{ __('New Group') }}
    </div>

    <div class="modal-body">
        <form role="form">
            <div class="form-group">
                <label for="title">{{ __('Name') }}</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control">
            </div>

            <div class="form-group">
                <label for="title">{{ __('Color') }}</label>
                <input type="color" name="color" id="color" value="{{ old('color') }}" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
        </form>
    </div>
</div>

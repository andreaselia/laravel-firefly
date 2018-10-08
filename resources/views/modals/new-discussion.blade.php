<div class="modal" id="newDiscussionModal">
    <div class="modal-inner">
        <div class="modal-title">
            {{ __('New Discussion') }}
        </div>

        <div class="modal-body">
            <new-discussion inline-template>
                <form role="form">
                    <div class="form-group">
                        <label for="title">{{ __('Title') }}</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="content">{{ __('Content') }}</label>
                        <textarea name="content" id="content" class="form-control" rows="5">{{ old('content') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        {{ __('Submit') }}
                    </button>
                </form>
            </new-discussion>
        </div>
    </div>
</div>

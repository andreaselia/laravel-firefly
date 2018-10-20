<div class="modal modal-large" id="newDiscussionModal">
    <div class="modal-inner">
        <div class="modal-title">
            {{ __('New Discussion') }}
        </div>

        <div class="modal-body">
            <edit-discussion :group="{{ $group }}" :discussion="{{ $discussion }}" inline-template>
                <form role="form" @submit.prevent="submit">
                    <div class="form-group">
                        <label for="title">{{ __('Title') }}</label>
                        <input type="text" v-model="title" id="title" value="{{ old('title') }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="content">{{ __('Content') }}</label>
                        <textarea v-model="content" id="content" class="form-control" rows="5">{{ old('content') }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-grey mr-2" @click.prevent="toggleModal('newDiscussion')">
                            {{ __('Cancel') }}
                        </button>

                        <button type="submit" class="btn btn-green">
                            {{ __('Submit') }}
                        </button>
                    </div>
                </form>
            </edit-discussion>
        </div>
    </div>
</div>

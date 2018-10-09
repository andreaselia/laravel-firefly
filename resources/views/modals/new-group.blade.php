<div class="modal" id="newGroupModal">
    <div class="modal-inner">
        <div class="modal-title">
            {{ __('New Group') }}
        </div>

        <div class="modal-body">
            <new-group inline-template>
                <form role="form" @submit.prevent="submit">
                    <div class="form-group">
                        <label for="title">{{ __('Name') }}</label>
                        <input type="text" v-model="name" id="name" value="{{ old('name') }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="title">{{ __('Color') }}</label>
                        <input type="text" v-model="color" id="color" value="{{ old('color') }}" class="form-control">
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
            </new-group>
        </div>
    </div>
</div>

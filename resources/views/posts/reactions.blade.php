<div
    x-data="ReactionsToPost{{$post->id}}({{\Firefly\Models\Reaction::convertReactions($post->groupedReactions)}})"
    x-on:keydown.escape.prevent.stop="close($refs.button)"
    x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
    x-id="['dropdown-button-{{$post->id}}']"
    class="mt-2 relative"
>
    <button
        class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-sm font-medium text-gray-800"
        data-tippy-content="React to this Post"
        x-ref="button"
        x-on:click="toggle()"
        :aria-expanded="open"
    >
        <svg class="h-4 w-4 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />
        </svg>
    </button>

    <div
        x-ref="panel"
        x-show="open"
        @click.away="close($refs.button)"
        style="display: none; width: 24.85rem;"
        class="absolute left-0 mt-2 p-4 max-h-64 bg-white shadow-md overflow-scroll rounded z-50"
    >
        <template x-for="ecategory in categories" :key="ecategory.category">
            <button
                class="inline-block p-2 cursor-pointer hover:bg-blue-100 br border-gray-300 focus:ring-0 focus:outline-0"
                :class="{ 'bg-blue-100': ecategory.group === category }"
                :title="ecategory.category" x-on:click="category = ecategory.group;"
            >
                <span class="inline-block w-5 h-5" x-text="ecategory.emoji" :title="ecategory.category"></span>
            </button>
        </template>

        <input type="search" x-model="search" class="h-10 w-full px-2 mb-2 text-sm border border-1 border-slate-200 bg-gray-50 rounded-md placeholder:text-gray-500" placeholder="Search an emoji...">

        <template x-for="emoji in filteredEmojis" :key="emoji.emoji">
            <button class="inline-block py-2 px-3 m-1 cursor-pointer rounded-md bg-gray-100 hover:bg-blue-100" :title="emoji.keywords" x-on:click="input = emoji.emoji; toggle(); sendReaction(emoji.emoji);">
                <span class="inline-block w-5 h-5" x-text="emoji.emoji"></span>
            </button>
        </template>
    </div>

    <template x-for="reaction in reactions" :key="reaction.reaction">
        <button class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-sm font-medium text-gray-800" x-on:click="sendReaction(reaction.reaction)">
            <span class="h-4 w-4" x-html="reaction.reaction"></span>
            <span x-show="reaction.count > 1" class="text-gray-900 ml-2 py-0.5 text-xs font-semibold" x-text="reaction.count"></span>
        </button>
    </template>
</div>

<script>
function ReactionsToPost{{$post->id}}(reactions) {
    return {
        open: false,
        search: '',
        category: '',
        input: '...',
        reactions: reactions,
        toggle() {
            if (this.open) {
                return this.close()
            }

            this.$refs.button.focus()

            this.open = true
        },
        close(focusAfter) {
            if (! this.open) {
                return;
            }

            this.open = false;

            focusAfter && focusAfter.focus();
        },
        categories: window.EMOJIS.categories,
        get filteredEmojis() {
            if (this.search != '') {
                return window.EMOJIS.symbols.filter(symbol => symbol.keywords.includes(this.search));
            }

            if ( this.category != '' ) {
                return window.EMOJIS.symbols.filter(symbol => symbol.group == this.category);
            }

            return window.EMOJIS.symbols.sort(() => Math.random() - 0.5).slice(0, 12);
        },
        sendReaction(emoji) {
            fetch('{{ route('firefly.post.react', ['post' => $post]) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    reaction: emoji,
                })
            })
                .then((response) => response.json())
                .then((reactions) => this.reactions = reactions)
                .catch(() => {
                    console.log('Ooops! Something went wrong!')
                });
        }
    }
}
</script>

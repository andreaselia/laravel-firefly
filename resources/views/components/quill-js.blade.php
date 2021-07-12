@if (config('firefly.features.wysiwyg.enabled'))
    <script>
        var toolbarOptions = {!! json_encode(config('firefly.features.wysiwyg.toolbar_options')) !!};
        var options = {
            modules: {
                toolbar: toolbarOptions
            },
            theme: '{{ config('firefly.features.wysiwyg.theme') }}'
        };
        var editor = new Quill('#content', options);

        document.getElementById('submit').addEventListener('click', function (event) {
            var content = document.getElementsByClassName('ql-editor')[0].innerHTML
            document.getElementById('content_hidden').setAttribute('value', content)
        })
    </script>
@endif

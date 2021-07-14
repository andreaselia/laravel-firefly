@if (Firefly\Features::enabled('wysiwyg'))
    <script>
        var toolbarOptions = {!! json_encode(Firefly\Features::option('wysiwyg', 'toolbar_options')) !!};
        var options = {
            modules: {
                toolbar: toolbarOptions
            },
            theme: '{{ Firefly\Features::option('wysiwyg', 'theme') }}'
        };
        var editor = new Quill('#content', options);

        document.getElementById('submit').addEventListener('click', function (event) {
            var content = document.getElementsByClassName('ql-editor')[0].innerHTML
            document.getElementById('content_hidden').setAttribute('value', content)
        })
    </script>
@endif

@props(['group'])

<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium text-white" style="background-color: {{ $group->color }};">
    {{ $group->name }}
</span>

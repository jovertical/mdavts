<div class="alert alert-{{ $type }}">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>

    <h3 class="text-{{ $type }}">
        {{ $title }}
    </h3>

    {{ $slot }}
</div>
@unless ($breadcrumbs->isEmpty())
    <ol class="breadcrumb">
        @foreach ($breadcrumbs as $breadcrumb)

            @if (!is_null($breadcrumb->url) && !$loop->last)
                <li class="breadcrumb-item" title="{{ $breadcrumb->title }}"><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
            @else
                <li class="breadcrumb-item active" title="{{ $breadcrumb->title }}">{{ $breadcrumb->title }}</li>
            @endif

        @endforeach
    </ol>
@endunless

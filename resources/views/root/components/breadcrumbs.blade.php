<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0">{{ $page_title ?? '' }}</h3>

        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('root.dashboard') }}">Dashboard</a>
            </li>

            {{ $slot ?? '' }}
        </ol>
    </div>

    <div class="col-md-7 col-4 align-self-center">
        {{ $action ?? '' }}
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
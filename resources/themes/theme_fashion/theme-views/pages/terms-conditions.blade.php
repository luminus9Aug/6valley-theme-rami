@extends('theme-views.layouts.app')

@section('title', translate('terms_&_conditions').' | '.$web_config['company_name'].' '.translate('ecommerce'))

@section('content')
    <main class="main-content d-flex flex-column gap-3 pb-3">
        <div class="page_title_overlay py-5">
            <img loading="lazy" class="bg--img" alt="{{ translate('terms') }}"
                 src="{{getStorageImages(path: imagePathProcessing(imageData: (isset($pageTitleBanner['value']) ?json_decode($pageTitleBanner['value'])?->image : null),path: 'banner'),source: theme_asset('assets/img/page-title-bg.png'))}} ">

            <div class="container">
                <h1 class="text-center text-capitalize">{{translate('terms_&_conditions')}}</h1>
            </div>
        </div>
        <div class="container">
            <div class="card my-4">
                <div class="card-body p-lg-4 text-dark page-paragraph">
                    {!! $termsCondition !!}
                </div>
            </div>
        </div>
    </main>
@endsection

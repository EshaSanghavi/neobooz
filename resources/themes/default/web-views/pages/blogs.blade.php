@extends('layouts.front-end.app')

@section('title', translate('all_Blogs'))
 
@endsection

@push('script')
    <script src="{{theme_asset(path: 'public/assets/front-end/vendor/nouislider/distribute/nouislider.min.js')}}"></script>
@endpush

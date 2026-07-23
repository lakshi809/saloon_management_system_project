@include('customer_include.header_start')

@yield('pageSpecificStyles')

@include('customer_include.header_end')

@include('customer_include.common_css')

<!-- Left Sidebar -->

{{-- @include('customer_include.leftbar') --}}


@include('customer_include.top_bar')

@yield('pageSpecificContent')

@include('customer_include.common_script')

@yield('pageSpecificScript')
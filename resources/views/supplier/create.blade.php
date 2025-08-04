<form class="needs-validation" method="POST" action="{{route('suppliers.store')}}">
    @csrf
    @include('supplier.form')
{{--    <script>alert('hello world')</script>--}}
</form>


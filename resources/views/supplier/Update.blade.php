<form class="needs-validation" method="PUT" action="{{route('suppliers.update',$suppliers->id)}}">
    @csrf
    @include('supplier.form')
    {{--    <script>alert('hello world')</script>--}}
</form>

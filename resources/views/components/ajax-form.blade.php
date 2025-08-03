{{--<div>--}}
{{--    <form id="{{ $id }}" method="{{ $method }}" action="{{ $action }}" class="{{ $class }}">--}}
{{--        @csrf--}}
{{--        @if (strtoupper($method) != 'GET' && strtoupper($method) != 'POST')--}}
{{--            @method($method)--}}
{{--        @endif--}}

{{--        {{ $slot }}--}}

{{--        <button type="submit" class="btn btn-primary">{{ $buttonText ?? 'Save' }}</button>--}}
{{--    </form>--}}

{{--    <script>--}}
{{--        $(document).ready(function() {--}}
{{--            $('#{{ $id }}').submit(function(e) {--}}
{{--                e.preventDefault();--}}

{{--                let form = $(this);--}}
{{--                let url = form.attr('action');--}}
{{--                let method = form.find('input[name="_method"]').val() || form.attr('method');--}}
{{--                let data = form.serialize();--}}

{{--                ajaxRequest(url, method, data, function(response) {--}}
{{--                    alert(response.message);--}}
{{--                    $('#myModal').modal('hide');--}}
{{--                    location.reload();--}}
{{--                });--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}

{{--</div>--}}

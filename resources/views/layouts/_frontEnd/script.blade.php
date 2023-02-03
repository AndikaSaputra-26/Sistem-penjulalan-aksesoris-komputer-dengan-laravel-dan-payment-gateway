<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="{{ asset('temp-front-end/assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('temp-front-end/assets/js/bootstrap-hover-dropdown.min.js') }}"></script>
<script src="{{ asset('temp-front-end/assets/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('temp-front-end/assets/js/echo.min.js') }}"></script>
<script src="{{ asset('temp-front-end/assets/js/jquery.easing-1.3.min.js') }}"></script>
<script src="{{ asset('temp-front-end/assets/js/bootstrap-slider.min.js') }}"></script>
<script src="{{ asset('temp-front-end/assets/js/jquery.rateit.min.js') }}"></script>
<script src="{{ asset('temp-front-end/assets/js/lightbox.min.js') }}"></script>
<script src="{{ asset('temp-front-end/assets/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('temp-front-end/assets/js/wow.min.js') }}"></script>
<script src="{{ asset('temp-front-end/assets/js/scripts.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
<script type="text/javascript">
    var path = "{{ url('autocomplete-search-query') }}";
    $('input.typeahead').typeahead({
        source: function(query, process) {
            return $.get(path, {
                term: query
            }, function(data) {
                return process(data);
            });
        }
    });
</script>

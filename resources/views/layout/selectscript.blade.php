<link rel="stylesheet" href="{{ asset('extensions/choices.js/public/assets/styles/choices.css') }}">
<script src="{{ asset('extensions/choices.js/public/assets/scripts/choices.js')}}"></script>
<script src="{{ asset('static/js/pages/form-element-select.js')}}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const selectElements = document.querySelectorAll('select');
  selectElements.forEach(select => {
    new Choices(select, {
      searchEnabled: true,
      searchChoices: true,
      searchResultLimit: 1
    });
  });
});
</script>
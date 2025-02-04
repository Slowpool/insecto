
document.addEventListener('DOMContentLoaded', function () {
    filterForm = document.getElementById('filter-form');
    filterForm.addEventListener('submit', function () {
        var inputs = this.getElementsByTagName('input');
        for (var input of inputs) {
            // disabling of empty inputs such as a `minPrice` to prevent them from being added to uri without value, like here `minPrice=&maxPrice=&...`
            if (input.value == '') {
                input.disabled = true;
            }

            // TODO handle hidden default input with value 0 for checkboxes when the checkbox is 1 so that url wouldn't contain parameters like `isAlive=0&isAlive=1` simultaneously
        }
        return true;
    });
})

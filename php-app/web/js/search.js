var searchForm = null;

document.addEventListener('DOMContentLoaded', function () {
    searchForm = document.getElementById('search-form');
    var checkboxes = document.getElementsByClassName('search-category-checkbox');
    for (var checkbox of checkboxes) {
        checkbox.addEventListener('change', HandleCategoryToggling);
    }

    searchForm.addEventListener('submit', function () {
        var inputs = this.getElementsByTagName('input');
        for (var input of inputs) {
            // disabling of empty inputs such as a `minPrice` to prevent them from being added to uri without value, like here `...searchText=&minPrice=&maxPrice=&...`
            if (input.value == ''
                // categories are already coded in form's action via `HandleCategoryToggling` function. otherwise they will be in url twice
                || input.classList.contains('search-category-checkbox')) {
                input.disabled = true;
            }

            // TODO handle hidden default input with value 0 for checkboxes when the checkbox is 1 so that url wouldn't contain parameters like `isAlive=0&isAlive=1` simultaneously
        }
        return true;
    });
})

function HandleCategoryToggling() {
    var toggledCategory = '/' + this.value;
    var formAction = decodeURIComponent(CutHostPart(searchForm.action));
    if (this.checked) {
        searchForm.action = formAction + toggledCategory;
    }
    else {
        searchForm.action = formAction.replace(toggledCategory, '');
    }
}

function CutHostPart(formAction) {
    // TODO edit in production
    return formAction.slice('http://localhost:8000'.length)
}
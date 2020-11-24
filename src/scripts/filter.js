window.addEventListener('load', evt => {
    let dataFilters = document.querySelectorAll('[data-filter]');

    for (dataFilter of dataFilters) {
        // The attribue of the filtered element
        let filterAttribute = dataFilter.getAttribute('data-filter-attr');
        // The element that contains elements to filter. This allows us to only 
        // search the elements from within a parent.
        let filterElement = dataFilter.getAttribute('data-filter');

        let table = document.getElementById(filterElement);
        // This are the elements we will be iterating to check against the dataFilter value
        let filterElements = table.querySelectorAll(`[${filterAttribute}]`);

        dataFilter.addEventListener('input', function () {
            if (this.value.trim() === '') {
                for (let element of filterElements) {
                    element.style.display = '';
                }

                return;
            }

            for (let element of filterElements) {
                let elementValue = element.getAttribute(filterAttribute).toLowerCase();
                let search = this.value.toLowerCase();
                if (elementValue.includes(search)) {
                    element.style.display = '';
                } else {
                    element.style.display = 'none';
                }
            }
        });
    }
});
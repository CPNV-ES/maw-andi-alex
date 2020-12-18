document.addEventListener('click', function (evt) {
    let dataConfirm = evt.target.getAttribute('data-confirm');
    if (dataConfirm) {
        if (!confirm(dataConfirm)) {
            evt.preventDefault();
        }
    }
});
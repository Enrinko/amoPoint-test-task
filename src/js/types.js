const selectElement = document.querySelector('p > select');

const inputElements = document.querySelectorAll('p > input');

selectElement.addEventListener('change', function () {
    const selectedValue = this.value;
    inputElements.forEach(input => {
        if (input.getAttribute('name').includes(selectedValue)) {
            input.parentElement.style.display = 'none';
        } else {
            input.parentElement.style.display = 'block';
        }
    });
});
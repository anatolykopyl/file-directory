$(document).on('click', 'div.dropdown-menu', function (e) {
    e.stopPropagation();
});

const buttons = document.querySelectorAll('.delete-button')
buttons.forEach((button) => {
    button.addEventListener("click", async function(event) {
        const response = await fetch("delete.php", {
            method: 'POST',
            headers: {
                'Accept': 'application/x-www-form-urlencoded',
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `file=${event.target.dataset.file}`
        });
    })
});
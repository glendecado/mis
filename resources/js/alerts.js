window.addEventListener('success', (event) => {
    let e = event.detail;

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-right',
        iconColor: 'white',
        customClass: {
            popup: 'colored-toast',
        },
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
    });

    Toast.fire({
        icon: 'success',
        title: e.name,
    })
});

window.addEventListener('error', (event) => {
    let e = event.detail;

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-right',
        iconColor: 'white',
        customClass: {
            popup: 'colored-toast',
        },
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
    });

    Toast.fire({
        icon: 'error',
        title: e.name,
    })
});


//to change color go to app.css
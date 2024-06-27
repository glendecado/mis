window.addEventListener('alert', (event) => {
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
export class RegAuth {
    constructor() {

    }

    toggleView() {
        $('.auth-but').click(function(event) {
            if ($(this).hasClass('active')) {
                event.preventDefault();
                return;
            } else if ($('.auth-window').hasClass('hidden')) {
                $('.auth-window').removeClass('hidden');
                $('.reg-window').toggleClass('hidden');
            } else {
                $('.reg-window').toggleClass('hidden');
            };
            $(this).toggleClass('active');
            $('.reg-but').removeClass('active');

        });

        $('.reg-but').click(function(event) {
            if ($(this).hasClass('active')) {
                event.preventDefault();
                return;
            } else if ($('.reg-window').hasClass('hidden')) {
                $('.reg-window').removeClass('hidden');
                $('.auth-window').toggleClass('hidden');
                // $(this).toggleClass('active')
            } else {
                $('.auth-window').toggleClass('hidden');
                // $(this).toggleClass('active')

            };
            $(this).toggleClass('active');
            $('.auth-but').removeClass('active');
        })
    }

    setupRegisterHandler() {
        async function registerUser() {
            try {
                $('.reg-window .confirm').prop('disabled', true);
                const formData = new FormData(this);
                console.log(formData);

                const response = await fetch('reg.php', {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();

                if (data.success) {
                    console.log(data.message);
                } else {
                    console.log('Error: ', data.message);
                    $('.reg-window .flash-message').text(data.message).show()
                    $('.reg-window .confirm').prop('disabled', false);
                }

            } catch (error) {
                console.error('Error: ', error)
            }
        };

        $('#reg-form').submit(function(event) {
            event.preventDefault();
            registerUser.call(this);
        });
    }


    setupLoginHandler() {
            async function authUser() {
                try {
                    $('.auth-window .confirm').prop('disabled', true);
                    const formData = new FormData(this);
                    console.log(formData);

                    const response = await fetch('auth.php', {
                        method: 'POST',
                        body: formData
                    });
                    const data = await response.json();

                    if (data.success) {
                        console.log(data.message);
                    } else {
                        console.log('Error: ', data.message);
                        $('.auth-window .flash-message').text(data.message).show()
                        $('.auth-window .confirm').prop('disabled', false);
                    }

                } catch (error) {
                    console.error('Error: ', error)
                }
            };
            $('#auth-form').submit(function(event) {
                event.preventDefault();
                authUser.call(this)
            })
        }
        //     $('.reg-window .confirm').prop('disabled', true);
        //     event.preventDefault();
        //     let formData = new FormData(this);
        //     console.log(formData);

    //     fetch('reg.php', {
    //             method: 'POST',
    //             body: formData
    //         })
    //         .then(response => response.json())
    //         .then(data => {
    //             if (data.success) {
    //                 console.log(data.message);

    //             } else {
    //                 console.log('Error: ', data.message);
    //                 $('.flash-message').text(data.message).show();
    //             }
    //         })
    //         .catch(error => console.error('Global error: ', error))
    //         .finally(() => {
    //             $('.reg-window .confirm').prop('disabled', false);
    //         });
    // ;



    initialize() {
        this.toggleView();
        this.setupRegisterHandler();
        this.setupLoginHandler();
    }
}
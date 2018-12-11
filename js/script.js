const BASE_LINK = 'http://localhost/himsandhers/';

$(window).on('load', () => {
    $('#loginForm').submit(function(event){
        event.preventDefault();
        const data = {
            email: event.target[0].value,
            password: event.target[1].value
        }
        console.log(data);
        loginUser(data).then(data => {
            localStorage.setItem('user', data['id']);
            window.location = './index.html';
        }).catch(err => {
            $('#loginForm').find('#error').html('incorrect email or password');
        });
    });
    $('#registerForm').submit((event) => {
        event.preventDefault();
        console.log(event.target[4].value, event.target[5].value)
        if(event.target[4].value === event.target[5].value) {
            $('#registerForm').find('#error').html('');
            const data = {
                email: event.target[2].value,
                first_name: event.target[0].value,
                last_name: event.target[1].value,
                password: event.target[4].value,
                phone: event.target[3].value,
                gender: event.target[6].value
            }

            console.log(JSON.stringify(data));

            createUser(data).then(res => {
                console.log(res);
            }).catch(err => {
                console.log(err);
                $('#registerForm').find('#error').html('passwords do not match');
            });
        } else {
            $('#registerForm').find('#error').html('passwords do not match');
            return;
        }
        
    });
});

async function loginUser(data){
    return await fetch(
        `${BASE_LINK}member/getMember.php?email=${data.email}&password=${data.password}`
    ).then(data => data.json());
}

async function createUser(data){
    return await fetch(
        `${BASE_LINK}member/createMember.php`,
        {
            method: 'POST',
            mode: "cors", // no-cors, cors, *same-origin
            credentials: "same-origin",
            headers: {
                'Content-Type': 'application/json'
            },
            body: {
                "email": data.email,
                "first_name": data.first_name,
                "last_name": data.last_name,
                "password": data.password,
                "phone": data.phone,
                "gender": data.gender
            }
        }
    ).then(data => {data.text().then(dat => console.log(dat)); return Promise.resolve('test')});
}
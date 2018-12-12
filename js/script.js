const BASE_LINK = './php/';

$(window).on('load', () => {
  const user_id = localStorage.getItem('user');
  let user = null;

  $('#alert').hide();


  $('#book').click((e) => {
    e.preventDefault();
    if(user_id){
      window.location = './appointment.html';
    }else{
      window.location = './login.html';
    }
  });
  $('#profile').click(e => {
    e.preventDefault();
    if(user_id){
      window.location = './profile.html';
    }else{
      window.location = './login.html';
    }
  });

  $('#loginForm').submit(function(event){
      event.preventDefault();
      const data = {
          email: event.target[0].value,
          password: event.target[1].value
      };
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

      if(event.target[4].value === event.target[5].value) {
          $('#registerForm').find('#error').html('');
          const data = {
              email: event.target[2].value,
              first_name: event.target[0].value,
              last_name: event.target[1].value,
              password: event.target[4].value,
              phone: event.target[3].value,
              gender: event.target[6].value
          };

          createUser(data).then(res => {
            console.log(res);
            if(res === 'success'){
              console.log('success data');
              $('#alert').show();
              $('#alert').animate({'top': '100px'}, 1000);
              setTimeout(() => {
                window.location = './index.html'
              }, 1000);
            }else{
              console.log('failed');
              $('#registerForm').find('#error').html(res);
            }
          });
      } else {
          $('#registerForm').find('#error').html('passwords do not match');
      }

  });

  if([
        '/appointment.html',
        '/profile.html'
    ].includes(window.location.pathname) &&
        !user_id
    ){
      window.location = './index.html';
    }

  if(user_id) {
        console.log(user_id);
        getUser(user_id).then(data => {
          user = data;
          if(window.location.pathname === '/profile.html') {
            setupProfileForm(user);
          }
        });
      }

  $('#profileForm').submit((event) => {
    event.preventDefault();
    let new_user = {};
    Object.keys(user).forEach(key => {
      const cur_val = $(`input[name=${key}]`).val();

    })
  })

});

const setupProfileForm = (user) => {
  $("input[name='first_name']").attr('placeholder', user.first_name);
  $("input[name='last_name']").attr('placeholder', user.last_name);
  $("input[name='email']").attr('placeholder', user.email);
  $("input[name='phone']").attr('placeholder', user.phone);
  $("input[name='address']").attr('placeholder', user.address);
  $(`select option[value=${user.gender}]`).attr('selected', true);
};

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
            body: JSON.stringify(data)
        }
    ).then(data => data.text());
}

async function updateUser(data){
  var form = new FormData();
  Object.keys(data).forEach(key => {
    form.append(key,data[key]);
  });

  var settings = {
    "url": "./php/member/updateMember.php",
    "method": "POST",
    "timeout": 0,
    "processData": false,
    "mimeType": "multipart/form-data",
    "contentType": false,
    "data": form
  };
  $.ajax(settings).done(function (response) {
    console.log(response);
  });
}

async function getUser(id){
  return fetch(
    './php/member/getMember.php?id='+id
  ).then(data => data.json());
}

async function getAppointments(){

}

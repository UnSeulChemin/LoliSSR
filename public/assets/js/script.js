
// REGISTER, CONFIRM PASSWORD */

$("#register").on('submit', function()
{
    var plainPassword = $("#registration_form_plainPassword").val();
    var verifPass = $("#verif_pass").val();

    if (plainPassword != verifPass)
    {
        $("#register_flash").css('display', 'none');

        $('.pass-verif').css('display', 'block');
        $('.pass-verif-msg').html('Password doesn\'t match.');

        return false;
    }

    else
    {
        $("#register_flash").css('display', 'block');

        return true;
    }
})

// CHANGE PASSWORD, CONFIRM PASSWORD */

$("#profil_password").on('submit', function()
{
    var plainPassword = $("#change_password_form_plainPassword").val();
    var verifPass = $("#verif_pass").val();

    if (plainPassword != verifPass)
    {
        $("#profil_password_flash").css('display', 'none');

        $('.pass-verif').css('display', 'block');
        $('.pass-verif-msg').html('Password doesn\'t match.');

        return false;
    }

    else
    {
        $("#profil_password_flash").css('display', 'block');

        return true;
    }
})

// RESET PASSWORD, CONFIRM PASSWORD */

$("#reset_password").on('submit', function()
{
    var plainPassword = $("#change_password_form_plainPassword").val();
    var verifPass = $("#verif_pass").val();

    if (plainPassword != verifPass)
    {
        $("#reset_password_flash").css('display', 'none');

        $('.pass-verif').css('display', 'block');
        $('.pass-verif-msg').html('Password doesn\'t match.');

        return false;
    }

    else
    {
        $("#reset_password_flash").css('display', 'block');

        return true;
    }
})

// THEME MODE

$(".dark-mode").click(function()
{
    const body = document.body;

    if(body.classList.contains('dark'))
    {
        body.classList.add('light')
        body.classList.remove('dark')
        localStorage.setItem("mode", "light");
    }
    
    else if(body.classList.contains('light'))
    {
        body.classList.add('dark')
        body.classList.remove('light')
        localStorage.setItem("mode", "dark");
    }
});

if (localStorage.getItem("mode") == "dark")
{
    const body = document.body;

    body.classList.add('dark')
    body.classList.remove('light')
}

else if (localStorage.getItem("mode") == "light")
{
    const body = document.body;

    body.classList.add('light')
    body.classList.remove('dark')
}
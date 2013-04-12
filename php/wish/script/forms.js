function formhash(form, password, new_password) {
    if (password.value) {
        addOrUpdateHiddenInput(form, "p", password.value)
    }
    if (new_password && new_password.value) {
        addOrUpdateHiddenInput(form, "new_p", new_password.value)
    }
    // Finally submit the form.
    if(form.checkValidity())
    {
        password && password.value = "";
        new_password && new_password.value = "";
        form.submit();
    }
}

function addOrUpdateHiddenInput(form, name, value)
{
    var input = document.getElementById(name);
    if(!input) {
        input = document.createElement("input");
        // Add the new element to our form.
        form.appendChild(input);
        input.name = name;
        input.id = name;
        input.type = "hidden"
    }
    input.value = hex_sha512(value);
}
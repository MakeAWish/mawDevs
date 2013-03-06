function formhash(form, password, new_password) {
   if(password.value)
   {
      // Create a new element input, this will be out hashed password field.
      var p = document.createElement("input");
      // Add the new element to our form.
      form.appendChild(p);
      p.name = "p";

      p.type = "hidden"
      p.value = hex_sha512(password.value);
      // Make sure the plaintext password doesn't get sent.
      password.value = "";
   }
   if(new_password && new_password.value){
      // Create a new element input, this will be out hashed password field.
      var new_p = document.createElement("input");
      // Add the new element to our form.
      form.appendChild(new_p);
      new_p.name = "new_p";

      new_p.type = "hidden"
      new_p.value = hex_sha512(new_password.value);
      // Make sure the plaintext password doesn't get sent.
      new_password.value = "";
   }
   // Finally submit the form.
   form.submit();
}
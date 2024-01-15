function validateForm(){
    var passwordValue = document.forms["form"]["password_value"].value;
    if(passwordValue.length < 4){
        alert("The password must contain at least 4 characters!");
        return false;
    }
}
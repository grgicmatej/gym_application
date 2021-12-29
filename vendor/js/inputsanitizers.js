// Input sanitizers start

// Variables start
var Users_Id = document.getElementById('Users_Id');
var Users_Name = document.getElementById('Users_Name');
var Users_Surname = document.getElementById('Users_Surname');
var Users_Email = document.getElementById('Users_Email');
var Users_Phone = document.getElementById('Users_Phone');
var Users_Address = document.getElementById('Users_Address');
var Users_City = document.getElementById('Users_City');
var Users_Oib = document.getElementById('Users_Oib');
var Users_Birthday = document.getElementById('Users_Birthday');
var Users_Gender = document.getElementById('Users_Gender');
var Users_Status = document.getElementById('Users_Status');
var Users_Reference = document.getElementById('Users_Reference');

var Staff_Password = document.getElementById('Staff_Password');
var Staff_New_Password = document.getElementById('Staff_New_Password');
var Staff_Oib = document.getElementById('Staff_Oib');
var Staff_Phone = document.getElementById('Staff_Phone');
var Staff_Email = document.getElementById('Staff_Email');

var numbers = /[1234567890]/;
var letters = /[abcćčdđefghijklmnoprsštuvwzžxy]/;
var specialCharacters = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
// Variables end

// Users_Id start
Users_Id.addEventListener('blur', function() {
    if (this.value.length > 2 && !letters.test(this.value) && !specialCharacters.test(this.value)) {
        $.ajax({
            type: 'post',
            url: urlAddress + 'User/checkUsersId/',
            data: $('#formformaNewUser').serialize(),
            success: function (response) {
                response = JSON.parse(response);
                if (response === false) {
                    warningNotification('Već postoji korisnik s tim ID brojem kartice.');
                    RemoveValidClass(Users_Id)
                    Users_Id.className += " is-warning";
                } else {
                    RemoveWarningClass(Users_Id)
                    Users_Id.className += " is-valid";
                }
            }});
    } else {
        RemoveValidClass(this)
        this.className += " is-warning";
    }
});
// Users_Id end

// Users_Name start
Users_Name.addEventListener('blur', function() {
    if (this.value.length > 2 && !numbers.test(this.value) && !specialCharacters.test(this.value)) {
        RemoveWarningClass(this)
        this.className += " is-valid";
    } else {
        RemoveValidClass(this)
        this.className += " is-warning";
    }
});
// Users_Name end

// Users_Surname start
Users_Surname.addEventListener('blur', function() {
    if (this.value.length > 2 && !numbers.test(this.value) && !specialCharacters.test(this.value)) {
        RemoveWarningClass(this)
        this.className += " is-valid";
    } else {
        RemoveValidClass(this)
        this.className += " is-warning";
    }
});
// Users_Surname end

// Users_Email start
Users_Email.addEventListener('blur', function() {
    if (this.value.length > 4 && this.value.includes('@') && !this.value.includes(' ')) {
        RemoveWarningClass(this)
        this.className += " is-valid";
    } else {
        RemoveValidClass(this)
        this.className += " is-warning";
    }
});
// Users_Email end

// Users_Phone start
Users_Phone.addEventListener('blur', function() {
    if (this.value.length > 7 && !letters.test(this.value) && !specialCharacters.test(this.value)) {
        RemoveWarningClass(this)
        this.className += " is-valid";
    } else {
        RemoveValidClass(this)
        this.className += " is-warning";
    }
});
// Users_Phone end

// Users_Address start
Users_Address.addEventListener('blur', function() {
    if (this.value.length < 3){
        RemoveValidClass(this)
        this.className += " is-warning";
    } else {
        RemoveWarningClass(this)
        this.className += " is-valid";
    }
});
// Users_Address end

// Users_City start
Users_City.addEventListener('blur', function() {
    if (this.value.length > 2 && !numbers.test(this.value) && !specialCharacters.test(this.value)) {
        RemoveWarningClass(this)
        this.className += " is-valid";
    } else {
        RemoveValidClass(this)
        this.className += " is-warning";
    }
});
// Users_City end

// Users_Oib start
Users_Oib.addEventListener('blur', function() {
    if (this.value.length === 11 && numbers.test(this.value) && !specialCharacters.test(this.value) && !letters.test(this.value)) {
        RemoveWarningClass(this)
        this.className += " is-valid";
    } else {
        RemoveValidClass(this)
        this.className += " is-warning";
    }
});
// Users_Oib end

// Users_Birthday start
Users_Birthday.addEventListener('blur', function() {
    if (this.value === '') {
        RemoveValidClass(this)
        this.className += " is-warning";
    } else {
        RemoveWarningClass(this)
        this.className += " is-valid";
    }
});
// Users_Birthday end

// Users_Gender start
Users_Gender.addEventListener('blur', function() {
    if (this.value === '') {
        RemoveValidClass(this)
        this.className += " is-warning";
    } else {
        RemoveWarningClass(this)
        this.className += " is-valid";
    }
});
// Users_Gender end

// Users_Status start
Users_Status.addEventListener('blur', function() {
    if (this.value === '') {
        RemoveValidClass(this)
        this.className += " is-warning";
    } else {
        RemoveWarningClass(this)
        this.className += " is-valid";
    }
});
// Users_Status end

// Users_Reference start
Users_Reference.addEventListener('blur', function() {
    if (this.value === '') {
        RemoveValidClass(this)
        this.className += " is-warning";
    } else {
        RemoveWarningClass(this)
        this.className += " is-valid";
    }
});
// Users_Reference end

////// Staff form

// Staff_Password start
Staff_Password.addEventListener('blur', function() {
    if (this.value.length > 2 && !specialCharacters.test(this.value)) {
        $.ajax({
            type: 'post',
            url: urlAddress + 'Staff/passwordChecker/',
            data: $('#formformaStaffSettingsPassword').serialize(),
            success: function (response) {
                response = JSON.parse(response);
                if (response === false) {
                    warningNotification('Trenutna lozinka nije točna. Pokušajte ponovo.');
                    RemoveValidClass(Staff_Password)
                    Staff_Password.className += " is-warning";
                } else {
                    RemoveWarningClass(Staff_Password)
                    Staff_Password.className += " is-valid";
                }
            }
        });
    } else {
        RemoveValidClass(this)
        this.className += " is-warning";
    }
});
// Staff_Password end

// Staff_New_Password start
Staff_New_Password.addEventListener('blur', function() {
    if (this.value !== '' && this.value.length > 5 && !specialCharacters.test(this.value)) {
        RemoveWarningClass(this)
        this.className += " is-valid";
    } else {
        RemoveValidClass(this)
        this.className += " is-warning";
    }
});
// Staff_New_Password end

// Staff_Oib start
Staff_Oib.addEventListener('blur', function() {
    if (this.value.length === 11 && numbers.test(this.value) && !specialCharacters.test(this.value) && !letters.test(this.value)) {
        RemoveWarningClass(this)
        this.className += " is-valid";
    } else {
        RemoveValidClass(this)
        this.className += " is-warning";
    }
});
// Staff_Oib end

// Staff_Email start
Staff_Email.addEventListener('blur', function() {
    if (this.value.length > 4 && this.value.includes('@') && !this.value.includes(' ')) {
        RemoveWarningClass(this)
        this.className += " is-valid";
    } else {
        RemoveValidClass(this)
        this.className += " is-warning";
    }
});
// Staff_Email end

// Staff_Phone start
Staff_Phone.addEventListener('blur', function() {
    if (this.value.length > 7 && !letters.test(this.value) && !specialCharacters.test(this.value)) {
        RemoveWarningClass(this)
        this.className += " is-valid";
    } else {
        RemoveValidClass(this)
        this.className += " is-warning";
    }
});
// Staff_Phone end

function RemoveValidClass(elem) {
    elem.className = elem.className.replace(/(?:^|\s)is-valid(?!\S)/g, '')
}
function RemoveWarningClass(elem) {
    elem.className = elem.className.replace(/(?:^|\s)is-warning(?!\S)/g, '')
}

function RemoveClass(elem) {
    elem.className = elem.className.replace(/(?:^|\s)is-valid(?!\S)/g, '')
    elem.className = elem.className.replace(/(?:^|\s)is-warning(?!\S)/g, '')
}
// Input sanitizers end
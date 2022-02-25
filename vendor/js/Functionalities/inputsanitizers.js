// Input sanitizers start

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

Users_Name.addEventListener('blur', function() {
    checkNameValue(this);
});

Users_Surname.addEventListener('blur', function() {
    checkNameValue(this);
});

Users_Email.addEventListener('blur', function() {
    checkEmailValue(this)
});

Users_Phone.addEventListener('blur', function() {
    checkPhoneValue(this)
});

Users_Address.addEventListener('blur', function() {
    checkForLength(this, 3);
});

Users_City.addEventListener('blur', function() {
    checkNameValue(this)
});

Users_Oib.addEventListener('blur', function() {
    checkOibValue(this)
});

Users_Birthday.addEventListener('blur', function() {
    checkForEmptyData(this);
});

Users_Gender.addEventListener('blur', function() {
    checkForEmptyData(this);
});

Users_Status.addEventListener('blur', function() {
    checkForEmptyData(this);
});

Users_Reference.addEventListener('blur', function() {
    checkForEmptyData(this);
});

////// Staff form

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

Staff_New_Password.addEventListener('blur', function() {
    if (this.value !== '' && this.value.length > 5 && !specialCharacters.test(this.value)) {
        RemoveWarningClass(this)
        this.className += " is-valid";
    } else {
        RemoveValidClass(this)
        this.className += " is-warning";
    }
});

Staff_Oib.addEventListener('blur', function() {
    checkOibValue(this)
});

Staff_Email.addEventListener('blur', function() {
    checkEmailValue(this)
});

Staff_Phone.addEventListener('blur', function() {
    checkPhoneValue(this)
});

function checkForEmptyData(dataId){
    if (dataId.value === '') {
        RemoveValidClass(dataId)
        dataId.className += " is-warning";
    } else {
        RemoveWarningClass(dataId)
        dataId.className += " is-valid";
    }
}

function checkForLength(dataId, dataLength){
    if (dataId.value.length < dataLength){
        RemoveValidClass(dataId)
        dataId.className += " is-warning";
    } else {
        RemoveWarningClass(dataId)
        dataId.className += " is-valid";
    }
}

function checkNameValue(dataId){
    if (dataId.value.length > 2 && !numbers.test(dataId.value) && !specialCharacters.test(dataId.value)) {
        RemoveWarningClass(dataId)
        dataId.className += " is-valid";
    } else {
        RemoveValidClass(dataId)
        dataId.className += " is-warning";
    }
}

function checkEmailValue(dataId){
    if (dataId.value.length > 4 && dataId.value.includes('@') && !dataId.value.includes(' ')) {
        RemoveWarningClass(dataId)
        dataId.className += " is-valid";
    } else {
        RemoveValidClass(dataId)
        dataId.className += " is-warning";
    }
}

function checkPhoneValue(dataId){
    if (dataId.value.length > 7 && !letters.test(dataId.value) && !specialCharacters.test(dataId.value)) {
        RemoveWarningClass(dataId)
        dataId.className += " is-valid";
    } else {
        RemoveValidClass(dataId)
        dataId.className += " is-warning";
    }
}

function checkOibValue(dataId){
    if (dataId.value.length === 11 && numbers.test(dataId.value) && !specialCharacters.test(dataId.value) && !letters.test(dataId.value)) {
        RemoveWarningClass(dataId)
        dataId.className += " is-valid";
    } else {
        RemoveValidClass(dataId)
        dataId.className += " is-warning";
    }
}

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


// Clear input start
function clearInput(time) {
    setTimeout(function (){
        let elementsId= [
            "Users_Id", "Users_Name", "Users_Surname", "Users_Email", "Users_Phone", "Users_Address", "Users_City",
            "Users_Oib", "Users_Birthday", "Users_Gender", "Users_Status", "Users_Reference", "Users_Company",
            "Staff_Password", "Staff_New_Password", "Staff_Oib", "Staff_Phone", "Staff_Email",
            "Event_Contact_Name_New", "Event_Contact_Phone_New", "Event_Start_Time_New", "Event_End_Time_New"
        ];

        elementsId.forEach((element) => {
            RemoveClass(document.getElementById(element))
            if (element === 'Staff_Oib' || element === 'Staff_Phone' || element === 'Staff_Email' || element === 'Users_Gender' || element === 'Users_Status' || element === 'Users_Reference'){
                return
            }else {
                document.getElementById(element).value = '';
            }
        });
    }, time);
}
// Clear input end

// Date and time formating start
function formatDate(input) {
    var datePart = input.match(/\d+/g),
        year = datePart[0],
        month = datePart[1],
        day = datePart[2];
    return day + '.' + month + '.' + year + '.';
}

function formatDateWithLine(input) {
    var datePart = input.match(/\d+/g),
        year = datePart[0],
        month = datePart[1],
        day = datePart[2];
    return year + '-' + month + '-' + day;
}

function formatTime(input){
    var timePart = input.match(/\d+/g),
        hour = timePart[3],
        minute = timePart[4],
        second = timePart[5];
    return hour + ':' + minute + ':' + second;
}
// Date and time formating end
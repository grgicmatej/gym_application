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
var tempTrainingCheckbox = document.getElementById('tempTrainingCheckbox');

var Edit_Users_Id = document.getElementById('Edit_Users_Id');
var Edit_Users_Name = document.getElementById('Edit_Users_Name');
var Edit_Users_Surname = document.getElementById('Edit_Users_Surname');
var Edit_Users_Email = document.getElementById('Edit_Users_Email');
var Edit_Users_Phone = document.getElementById('Edit_Users_Phone');
var Edit_Users_Address = document.getElementById('Edit_Users_Address');
var Edit_Users_City = document.getElementById('Edit_Users_City');
var Edit_Users_Oib = document.getElementById('Edit_Users_Oib');
var Edit_Users_Birthday = document.getElementById('Edit_Users_Birthday');
var Edit_Users_Gender = document.getElementById('Edit_Users_Gender');
var Edit_Users_Status = document.getElementById('Edit_Users_Status');
var Edit_Users_Reference = document.getElementById('Edit_Users_Reference');
var Edit_Users_Company = document.getElementById('Edit_Users_Company');

var Edit_Users_Memberships_Membership_Name = document.getElementById('Edit_Users_Memberships_Membership_Name');
var Edit_Users_Memberships_Price = document.getElementById('Edit_Users_Memberships_Price');
var Edit_Users_Memberships_Start_Date = document.getElementById('Edit_Users_Memberships_Start_Date');
var Edit_Users_Memberships_End_Date = document.getElementById('Edit_Users_Memberships_End_Date');

var Staff_Password = document.getElementById('Staff_Password');
var Staff_New_Password = document.getElementById('Staff_New_Password');
var Staff_Oib = document.getElementById('Staff_Oib');
var Staff_Phone = document.getElementById('Staff_Phone');
var Staff_Email = document.getElementById('Staff_Email');

var Edit_Staff_Name = document.getElementById('Edit_Staff_Name');
var Edit_Staff_Surname = document.getElementById('Edit_Staff_Surname');
var Edit_Staff_Username = document.getElementById('Edit_Staff_Username');
var Edit_Staff_Oib = document.getElementById('Edit_Staff_Oib');
var Edit_Staff_Phone = document.getElementById('Edit_Staff_Phone');
var Edit_Staff_Email = document.getElementById('Edit_Staff_Email');

var New_Staff_Name = document.getElementById('New_Staff_Name');
var New_Staff_Surname = document.getElementById('New_Staff_Surname');
var New_Staff_Password = document.getElementById('New_Staff_Password');
var New_Staff_Username = document.getElementById('New_Staff_Username');
var New_Staff_Oib = document.getElementById('New_Staff_Oib');
var New_Staff_Phone = document.getElementById('New_Staff_Phone');
var New_Staff_Email = document.getElementById('New_Staff_Email');

var Event_Contact_Name_New = document.getElementById('Event_Contact_Name_New');
var Event_Contact_Phone_New = document.getElementById('Event_Contact_Phone_New');
var Event_Start_Time_New = document.getElementById('Event_Start_Time_New');
var Event_End_Time_New = document.getElementById('Event_End_Time_New');

var Event_Contact_Name_Edit = document.getElementById('Event_Contact_Name_Edit');
var Event_Contact_Phone_Edit = document.getElementById('Event_Contact_Phone_Edit');
var Event_Start_Time_Edit = document.getElementById('Event_Start_Time_Edit');
var Event_End_Time_Edit = document.getElementById('Event_End_Time_Edit');

var New_Memberships_Name = document.getElementById('New_Memberships_Name');
var New_Memberships_Price = document.getElementById('New_Memberships_Price');
var New_Memberships_Duration = document.getElementById('New_Memberships_Duration');
var Edit_Memberships_Name = document.getElementById('Edit_Memberships_Name');
var Edit_Memberships_Price = document.getElementById('Edit_Memberships_Price');
var Edit_Memberships_Duration = document.getElementById('Edit_Memberships_Duration');

var Edit_Warehouse_Item_Name = document.getElementById('Edit_Warehouse_Item_Name');
var Edit_Warehouse_Item_Price = document.getElementById('Edit_Warehouse_Item_Price');
var Edit_Warehouse_Item_Count = document.getElementById('Edit_Warehouse_Item_Count');


var numbers = /[1234567890]/;
var letters = /[abcćčdđefghijklmnoprsštuvwzžxy]/;
var specialCharacters = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;

///// New user input sanitizers
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

Users_Id.addEventListener('input', function() {
    if (this.value !== '')
    {
        document.getElementById('probniTrening').style.display = 'none';
    }else {
        document.getElementById('probniTrening').style.display = 'block';

    }
});

tempTrainingCheckbox.addEventListener('input', function() {
    if (Users_Id.disabled === false)
    {
        Users_Id.disabled = true
    }else {
        Users_Id.disabled = false
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

///// Edit user input sanitizers
Edit_Users_Id.addEventListener('blur', function() {
    if (this.value.length > 2 && !letters.test(this.value) && !specialCharacters.test(this.value) ) {
        $.ajax({
            type: 'post',
            url: urlAddress + 'User/checkUsersId/',
            data: $('#formformaEditUser').serialize(),
            success: function (response) {
                response = JSON.parse(response);
                if (response === false && (Edit_Users_Id.value !== globalVariable.split('-').pop())) {
                    warningNotification('Već postoji korisnik s tim ID brojem kartice.');
                    RemoveValidClass(Edit_Users_Id)
                    Edit_Users_Id.className += " is-warning";
                } else {
                    RemoveWarningClass(Edit_Users_Id)
                    Edit_Users_Id.className += " is-valid";
                }
            }});
    } else {
        RemoveValidClass(this)
        this.className += " is-warning";
    }
});

Edit_Users_Name.addEventListener('blur', function() {
    checkNameValue(this);
});

Edit_Users_Surname.addEventListener('blur', function() {
    checkNameValue(this);
});

Edit_Users_Email.addEventListener('blur', function() {
    checkEmailValue(this)
});

Edit_Users_Phone.addEventListener('blur', function() {
    checkPhoneValue(this)
});

Edit_Users_Address.addEventListener('blur', function() {
    checkForLength(this, 3);
});

Edit_Users_City.addEventListener('blur', function() {
    checkNameValue(this)
});

Edit_Users_Oib.addEventListener('blur', function() {
    checkOibValue(this)
});

Edit_Users_Birthday.addEventListener('blur', function() {
    checkForEmptyData(this);
});

Edit_Users_Gender.addEventListener('blur', function() {
    checkForEmptyData(this);
});

Edit_Users_Status.addEventListener('blur', function() {
    checkForEmptyData(this);
});

Edit_Users_Reference.addEventListener('blur', function() {
    checkForEmptyData(this);
});

// edit existing membership
Edit_Users_Memberships_Membership_Name.addEventListener('blur', function() {
    checkNameValue(this);
});

Edit_Users_Memberships_Price.addEventListener('blur', function() {
    checkForEmptyData(this);
});

Edit_Users_Memberships_Start_Date.addEventListener('blur', function() {
    checkForEmptyData(this);
});

Edit_Users_Memberships_End_Date.addEventListener('blur', function() {
    checkForEmptyData(this);
});

///// Staff input sanitizers

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

// prep za input sanitizer
/*
Users_Id_Edit.addEventListener('blur', function() {
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
*/

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

// edit existing staff
Edit_Staff_Name.addEventListener('blur', function() {
        checkNameValue(this);
    });

Edit_Staff_Surname.addEventListener('blur', function() {
    checkNameValue(this);
});

Edit_Staff_Email.addEventListener('blur', function() {
    checkEmailValue(this)
});

Edit_Staff_Phone.addEventListener('blur', function() {
    checkPhoneValue(this)
});

Edit_Staff_Oib.addEventListener('blur', function() {
    checkOibValue(this)
});

Edit_Staff_Username.addEventListener('blur', function() {
    if (this.value.length > 3) {
        $.ajax({
            type: 'post',
            url: urlAddress + 'Staff/staffInfo/'+globalVariableStaff,
            success: function (response) {
                response = JSON.parse(response);
                if (Edit_Staff_Username.value !== response['Staff_Username']) {
                    $.ajax({
                        type: 'post',
                        url: urlAddress + 'Staff/checkStaffUsername/',
                        data: {Staff_Username: Edit_Staff_Username.value},
                        success: function (response) {
                            response = JSON.parse(response);
                            if (response === 1) {
                                warningNotification('Korisničko ime zaposlenika već postoji. Pokušajte ponovo.');
                                RemoveValidClass(Edit_Staff_Username)
                                Edit_Staff_Username.className += " is-warning";
                            } else {
                                RemoveWarningClass(Edit_Staff_Username)
                                Edit_Staff_Username.className += " is-valid";
                            }
                        }
                    });
                }else {
                    RemoveWarningClass(Edit_Staff_Username)
                    Edit_Staff_Username.className += " is-valid";
                }
            }});
    } else {
        RemoveValidClass(this)
        this.className += " is-warning";
    }
});

// new staff
New_Staff_Name.addEventListener('blur', function() {
    checkNameValue(this);
});

New_Staff_Surname.addEventListener('blur', function() {
    checkNameValue(this);
});

New_Staff_Password.addEventListener('blur', function() {
    if (this.value.length > 5 && !specialCharacters.test(this.value)) {
        RemoveWarningClass(this)
        this.className += " is-valid";
    } else {
        RemoveValidClass(this)
        this.className += " is-warning";
    }
});

New_Staff_Email.addEventListener('blur', function() {
    checkEmailValue(this)
});

New_Staff_Phone.addEventListener('blur', function() {
    checkPhoneValue(this)
});

New_Staff_Oib.addEventListener('blur', function() {
    checkOibValue(this)
});

New_Staff_Username.addEventListener('blur', function() {
    if (this.value.length > 3) {
        $.ajax({
            type: 'post',
            url: urlAddress + 'Staff/checkStaffUsername/',
            data: {Staff_Username: New_Staff_Username.value},
            success: function (response) {
                response = JSON.parse(response);
                if (response === 1) {
                    warningNotification('Korisničko ime zaposlenika već postoji. Pokušajte ponovo.');
                    RemoveValidClass(New_Staff_Username)
                    New_Staff_Username.className += " is-warning";
                } else {
                    RemoveWarningClass(New_Staff_Username)
                    New_Staff_Username.className += " is-valid";
                }
            }
        });
    } else {
        RemoveValidClass(this)
        this.className += " is-warning";
    }
});

// event sanitizers

Event_Contact_Name_New.addEventListener('blur', function() {
    checkNameValue(this);
});

Event_Contact_Phone_New.addEventListener('blur', function() {
    checkNameValue(this);
});

Event_Start_Time_New.addEventListener('blur', function() {
    checkForEmptyData(this);
});

Event_End_Time_New.addEventListener('blur', function() {
    checkForDates(Event_Start_Time_New, Event_End_Time_New);
});

// edit event

Event_Contact_Name_Edit.addEventListener('blur', function() {
    checkNameValue(this);
});

Event_Contact_Phone_Edit.addEventListener('blur', function() {
    checkNameValue(this);
});

Event_Start_Time_Edit.addEventListener('blur', function() {
    checkForEmptyData(this);
});

Event_End_Time_Edit.addEventListener('blur', function() {
    checkForDates(Event_Start_Time_Edit, Event_End_Time_Edit);
});

// membership sanitizers
New_Memberships_Name.addEventListener('blur', function() {
    checkForEmptyData(this);
});

Edit_Memberships_Name.addEventListener('blur', function() {
    checkForEmptyData(this);
});

New_Memberships_Price.addEventListener('blur', function() {
    checkForEmptyData(this);
});

Edit_Memberships_Price.addEventListener('blur', function() {
    checkForEmptyData(this);
});

New_Memberships_Duration.addEventListener('blur', function() {
    checkForEmptyData(this);
});

Edit_Memberships_Duration.addEventListener('blur', function() {
    checkForEmptyData(this);
});

// warehouse sanitizers
Edit_Warehouse_Item_Name.addEventListener('blur', function() {
    checkForEmptyData(this);
});
// tu sam stao
var Edit_Warehouse_Item_Name = document.getElementById('Edit_Warehouse_Item_Name');
var Edit_Warehouse_Item_Price = document.getElementById('Edit_Warehouse_Item_Price');
var Edit_Warehouse_Item_Count = document.getElementById('Edit_Warehouse_Item_Count');





function checkForEmptyData(dataId){
    if (dataId.value === '') {
        RemoveValidClass(dataId)
        dataId.className += " is-warning";
    } else {
        RemoveWarningClass(dataId)
        dataId.className += " is-valid";
    }
}

function checkForDates(dateStart, dateEnd)
{
    let date1 = new Date(dateStart.value);
    let date2 = new Date(dateEnd.value);
    if (date1.getTime() > date2.getTime()){
        warningNotification('Datum završetka ne smije biti prije datuma početka.')
        RemoveValidClass(dateEnd);
        dateEnd.className += " is-warning";
        return false;
    }else{
        RemoveWarningClass(dateEnd)
        dateEnd.className += " is-valid";
        return true;
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
function clearInput(time, formId) {
    setTimeout(function (){
        document.getElementById(formId).reset();
        let elementsId= [
            "Users_Id", "Users_Name", "Users_Surname", "Users_Email", "Users_Phone", "Users_Address", "Users_City",
            "Users_Oib", "Users_Birthday", "Users_Gender", "Users_Status", "Users_Reference", "Users_Company",
            "Staff_Password", "Staff_New_Password", "Staff_Oib", "Staff_Phone", "Staff_Email",
            "Event_Contact_Name_New", "Event_Contact_Phone_New", "Event_Start_Time_New", "Event_End_Time_New",
            "Edit_Users_Id", "Edit_Users_Name", "Edit_Users_Surname", "Edit_Users_Email", "Edit_Users_Phone", "Edit_Users_Address",
            "Edit_Users_City", "Edit_Users_Oib", "Edit_Users_Birthday", "Edit_Users_Gender", "Edit_Users_Status", "Edit_Users_Reference", "Edit_Users_Company",
            'Edit_Users_Memberships_Membership_Name', 'Edit_Users_Memberships_Price','Edit_Users_Memberships_Start_Date','Edit_Users_Memberships_End_Date'
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

// fadeIn fadeOut optimizing start
function fadeIn(elementId)
{
    $(elementId).fadeIn(400, function () {
        $(this).modal('show');
    });
}
function fadeOut(elementId)
{
    $(elementId).fadeOut(400, function () {
        $(this).modal('hide');
    });
}
// fadeIn fadeOut optimizing end

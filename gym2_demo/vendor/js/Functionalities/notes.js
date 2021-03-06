$('.notes').on('click', function () {
    fadeIn("#notesModal");
    $.ajax({
        url: urlAddress + 'Notes/checkStaffNotes/',
        method: "POST",
        success: function (data) {
            data = JSON.parse(data);
            const searchData = document.getElementById('BodyNotesData');

            searchData.innerHTML = data.reduce((options, {Notes_Id, Notes_Note, Notes_Date, Staff_Name, Staff_Surname}) =>
                    options += `
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="timeline">
                                            <div>
                                                <i class="fas fa-envelope bg-blue"></i>
                                                <div class="timeline-item">
                                                    <span class="time"><i class="fas fa-clock"></i> ${formatTime(Notes_Date)} - ${formatDate(Notes_Date)}</span>
                                                    <h3 class="timeline-header"><p class="authorStyle"><b>${Staff_Name} ${Staff_Surname}</b></p></h3>
                
                                                    <div class="timeline-body">
                                                       ${Notes_Note}
                                                    </div>
                                                    <div class="timeline-footer">
                                                    
                                                        <div class="row">
                                                            <div class="col-12 col-lg-3"><p class="m-b-10 f-w-600 btn btn-block btn-outline-info editStaffNote" id="i_${Notes_Id}">Uređivanje bilješke</p></div>
                                                            <div class="col-12 col-lg-3"><p class="m-b-10 f-w-600 btn btn-block btn-outline-danger deleteStaffNote" id="i_${Notes_Id}">Brisanje bilješke</p></div>
                                                        </div>
                                                         
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                `,
                ``);
        }
    });
});
// new note modal start
$('.createNewNote').on('click', function () {
    fadeOut("#notesModal");
    fadeIn("#newStaffNote")
});

$('.newNoteFormCancel').on('click', function () {
    fadeOut("#newStaffNote");
});

// new note form start
$('#newNoteForm').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        type: "post",
        url: urlAddress + 'Notes/newNote/',
        data: $('#newNoteForm').serialize(),
        success: function () {
            fadeOut("#newStaffNote");
            successNotification('Bilješka je uspješno spremljena.');
            clearInput(1000, 'newNoteForm')
        },
        error: function (){
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
            fadeOut('#newStaffNote')
        }
    });
});
// new note form end

// notes item delete start
$(document).ajaxComplete(function () {
    $('.deleteStaffNote').on('click', function () {
        var id = $(this).attr('id');
        globalVariableNoteId = id.split('_')[1]
        fadeOut("#notesModal")
        fadeIn("#deleteNotes")
    });
});

$('.cancelNotesDeleteButton').on('click', function () {
    fadeOut("#deleteNotes")
});

$('.editNoteFormCancel').on('click', function () {
    fadeOut("#editStaffNote")
});

$('.confirmNotesDeleteButton').on('click', function () {
    $.ajax({
        method: "POST",
        data: {notesId: globalVariableNoteId},
        url: urlAddress + 'notes/deleteNote',
        success: function () {
            fadeOut("#deleteNotes")
            successNotification('Bilješka je uspješno obrisana.');
        },
        error: function (){
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
        }
    });
});
// notes item delete end

// edit note form start
$(document).ajaxComplete(function () {
    $('.editStaffNote').on('click', function () {
        var id = $(this).attr('id');
        globalVariableNoteId = id.split('_')[1]

        $.ajax({
            method: "POST",
            data: {Notes_Id: globalVariableNoteId},
            url: urlAddress + 'notes/checkNote',
            success: function (response) {
                fadeOut("#notesModal")
                fadeIn("#editStaffNote")
                response = JSON.parse(response)
                document.getElementById("Edit_Notes_Note").value = response["Notes_Note"];

            },
            error: function (){
                warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
            }
        });
    });
});

$('#editNoteForm').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        type: "post",
        url: urlAddress + 'Notes/editNote/' + globalVariableNoteId,
        data: $('#editNoteForm').serialize(),
        success: function () {
            fadeOut("#editStaffNote");
            successNotification('Bilješka je uspješno spremljena.');
            clearInput(1000, 'editNoteForm')
        },
        error: function (){
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
            fadeOut('#editStaffNote')
        }
    });
});
// edit note form end

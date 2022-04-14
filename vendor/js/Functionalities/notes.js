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
                                                            <div class="col-12 col-lg-3"><a class="m-b-10 f-w-600 btn btn-block btn-outline-info editStaffNote" id="${Notes_Id}">Uređivanje bilješke</a></div>
                                                            <div class="col-12 col-lg-3"><a class="m-b-10 f-w-600 btn btn-block btn-outline-danger deleteStaffNote" id="${Notes_Id}">Brisanje bilješke</a></div>
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
// warehouse item form end
// new note modal cancel

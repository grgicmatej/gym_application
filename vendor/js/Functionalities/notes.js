$('.notes').on('click', function () {
    fadeIn("#notesModal");
    $.ajax({
        url: urlAddress + 'Notes/allStaffNotes/',
        method: "POST",
        success: function (data) {
            document.getElementById("dt7").style.display = "block";
            data = JSON.parse(data);
            const searchData = document.getElementById('BodyNotesData');

            searchData.innerHTML = data.reduce((options, {Notes_Id, Notes_Note, Notes_Staff_Id, Notes_Date, Staff_Name, Staff_Surname}) =>
                    options += `
                            <div>
                                <i class="fas fa-sticky-note bg-blue"></i>
                                <div class="timeline-item">
                                    <span class="time"><i class="fas fa-clock"></i> ${formatTime(Notes_Date)} - ${formatDate(Notes_Date)}</span>
                                    <h3 class="timeline-header"><p class="authorStyle"><b>${Staff_Name} ${Staff_Surname}</b></p></h3>

                                    <div class="timeline-body">
                                        ${Notes_Note}
                                    </div>
                                    <div class="timeline-footer">
                                        <a class="btn btn-outline-primary btn-sm editNoteStaff" id="${Notes_Id}">Uređivanje bilješke</a>
                                        <a class="btn btn-outline-danger btn-sm deleteNoteStaff" id="${Notes_Id}">Brisanje brisanje</a>
                                    </div>
                                </div>
                            </div>
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                                `,
                ``);
        }
    });
});

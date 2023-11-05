/* 
* Indicates in the JS files where to present the libraries in the document.
* Important! indicate where to broadcast the head or footer, necessarily between the comments
*/
/*footer*/


function convertMinutesToHoursMinutes(minutes) {
    const hours = Math.floor(minutes / 60);
    const remainingMinutes = minutes % 60;
    if (hours > 0 && remainingMinutes > 0) {
        return `${hours} ${translations.hours} ${remainingMinutes} ${translations.minutes}`;
    } else if (hours > 0) {
        return `${hours} ${translations.hours}`;
    } else {
        return `${minutes} ${translations.minutes}`;
    }
}

function renderTimeOptions(timeOptions, eventDate, reserveDayOption, reserveDayTimeOption) {
    let optionsHTML = '';
    if (Array.isArray(reserveDayOption) && reserveDayOption.includes(eventDate)) {
        if (timeOptions.length === 0 ) {
            return `${translations.all_times_are_reserved}`;
        }
        Object.values(timeOptions).forEach(time => {
            optionsHTML += `
                ${time} <input type="checkbox" class="time-checkbox" name="" value="${time}"/>;  
            `;
        });
    } else {  
        Object.values(reserveDayTimeOption).forEach(time => {
            optionsHTML += `
                ${time} <input type="checkbox" class="time-checkbox" name="" value="${time}"/>;   
            `; 
        });
    }
    return optionsHTML;
}

$(document).on('change', '.time-checkbox', function() {
    $('.time-checkbox').not(this).prop('checked', false);
    $('.selected-time-input').val($(this).val());
});

function createEventModal(themeId, registrationAllowed, eventDate, eventTitle) {
    let accordionHTML = '';
    eventTopics.forEach(topic => {
        if (topic.theme_id === themeId) {
            const timeString = convertMinutesToHoursMinutes(topic.timeLimit);
            let reserveDayTimeOption = topic.reserveEventDay;
            let reserveDayOption = topic.reserveDay;
            let timeOptions = topic.provideTime;
            let timeOptionsHTML = renderTimeOptions(timeOptions, eventDate, reserveDayOption, reserveDayTimeOption);
            
            accordionHTML += `
                <button class="callendar-accordion accordion">${topic.title} <i class="fa fa-angle-down float-right"></i></button>
                <div class="panel">
                    <div class="flex-container">
                        <div class="flex-item-left">
                            <p><b>${translations.duration_time}:</b> ${timeString} <br><b>${translations.audience}:</b> ${topic.targetAudience} </p>
                        </div>
                        <div class="flex-item-right">
                        <p><b>${translations.available_times}: </b><br>
                        ${timeOptionsHTML}</p>
                    </div>
                    </div>
                    <img src="${topic.imageUrl}" class="accordion-event-image" alt="image">
                    <p>${topic.shortDescription} <br>
                    <b>${translations.methodical_material}:</b> <br>${topic.methodicalMaterial}</p>
                    <form action="registration-member.php" method="post">
                    <input type="hidden" name="event_laboratory_id" value="${topic.theme_id}">
                    <input type="hidden" name="event_item_id" value="${topic.id}">
                    <input type="hidden" name="event_item_title" value="${topic.title}">
                    <input type="hidden" name="event_laboratory_title" value="${eventTitle}">
                    <input type="hidden" name="event_reserve_day" value="${eventDate}">
                    <input type="hidden" name="event_target_audience" value="${topic.targetAudience}">
                    <input type="hidden" name="selectedTime" class="selected-time-input" value="">
                    <button type="submit" class="btn btn-primary registration-button"  style="display: none; margin-bottom: 10px">${translations.registration}</button>
                  </form>
                </div>`;
        }
    });
                
    const modalHTML = `
    <div id="eventModal" class="modal-view">
        <div class="modal-content">
            <span class="close-event" style="text-align: right;">&times;</span>
            <h3 id="eventTitle"></h3>
            <p id="themeId" style="display:none"></p>
            <p id="eventDate"></p>
            ${accordionHTML}
        </div>
    </div>`;

    document.body.insertAdjacentHTML('beforeend', modalHTML);

    const acc = document.getElementsByClassName("accordion");
    Array.from(acc).forEach((accordion) => {
        accordion.addEventListener("click", function(e) {
            if (!registrationAllowed) {
                return;
            }

            e.stopPropagation();
            let icon = this.querySelector('.fa');
            if (icon.classList.contains('fa-angle-down')) {
                icon.classList.remove('fa-angle-down');
                icon.classList.add('fa-angle-up');
            } else {
                icon.classList.remove('fa-angle-up');
                icon.classList.add('fa-angle-down');
            }  
            if (this.classList.contains('button-accordion-color-open')) {
                this.classList.remove('button-accordion-color-open');
                this.classList.add('button-accordion-color-closed');
            } else {
                this.classList.add('button-accordion-color-open');
                this.classList.remove('button-accordion-color-closed');
            }

            Array.from(acc).forEach((otherAccordion) => {
                if (otherAccordion !== this) {
                    let otherPanel = otherAccordion.nextElementSibling;
                    otherPanel.style.display = "none";
                    otherAccordion.classList.remove("active");
                }
            });

            this.classList.toggle("active");
            let panel = this.nextElementSibling;
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        });
    });
}

function closeEventModal() {
    const modal = document.getElementById("eventModal");
    if (modal) {
        modal.remove();
    }
}


function attachEventListeners() {
    $('.event-view').off('click').click(function(e) {
        e.stopImmediatePropagation();
        const eventData = {
            id: $(this).data('theme-id'),
            title: $(this).data('title'),
            date: $(this).data('date'),
            color: $(this).data('color')
        };
        const matchingTopic = eventTopics.find(topic => topic.theme_id === eventData.id);
        showEventModal(eventData, matchingTopic);
    });
}

function showEventModal(eventData,topic) {
    const currentDate = new Date();
    const eventDate = new Date(eventData.date);
    let registrationAllowed = true;

    const registrationEndDate = new Date(eventDate);
    let endRegister = topic ? topic.setRegistrationEndDate : 0;

    registrationEndDate.setDate(registrationEndDate.getDate() - endRegister);

    if (registrationEndDate <= currentDate) {
        eventData.title += `  <span class="span-title" style="color: #d55258;">(${translations.registration_has_ended})</span>`;
        registrationAllowed = false;
    }

    createEventModal(eventData.id, registrationAllowed, eventData.date, eventData.title);

    const modal = document.getElementById("eventModal");
    const closeBtn = document.getElementsByClassName("close-event")[0];
    const eventTitleElement = document.getElementById("eventTitle");
    const eventDateElement = document.getElementById("eventDate");
    const eventIdElement = document.getElementById("themeId");

    eventTitleElement.innerHTML = `${translations.location}: ` + eventData.title;
    eventDateElement.innerText = `${translations.date_chosen}: ` + eventData.date;
    eventIdElement.innerText = "" + eventData.id;

    modal.style.opacity = 0;
    modal.style.pointerEvents = "none";

    setTimeout(() => {
        modal.style.opacity = 1;
        modal.style.pointerEvents = "auto";
    }, 10);

    closeBtn.onclick = function() {
        closeEventModal();
    };

    window.onclick = function(event) {
        if (event.target === modal) {
            closeEventModal();
        }
    };
}


$(document).on('change', '.time-checkbox', function() {
    $('.time-checkbox').not(this).prop('checked', false);  
});



$(document).on('change', '.time-checkbox', function() {
    $('.time-checkbox').not(this).prop('checked', false);
    
    $('.selected-time-input').val($(this).val());

    if ($('.time-checkbox:checked').length > 0) {
        $('.registration-button').show();
    } else {
        $('.registration-button').hide();
    }
});

$(document).ready(function() {
    attachEventListeners();
    $('.calendar').click(function(e) {
        e.stopImmediatePropagation();
        $('#eventModal').hide();
        closeEventModal();
    });
});



function checkPasswordsMatch() {
    if (!isMemberLoggedIn) {
        var password = document.getElementById("member_password").value;
        var confirmPassword = document.getElementById("re_member_password").value;
        if (password !== confirmPassword) {
            alert("Passwords do not match.");
            return false;
        }
    }
    return true;
}

function checkUserExists() {
    return new Promise((resolve, reject) => {
        if (!isMemberLoggedIn) {
            var username = $("#member_login_name").val();
            var email = $("#member_email").val();
            $.ajax({
                url: "../../cover/addons/event_callendar/action/re_member.php",
                type: "POST",
                data: {
                    member_login_name: username,
                    member_email: email,
                    check_exist: true
                },
                success: function(response) {
                    if (response.trim() === 'exists') {
                        reject(new Error("Username or email already registered."));
                    } else {
                        resolve();
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    reject(new Error("An error occurred while checking user existence."));
                }
            });
        } else {
            resolve();
        }
    });
}



function submitForm() {
    $.ajax({
        url: "../../cover/addons/event_callendar/action/re_member.php",
        type: "POST",
        data: $("#registrationForm").serialize() + '&register=true', 
        success: function(response) {
            var trimmedResponse = response.trim();
            if (trimmedResponse === 'success') {
                window.location.href = "registration-member.php?message=success";
                
            } else if (trimmedResponse === 'exists') {
                alert('Username or email already registered.');
            } else {
                window.location.href = "registration-member.php?message=success";
              //  alert('nocheck email and user name, back to page .'); 
            }
        },
        
        error: function(xhr, textStatus, errorThrown) {
            alert('An error occurred during registration.');
        }
    });
}


$(document).ready(function() {
    $("#registrationForm").on("submit", function(event) {
        event.preventDefault();
        if (!checkPasswordsMatch(isMemberLoggedIn)) {
            return;
        }
        checkUserExists(isMemberLoggedIn).then(function() {
            submitForm();
        }).catch(function(error) {
            alert(error.message);
        });
    });



 $('#loginMemberForm').on('submit', function(e) {
    e.preventDefault();

    var loginName = $('input[name="member_login_name"]').val();
    var password = $('input[name="member_password"]').val();

    $.ajax({
        url: '../../cover/addons/event_callendar/action/re_member_login.php',
        type: 'POST',
        data: {
            member_login_name: loginName,
            member_password: password
        },
        success: function(response) {
            if (response === 'success') {
                window.location.href = '/event-calendar';
                location.reload();
            } else {
                alert(`${translations.invalid_login_data}`);
            }
        }
    });
});

$('#logoutBtn').on('click', function(e) {
    e.preventDefault();

    $.ajax({
        url: '../../cover/addons/event_callendar/action/logout.php',
        type: 'POST',
        success: function(response) {
            
            if (response === 'logged_out') {
                window.location.href = '/event-calendar';
            } else {
                alert('There was an error logging out. Please try again.');
            }
        }
    });
});

});


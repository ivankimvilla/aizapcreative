const modal = document.getElementById("bookingModal");

const modalClose = document.getElementById("bookingModalClose");

const modalSlotText = document.getElementById("modalSlotText");

const hiddenSlot = document.getElementById("hiddenSlot");

const timezoneField = document.getElementById("timezoneField");

const timezoneLabelField = document.getElementById("timezoneLabelField");

const timesDateEl = document.querySelector(".times-date");

const calendarGrid = document.querySelector(".calendar-grid");

const calendarMonthEl = document.querySelector(".calendar-month");

const timeButtons = Array.from(document.querySelectorAll(".time-slot"));

const prevMonthBtn = document.querySelectorAll(".calendar-nav")[0];

const nextMonthBtn = document.querySelectorAll(".calendar-nav")[1];

const timezoneDropdown = document.getElementById("timezoneDropdown");

const timezoneTrigger = document.getElementById("timezoneTrigger");

const timezoneTriggerLabel = document.getElementById("timezoneTriggerLabel");

const timezoneList = document.getElementById("timezoneList");

const timezoneOptions = Array.from(document.querySelectorAll(".calendar-tz__list li"));

function refreshTimezoneLabels() {
    timezoneOptions.forEach(option => {
        if (!option.dataset.value) {
            return;
        }
        const fullLabel = option.dataset.displayLabel || option.textContent.trim();
        option.textContent = fullLabel;
        if (option.getAttribute("aria-selected") === "true" && timezoneTriggerLabel) {
            timezoneTriggerLabel.textContent = fullLabel;
        }
    });
}

refreshTimezoneLabels();

const initialTimeZone = timezoneOptions.find(opt => opt.getAttribute("aria-selected") === "true")?.dataset.value || "UTC";

let selectedTimezone = initialTimeZone;

function pad(value) {
    return String(value).padStart(2, "0");
}

function getMonthName(monthIndex) {
    return new Intl.DateTimeFormat("en-US", {
        month: "long"
    }).format(new Date(2020, monthIndex, 1));
}

function getYmdFromParts(year, month, day) {
    return `${pad(year)}-${pad(month)}-${pad(day)}`;
}

function createDateFromYmd(dateYmd) {
    const [year, month, day] = dateYmd.split("-").map(Number);
    return new Date(year, month - 1, day);
}

function getTimeZoneDateParts(date, timeZone) {
    const formatter = new Intl.DateTimeFormat("en-US", {
        timeZone: timeZone,
        year: "numeric",
        month: "2-digit",
        day: "2-digit",
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
        hour12: false
    });
    return formatter.formatToParts(date).reduce((acc, part) => {
        if (part.type !== "literal") {
            acc[part.type] = part.value;
        }
        return acc;
    }, {});
}

function getDateInTimeZone(date, timeZone) {
    const source = typeof date === "string" ? new Date(date) : date;
    const parts = getTimeZoneDateParts(source, timeZone);
    return new Date(Number(parts.year), Number(parts.month) - 1, Number(parts.day));
}

function getTodayInTimeZone(timeZone) {
    return getDateInTimeZone(new Date, timeZone);
}

const initialToday = getTodayInTimeZone(selectedTimezone);

let viewYear = initialToday.getFullYear();

let viewMonth = initialToday.getMonth();

let selectedDate = initialToday;

function formatDateValue(date) {
    if (typeof date === "string") {
        return date;
    }
    return getYmdFromParts(date.getFullYear(), date.getMonth() + 1, date.getDate());
}

function formatSelectedSlot(date, timeLabel) {
    const dateValue = formatDateValue(date);
    return `${dateValue} ${timeLabel}`;
}

function getFriendlySlotText(date, timeLabel) {
    const dateObj = typeof date === "string" ? createDateFromYmd(date) : date;
    const formatter = new Intl.DateTimeFormat("en-US", {
        weekday: "long",
        month: "long",
        day: "numeric"
    });
    return `${formatter.format(dateObj)} · ${timeLabel}`;
}

function isSameYMD(dateA, dateB) {
    if (!dateA || !dateB) {
        return false;
    }
    const a = typeof dateA === "string" ? dateA : formatDateValue(dateA);
    const b = typeof dateB === "string" ? dateB : formatDateValue(dateB);
    return a === b;
}

function isDateInPast(date, timeZone = selectedTimezone) {
    if (!date) {
        return false;
    }
    const selectedYmd = typeof date === "string" ? date : formatDateValue(date);
    const todayYmd = formatDateValue(getTodayInTimeZone(timeZone));
    return selectedYmd < todayYmd;
}

function updateActiveDateText(date) {
    if (!timesDateEl || !date) {
        return;
    }
    const displayDate = typeof date === "string" ? createDateFromYmd(date) : date;
    timesDateEl.textContent = new Intl.DateTimeFormat("en-US", {
        weekday: "long",
        month: "long",
        day: "numeric"
    }).format(displayDate);
}

function getSlotLabel(btn) {
    const labelEl = btn.querySelector(".time-slot__label");
    return (labelEl ? labelEl.textContent : btn.textContent).trim();
}

function getRecaptchaInput() {
    return document.querySelector('input[name="g-recaptcha-response"]');
}

function getRecaptchaSiteKey() {
    var input = getRecaptchaInput();
    return input ? input.dataset.sitekey : "";
}

function executeRecaptcha(action, retryCount = 0) {
    return new Promise(function (resolve, reject) {
        var siteKey = getRecaptchaSiteKey();
        if (!siteKey) {
            return resolve("");
        }
        function execute() {
            if (typeof grecaptcha !== "undefined" && grecaptcha.enterprise && typeof grecaptcha.enterprise.execute === "function") {
                grecaptcha.enterprise.execute(siteKey, {
                    action: action
                }).then(resolve).catch(function (error) {
                    reject(error || new Error("reCAPTCHA execution failed."));
                });
                return;
            }
            if (typeof grecaptcha !== "undefined" && typeof grecaptcha.execute === "function") {
                grecaptcha.execute(siteKey, {
                    action: action
                }).then(resolve).catch(function (error) {
                    reject(error || new Error("reCAPTCHA execution failed."));
                });
                return;
            }
            reject(new Error("reCAPTCHA is not loaded."));
        }
        if (typeof grecaptcha !== "undefined" && grecaptcha.enterprise && typeof grecaptcha.enterprise.ready === "function") {
            try {
                grecaptcha.enterprise.ready(execute);
            } catch (e) {
                reject(e);
            }
            return;
        }
        if (typeof grecaptcha !== "undefined" && typeof grecaptcha.ready === "function") {
            try {
                grecaptcha.ready(execute);
            } catch (e) {
                reject(e);
            }
            return;
        }
        if (retryCount < 5) {
            window.setTimeout(function () {
                executeRecaptcha(action, (retryCount || 0) + 1).then(resolve).catch(reject);
            }, 200);
            return;
        }
        reject(new Error("reCAPTCHA is not loaded."));
    });
}

function showBookingError(message) {
    var form = document.querySelector(".booking-form");
    if (!form) return;
    var existingAlert = form.querySelector(".booking-alert.booking-alert--error");
    if (existingAlert) existingAlert.remove();
    var errorAlert = document.createElement("div");
    errorAlert.className = "booking-alert booking-alert--error";
    errorAlert.textContent = message;
    form.insertBefore(errorAlert, form.firstChild);
}

function parseSlotToDate(date, timeLabel) {
    const slotTime = parseSlotTime(timeLabel);
    if (!slotTime) {
        return null;
    }
    const slotDate = new Date(date);
    slotDate.setHours(slotTime.hour, slotTime.minute, 0, 0);
    return slotDate;
}

function parseSlotTime(timeLabel) {
    const matches = timeLabel.match(/^(\d{1,2}):(\d{2})\s?(AM|PM)$/i);
    if (!matches) {
        return null;
    }
    const [, hourString, minuteString, meridiem] = matches;
    let hour = Number(hourString);
    const minute = Number(minuteString);
    if (meridiem.toUpperCase() === "PM" && hour !== 12) hour += 12;
    if (meridiem.toUpperCase() === "AM" && hour === 12) hour = 0;
    return {
        hour: hour,
        minute: minute
    };
}

function getCurrentDateTimeInTimeZone(timeZone) {
    try {
        const now = new Date;
        const formatter = new Intl.DateTimeFormat("en-US", {
            timeZone: timeZone,
            year: "numeric",
            month: "2-digit",
            day: "2-digit",
            hour: "2-digit",
            minute: "2-digit",
            second: "2-digit",
            hour12: false
        });
        const parts = formatter.formatToParts(now).reduce((acc, part) => {
            if (part.type !== "literal") {
                acc[part.type] = part.value;
            }
            return acc;
        }, {});
        return {
            year: Number(parts.year),
            month: Number(parts.month),
            day: Number(parts.day),
            hour: Number(parts.hour),
            minute: Number(parts.minute),
            second: Number(parts.second)
        };
    } catch (error) {
        return null;
    }
}

function isSlotInPast(date, timeLabel, timeZone) {
    const nowInTZ = getCurrentDateTimeInTimeZone(timeZone || "UTC");
    if (!nowInTZ) {
        return false;
    }
    const slotTime = parseSlotTime(timeLabel);
    if (!slotTime) {
        return false;
    }
    const selectedDateYMD = [date.getFullYear(), date.getMonth() + 1, date.getDate()];
    const nowYMD = [nowInTZ.year, nowInTZ.month, nowInTZ.day];
    if (selectedDateYMD[0] !== nowYMD[0] || selectedDateYMD[1] !== nowYMD[1] || selectedDateYMD[2] !== nowYMD[2]) {
        return false;
    }
    const slotMinutes = slotTime.hour * 60 + slotTime.minute;
    const nowMinutes = nowInTZ.hour * 60 + nowInTZ.minute;
    return slotMinutes <= nowMinutes;
}

function isSunday(date) {
    return date.getDay() === 0;
}

function updatePastTimeMessage(date, fullyBooked = false) {
    const msgEl = document.getElementById("availabilityMessage");
    if (!msgEl) {
        return;
    }
    const dateObj = typeof date === "string" ? createDateFromYmd(date) : date;
    if (dateObj && isSunday(dateObj)) {
        msgEl.textContent = "We're closed on Sundays. Please choose another date.";
        msgEl.style.display = "block";
        return;
    }
    const startOfToday = getTodayInTimeZone(selectedTimezone);
    const isToday = date && isSameYMD(date, startOfToday);
    const isPast = isDateInPast(date, selectedTimezone);
    const allDisabled = timeButtons.length > 0 && timeButtons.every(btn => btn.disabled);
    if (isPast) {
        msgEl.textContent = "Selected date is in the past. Please choose a future date.";
        msgEl.style.display = "block";
    } else if (isToday && allDisabled) {
        msgEl.textContent = "No more available times today. Please pick another date.";
        msgEl.style.display = "block";
    } else if (fullyBooked) {
        msgEl.textContent = "This date is fully booked. Please choose another date.";
        msgEl.style.display = "block";
    } else {
        msgEl.style.display = "none";
    }
}

function setTimeSlotAvailability(bookedSlots, date, timeZone, fullyBooked = false) {
    const dateObj = typeof date === "string" ? createDateFromYmd(date) : date;
    const isClosedDay = dateObj ? isSunday(dateObj) : false;
    timeButtons.forEach(btn => {
        const label = getSlotLabel(btn);
        const isBooked = bookedSlots.includes(label);
        const isPast = !isBooked && date ? isSlotInPast(date, label, timeZone) : false;
        const isUnavailable = isClosedDay || isBooked || isPast;
        const badge = btn.querySelector(".time-slot__badge");
        btn.disabled = isUnavailable;
        btn.classList.toggle("time-slot--disabled", isUnavailable);
        btn.classList.toggle("time-slot--booked", isBooked && !isClosedDay);
        btn.classList.toggle("time-slot--past", isPast && !isClosedDay);
        btn.classList.remove("time-slot--active");
        if (isClosedDay) {
            btn.title = "We're closed on Sundays";
            if (badge) {
                badge.textContent = "Closed";
                badge.style.display = "";
            }
        } else if (isBooked) {
            btn.title = "This time is already booked";
            if (badge) {
                badge.textContent = "Booked";
                badge.style.display = "";
            }
        } else if (isPast) {
            btn.title = "This time has already passed";
            if (badge) {
                badge.textContent = "Passed";
                badge.style.display = "";
            }
        } else {
            btn.removeAttribute("title");
            if (badge) {
                badge.textContent = "";
                badge.style.display = "none";
            }
        }
    });
    updatePastTimeMessage(date, fullyBooked);
}

function openModal(timeLabel) {
    if (!selectedDate) {
        return;
    }
    const slotText = getFriendlySlotText(selectedDate, timeLabel);
    modalSlotText.textContent = slotText;
    hiddenSlot.value = formatSelectedSlot(selectedDate, timeLabel);
    modal.classList.add("is-open");
    document.body.style.overflow = "hidden";
}

function closeModal() {
    modal.classList.remove("is-open");
    document.body.style.overflow = "";
}

function getNextAvailableDate(date) {
    const next = new Date(date);
    while (isSunday(next)) {
        next.setDate(next.getDate() + 1);
    }
    return next;
}

function selectDate(date, button) {
    selectedDate = date;
    const buttons = calendarGrid.querySelectorAll(".calendar-day");
    buttons.forEach(btn => btn.classList.remove("calendar-day--active"));
    button.classList.add("calendar-day--active");
    updateActiveDateText(date);
    fetchAvailabilityForDate(date);
}

function createCalendarCell(dayNumber, date, isOtherMonth, currentDate) {
    const button = document.createElement("button");
    button.type = "button";
    button.className = "calendar-day";
    button.textContent = dayNumber;
    if (isOtherMonth) {
        button.classList.add("calendar-day--other-month");
    }
    const normalizedDate = new Date(date);
    normalizedDate.setHours(0, 0, 0, 0);
    const isToday = isSameYMD(date, currentDate);
    const isPast = normalizedDate < currentDate;
    const isDisabled = isPast || isSunday(date);
    if (isToday) {
        button.classList.add("calendar-day--today");
    }
    if (selectedDate && isSameYMD(date, selectedDate)) {
        button.classList.add("calendar-day--active");
    }
    if (isDisabled) {
        button.classList.add("calendar-day--disabled");
        button.disabled = true;
        return button;
    }
    button.dataset.iso = formatDateValue(date);
    button.addEventListener("click", () => {
        if (isOtherMonth) {
            viewYear = date.getFullYear();
            viewMonth = date.getMonth();
            buildCalendar(viewYear, viewMonth);
            const newBtn = calendarGrid.querySelector(`[data-iso="${formatDateValue(date)}"]`);
            if (newBtn) {
                selectDate(date, newBtn);
            }
        } else {
            selectDate(date, button);
        }
    });
    return button;
}

function buildCalendar(year, month) {
    if (!calendarGrid || !calendarMonthEl) {
        return;
    }
    calendarMonthEl.textContent = `${getMonthName(month)} ${year}`;
    calendarGrid.innerHTML = "";
    const firstOfMonth = new Date(year, month, 1);
    const dayOfWeek = firstOfMonth.getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const daysInPrevMonth = new Date(year, month, 0).getDate();
    const currentDate = getTodayInTimeZone(selectedTimezone);
    if (selectedDate.getMonth() !== month || selectedDate.getFullYear() !== year || selectedDate < currentDate) {
        if (year === currentDate.getFullYear() && month === currentDate.getMonth()) {
            selectedDate = currentDate;
        } else {
            selectedDate = getNextAvailableDate(new Date(year, month, 1));
        }
    }
    for (let i = 0; i < dayOfWeek; i += 1) {
        const dayNumber = daysInPrevMonth - dayOfWeek + 1 + i;
        const cellDate = new Date(year, month - 1, dayNumber);
        calendarGrid.appendChild(createCalendarCell(dayNumber, cellDate, true, currentDate));
    }
    for (let day = 1; day <= daysInMonth; day += 1) {
        const cellDate = new Date(year, month, day);
        calendarGrid.appendChild(createCalendarCell(day, cellDate, false, currentDate));
    }
    const totalCellsSoFar = dayOfWeek + daysInMonth;
    const trailingCount = (7 - totalCellsSoFar % 7) % 7;
    for (let day = 1; day <= trailingCount; day += 1) {
        const cellDate = new Date(year, month + 1, day);
        calendarGrid.appendChild(createCalendarCell(day, cellDate, true, currentDate));
    }
    updateActiveDateText(selectedDate);
    updateTimezoneDisplay();
    fetchAvailabilityForDate(selectedDate);
}

function changeMonth(offset) {
    viewMonth += offset;
    if (viewMonth < 0) {
        viewMonth = 11;
        viewYear -= 1;
    } else if (viewMonth > 11) {
        viewMonth = 0;
        viewYear += 1;
    }
    buildCalendar(viewYear, viewMonth);
}

function updateTimezoneDisplay() {
    const selected = timezoneOptions.find(opt => opt.getAttribute("aria-selected") === "true");
    if (!selected) {
        return;
    }
    timezoneField.value = selected.dataset.value;
    if (timezoneLabelField) {
        timezoneLabelField.value = selected.dataset.displayLabel || selected.textContent.trim();
    }
}

function selectTimezone(option) {
    timezoneOptions.forEach(opt => opt.removeAttribute("aria-selected"));
    option.setAttribute("aria-selected", "true");
    refreshTimezoneLabels();
    timezoneTriggerLabel.textContent = option.textContent;
    selectedTimezone = option.dataset.value || "UTC";
    updateTimezoneDisplay();
    selectedDate = getTodayInTimeZone(selectedTimezone);
    viewYear = selectedDate.getFullYear();
    viewMonth = selectedDate.getMonth();
    buildCalendar(viewYear, viewMonth);
}

function openTimezoneList() {
    timezoneDropdown.classList.add("is-open");
    timezoneTrigger.setAttribute("aria-expanded", "true");
}

function closeTimezoneList() {
    timezoneDropdown.classList.remove("is-open");
    timezoneTrigger.setAttribute("aria-expanded", "false");
}

async function fetchAvailabilityForDate(date) {
    if (!date) {
        return;
    }
    const dateValue = formatDateValue(date);
    const timezoneValue = timezoneField.value || "UTC";
    const dateObj = typeof date === "string" ? createDateFromYmd(date) : date;
    if (dateObj && isSunday(dateObj)) {
        setTimeSlotAvailability([], date, timezoneValue, false);
        markDayAsFullyBooked(date, false);
        return;
    }
    try {
        const response = await fetch(`/book-a-call/availability?date=${encodeURIComponent(dateValue)}&timezone=${encodeURIComponent(timezoneValue)}`);
        if (!response.ok) {
            setTimeSlotAvailability([], date, timezoneValue, false);
            markDayAsFullyBooked(date, false);
            return;
        }
        const data = await response.json();
        const bookedSlots = Array.isArray(data.booked_slots) ? data.booked_slots : [];
        const fullyBooked = timeButtons.length > 0 && bookedSlots.length > 0 && timeButtons.every(btn => bookedSlots.includes(getSlotLabel(btn)));
        setTimeSlotAvailability(bookedSlots, date, timezoneValue, fullyBooked);
        markDayAsFullyBooked(date, fullyBooked);
    } catch (error) {
        setTimeSlotAvailability([], date, timezoneValue, false);
        markDayAsFullyBooked(date, false);
    }
}

function markDayAsFullyBooked(date, isFullyBooked) {
    if (!calendarGrid) {
        return;
    }
    const buttons = calendarGrid.querySelectorAll(".calendar-day:not(.calendar-day--disabled)");
    buttons.forEach(btn => {
        if (btn.dataset.iso !== formatDateValue(date)) {
            return;
        }
        btn.classList.toggle("calendar-day--booked", isFullyBooked);
        btn.disabled = isFullyBooked;
    });
}

function initializeTimeButtons() {
    timeButtons.forEach(btn => {
        btn.addEventListener("click", () => {
            if (btn.disabled) {
                return;
            }
            timeButtons.forEach(b => b.classList.remove("time-slot--active"));
            btn.classList.add("time-slot--active");
            openModal(getSlotLabel(btn));
        });
    });
}

if (prevMonthBtn && nextMonthBtn) {
    prevMonthBtn.addEventListener("click", () => changeMonth(-1));
    nextMonthBtn.addEventListener("click", () => changeMonth(1));
}

if (timezoneTrigger) {
    timezoneTrigger.addEventListener("click", () => {
        if (timezoneDropdown.classList.contains("is-open")) {
            closeTimezoneList();
        } else {
            openTimezoneList();
        }
    });
}

var bookingForm = document.querySelector(".booking-form");

if (bookingForm) {
    var bookingSubmitting = false;
    bookingForm.addEventListener("submit", function (event) {
        if (bookingSubmitting) {
            event.preventDefault();
            return;
        }
        event.preventDefault();
        bookingSubmitting = true;
        var submitButton = bookingForm.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.dataset.originalText = submitButton.textContent;
            submitButton.textContent = 'Sending...';
        }
        var recaptchaInput = getRecaptchaInput();
        if (!recaptchaInput) {
            showBookingError("reCAPTCHA is not configured.");
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.textContent = submitButton.dataset.originalText || 'Book Call';
            }
            bookingSubmitting = false;
            return;
        }
        executeRecaptcha("booking").then(function (token) {
            recaptchaInput.value = token || "";
            bookingForm.submit();
        }).catch(function (error) {
            showBookingError(error && error.message ? error.message : "Unable to verify reCAPTCHA.");
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.textContent = submitButton.dataset.originalText || 'Book Call';
            }
            bookingSubmitting = false;
        });
    });
}

timezoneOptions.forEach(option => {
    option.addEventListener("click", () => {
        selectTimezone(option);
        closeTimezoneList();
    });
});

document.addEventListener("click", e => {
    if (timezoneDropdown && !timezoneDropdown.contains(e.target)) {
        closeTimezoneList();
    }
});

modalClose.addEventListener("click", closeModal);

modal.addEventListener("click", e => {
    if (e.target === modal) {
        closeModal();
    }
});

document.addEventListener("keydown", e => {
    if (e.key === "Escape") {
        closeModal();
        closeTimezoneList();
    }
});

initializeTimeButtons();

buildCalendar(viewYear, viewMonth);

var bookingToast = document.querySelector(".booking-toast");

if (bookingToast) {
    window.setTimeout(function () {
        bookingToast.style.transition = "opacity 0.25s ease, transform 0.25s ease";
        bookingToast.style.opacity = "0";
        bookingToast.style.transform = "translateX(-50%) translateY(-8px)";
        window.setTimeout(function () {
            if (bookingToast.parentNode) {
                bookingToast.parentNode.removeChild(bookingToast);
            }
        }, 250);
    }, 5200);
}
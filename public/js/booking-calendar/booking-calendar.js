const modal = document.getElementById('bookingModal');
const modalClose = document.getElementById('bookingModalClose');
const modalSlotText = document.getElementById('modalSlotText');
const hiddenSlot = document.getElementById('hiddenSlot');
const timezoneField = document.getElementById('timezoneField');
const timesDateEl = document.querySelector('.times-date');
const calendarGrid = document.querySelector('.calendar-grid');
const calendarMonthEl = document.querySelector('.calendar-month');
const timeButtons = Array.from(document.querySelectorAll('.time-slot'));
const prevMonthBtn = document.querySelectorAll('.calendar-nav')[0];
const nextMonthBtn = document.querySelectorAll('.calendar-nav')[1];

const timezoneDropdown = document.getElementById('timezoneDropdown');
const timezoneTrigger = document.getElementById('timezoneTrigger');
const timezoneTriggerLabel = document.getElementById('timezoneTriggerLabel');
const timezoneList = document.getElementById('timezoneList');
const timezoneOptions = Array.from(document.querySelectorAll('.calendar-tz__list li'));

const today = new Date();
let viewYear = today.getFullYear();
let viewMonth = today.getMonth();
let selectedDate = new Date(today.getFullYear(), today.getMonth(), today.getDate());

function pad(value) {
    return String(value).padStart(2, '0');
}

function getMonthName(monthIndex) {
    return new Intl.DateTimeFormat('en-US', { month: 'long' }).format(new Date(2020, monthIndex, 1));
}

function formatSelectedSlot(date, timeLabel) {
    const matches = timeLabel.match(/^(\d{1,2}):(\d{2})\s?(AM|PM)$/i);
    if (!matches) {
        return '';
    }

    const [, hourString, minuteString, meridiem] = matches;
    const hour = Number(hourString);
    const minute = Number(minuteString);
    const normalizedHour = meridiem.toUpperCase() === 'PM' && hour !== 12 ? hour + 12 : meridiem.toUpperCase() === 'AM' && hour === 12 ? 0 : hour;

    const year = date.getFullYear();
    const month = pad(date.getMonth() + 1);
    const day = pad(date.getDate());
    const hour12 = date.getHours() % 12 || 12;
    const minutePad = pad(date.getMinutes());
    const labelHour = pad(hour12);

    return `${year}-${month}-${day} ${hour12}:${minuteString} ${meridiem.toUpperCase()}`;
}

function formatDateValue(date) {
    return `${date.getFullYear()}-${pad(date.getMonth() + 1)}-${pad(date.getDate())}`;
}

function getFriendlySlotText(date, timeLabel) {
    const options = { weekday: 'long', month: 'long', day: 'numeric' };
    return `${date.toLocaleDateString('en-US', options)} · ${timeLabel}`;
}

function updateActiveDateText(date) {
    if (!timesDateEl || !date) {
        return;
    }

    const options = { weekday: 'long', month: 'long', day: 'numeric' };
    timesDateEl.textContent = date.toLocaleDateString('en-US', options);
}

function getSlotLabel(btn) {
    const labelEl = btn.querySelector('.time-slot__label');
    return (labelEl ? labelEl.textContent : btn.textContent).trim();
}

function getRecaptchaInput() {
    return document.querySelector('input[name="g-recaptcha-response"]');
}

function getRecaptchaSiteKey() {
    var input = getRecaptchaInput();
    return input ? input.dataset.sitekey : '';
}

function executeRecaptcha(action, retryCount = 0) {
    return new Promise(function (resolve, reject) {
        var siteKey = getRecaptchaSiteKey();
        if (!siteKey) {
            return reject(new Error('reCAPTCHA site key is missing.'));
        }

        function execute() {
            if (typeof grecaptcha !== 'undefined' && grecaptcha.enterprise && typeof grecaptcha.enterprise.execute === 'function') {
                grecaptcha.enterprise.execute(siteKey, { action: action }).then(resolve).catch(function (error) {
                    reject(error || new Error('reCAPTCHA execution failed.'));
                });
                return;
            }

            if (typeof grecaptcha !== 'undefined' && typeof grecaptcha.execute === 'function') {
                grecaptcha.execute(siteKey, { action: action }).then(resolve).catch(function (error) {
                    reject(error || new Error('reCAPTCHA execution failed.'));
                });
                return;
            }

            reject(new Error('reCAPTCHA is not loaded.'));
        }

        if (typeof grecaptcha !== 'undefined' && grecaptcha.enterprise && typeof grecaptcha.enterprise.ready === 'function') {
            try {
                grecaptcha.enterprise.ready(execute);
            } catch (e) {
                reject(e);
            }
            return;
        }

        if (typeof grecaptcha !== 'undefined' && typeof grecaptcha.ready === 'function') {
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

        reject(new Error('reCAPTCHA is not loaded.'));
    });
}

function showBookingError(message) {
    var form = document.querySelector('.booking-form');
    if (!form) return;
    var existingAlert = form.querySelector('.booking-alert.booking-alert--error');
    if (existingAlert) existingAlert.remove();
    var errorAlert = document.createElement('div');
    errorAlert.className = 'booking-alert booking-alert--error';
    errorAlert.textContent = message;
    form.insertBefore(errorAlert, form.firstChild);
}

/* ---------- Past-time helpers ---------- */

function parseSlotToDate(date, timeLabel) {
    const matches = timeLabel.match(/^(\d{1,2}):(\d{2})\s?(AM|PM)$/i);
    if (!matches) {
        return null;
    }

    const [, hourString, minuteString, meridiem] = matches;
    let hour = Number(hourString);
    const minute = Number(minuteString);

    if (meridiem.toUpperCase() === 'PM' && hour !== 12) hour += 12;
    if (meridiem.toUpperCase() === 'AM' && hour === 12) hour = 0;

    const slotDate = new Date(date);
    slotDate.setHours(hour, minute, 0, 0);
    return slotDate;
}

function isSlotInPast(date, timeLabel) {
    const now = new Date();
    const startOfToday = new Date(now.getFullYear(), now.getMonth(), now.getDate());
    const normalizedDate = new Date(date.getFullYear(), date.getMonth(), date.getDate());

    if (normalizedDate.getTime() !== startOfToday.getTime()) {
        return false;
    }

    const slotDate = parseSlotToDate(date, timeLabel);
    if (!slotDate) return false;

    return slotDate.getTime() <= now.getTime();
}

function updatePastTimeMessage(date) {
    const msgEl = document.getElementById('pastTimeMessage');
    if (!msgEl) {
        return;
    }

    const now = new Date();
    const startOfToday = new Date(now.getFullYear(), now.getMonth(), now.getDate());
    const isToday = date
        && date.getFullYear() === startOfToday.getFullYear()
        && date.getMonth() === startOfToday.getMonth()
        && date.getDate() === startOfToday.getDate();

    const allDisabled = timeButtons.length > 0 && timeButtons.every(btn => btn.disabled);

    if (isToday && allDisabled) {
        msgEl.textContent = 'No more available times today. Please pick another date.';
        msgEl.style.display = 'block';
    } else {
        msgEl.style.display = 'none';
    }
}

/* ---------- Availability / slot rendering ---------- */

function setTimeSlotAvailability(bookedSlots, date) {
    timeButtons.forEach(btn => {
        const label = getSlotLabel(btn);
        const isBooked = bookedSlots.includes(label);
        const isPast = date ? isSlotInPast(date, label) : false;
        const isUnavailable = isBooked || isPast;

        btn.disabled = isUnavailable;
        btn.classList.toggle('time-slot--disabled', isUnavailable);
        // "Booked" styling/label only applies to slots that are actually booked.
        // Past slots are simply disabled — no booked label, no extra styling.
        btn.classList.toggle('time-slot--booked', isBooked);
        btn.classList.remove('time-slot--active');

        if (isBooked) {
            btn.title = 'This time is already booked';
        } else {
            btn.removeAttribute('title');
        }
    });

    updatePastTimeMessage(date);
}

function openModal(timeLabel) {
    if (!selectedDate) {
        return;
    }

    const slotText = getFriendlySlotText(selectedDate, timeLabel);
    modalSlotText.textContent = slotText;
    hiddenSlot.value = formatSelectedSlot(selectedDate, timeLabel);
    modal.classList.add('is-open');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    modal.classList.remove('is-open');
    document.body.style.overflow = '';
}

function isSunday(date) {
    return date.getDay() === 0;
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
    const buttons = calendarGrid.querySelectorAll('.calendar-day');
    buttons.forEach(btn => btn.classList.remove('calendar-day--active'));
    button.classList.add('calendar-day--active');
    updateActiveDateText(date);
    fetchAvailabilityForDate(date);
}

function createCalendarCell(dayNumber, date, isOtherMonth) {
    const button = document.createElement('button');
    button.type = 'button';
    button.className = 'calendar-day';
    button.textContent = dayNumber;

    if (isOtherMonth) {
        button.classList.add('calendar-day--other-month');
    }

    const currentDate = new Date();
    currentDate.setHours(0, 0, 0, 0);
    const normalizedDate = new Date(date);
    normalizedDate.setHours(0, 0, 0, 0);

    const isPast = normalizedDate < currentDate;
    const isDisabled = isPast || isSunday(date);

    if (isDisabled) {
        button.classList.add('calendar-day--disabled');
        button.disabled = true;
        return button;
    }

    button.dataset.iso = formatDateValue(date);
    button.addEventListener('click', () => {
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

    if (selectedDate && date.toDateString() === selectedDate.toDateString()) {
        button.classList.add('calendar-day--active');
    }

    return button;
}

function buildCalendar(year, month) {
    if (!calendarGrid || !calendarMonthEl) {
        return;
    }

    calendarMonthEl.textContent = `${getMonthName(month)} ${year}`;
    calendarGrid.innerHTML = '';

    const firstOfMonth = new Date(year, month, 1);
    const dayOfWeek = firstOfMonth.getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const daysInPrevMonth = new Date(year, month, 0).getDate();
    const currentDate = new Date();
    currentDate.setHours(0, 0, 0, 0);

    if (
        selectedDate.getMonth() !== month
        || selectedDate.getFullYear() !== year
        || selectedDate < currentDate
        || isSunday(selectedDate)
    ) {
        let base;
        if (year === today.getFullYear() && month === today.getMonth()) {
            base = new Date(today.getFullYear(), today.getMonth(), today.getDate());
        } else {
            base = new Date(year, month, 1);
        }
        selectedDate = getNextAvailableDate(base);
    }

    for (let i = 0; i < dayOfWeek; i += 1) {
        const dayNumber = daysInPrevMonth - dayOfWeek + 1 + i;
        const cellDate = new Date(year, month - 1, dayNumber);
        calendarGrid.appendChild(createCalendarCell(dayNumber, cellDate, true));
    }

    for (let day = 1; day <= daysInMonth; day += 1) {
        const cellDate = new Date(year, month, day);
        calendarGrid.appendChild(createCalendarCell(day, cellDate, false));
    }

    const totalCellsSoFar = dayOfWeek + daysInMonth;
    const trailingCount = (7 - (totalCellsSoFar % 7)) % 7;
    for (let day = 1; day <= trailingCount; day += 1) {
        const cellDate = new Date(year, month + 1, day);
        calendarGrid.appendChild(createCalendarCell(day, cellDate, true));
    }

    updateActiveDateText(selectedDate);
    fetchAvailabilityForDate(selectedDate);
    updateTimezoneDisplay();
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
    const selected = timezoneOptions.find(opt => opt.getAttribute('aria-selected') === 'true');
    if (!selected) {
        return;
    }
    timezoneField.value = selected.dataset.value;
}

function selectTimezone(option) {
    timezoneOptions.forEach(opt => opt.removeAttribute('aria-selected'));
    option.setAttribute('aria-selected', 'true');
    timezoneTriggerLabel.textContent = option.textContent;
    updateTimezoneDisplay();
    fetchAvailabilityForDate(selectedDate);
}

function openTimezoneList() {
    timezoneDropdown.classList.add('is-open');
    timezoneTrigger.setAttribute('aria-expanded', 'true');
}

function closeTimezoneList() {
    timezoneDropdown.classList.remove('is-open');
    timezoneTrigger.setAttribute('aria-expanded', 'false');
}

async function fetchAvailabilityForDate(date) {
    if (!date) {
        return;
    }

    const dateValue = formatDateValue(date);
    const timezoneValue = timezoneField.value || 'UTC';

    try {
        const response = await fetch(`/book-a-call/availability?date=${encodeURIComponent(dateValue)}&timezone=${encodeURIComponent(timezoneValue)}`);
        if (!response.ok) {
            setTimeSlotAvailability([], date);
            return;
        }

        const data = await response.json();
        const bookedSlots = Array.isArray(data.booked_slots) ? data.booked_slots : [];
        setTimeSlotAvailability(bookedSlots, date);
        markDayAsFullyBooked(date, bookedSlots.length > 0 && bookedSlots.length >= timeButtons.length);
    } catch (error) {
        setTimeSlotAvailability([], date);
    }
}

function markDayAsFullyBooked(date, isFullyBooked) {
    if (!calendarGrid) {
        return;
    }

    const buttons = calendarGrid.querySelectorAll('.calendar-day:not(.calendar-day--disabled)');
    buttons.forEach(btn => {
        if (btn.dataset.iso !== formatDateValue(date)) {
            return;
        }
        btn.classList.toggle('calendar-day--booked', isFullyBooked);
        btn.disabled = isFullyBooked;
    });
}

function initializeTimeButtons() {
    timeButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            if (btn.disabled) {
                return;
            }

            timeButtons.forEach(b => b.classList.remove('time-slot--active'));
            btn.classList.add('time-slot--active');
            openModal(getSlotLabel(btn));
        });
    });
}

if (prevMonthBtn && nextMonthBtn) {
    prevMonthBtn.addEventListener('click', () => changeMonth(-1));
    nextMonthBtn.addEventListener('click', () => changeMonth(1));
}

if (timezoneTrigger) {
    timezoneTrigger.addEventListener('click', () => {
        if (timezoneDropdown.classList.contains('is-open')) {
            closeTimezoneList();
        } else {
            openTimezoneList();
        }
    });
}

var bookingForm = document.querySelector('.booking-form');
if (bookingForm) {
    var bookingSubmitting = false;
    bookingForm.addEventListener('submit', function (event) {
        if (bookingSubmitting) {
            event.preventDefault();
            return;
        }

        event.preventDefault();
        bookingSubmitting = true;
        var submitButton = bookingForm.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.disabled = true;
        }

        var recaptchaInput = getRecaptchaInput();
        if (!recaptchaInput) {
            showBookingError('reCAPTCHA is not configured.');
            if (submitButton) {
                submitButton.disabled = false;
            }
            bookingSubmitting = false;
            return;
        }

        executeRecaptcha('booking').then(function (token) {
            recaptchaInput.value = token || '';
            bookingForm.submit();
        }).catch(function (error) {
            showBookingError(error && error.message ? error.message : 'Unable to verify reCAPTCHA.');
            if (submitButton) {
                submitButton.disabled = false;
            }
            bookingSubmitting = false;
        });
    });
}

timezoneOptions.forEach(option => {
    option.addEventListener('click', () => {
        selectTimezone(option);
        closeTimezoneList();
    });
});

document.addEventListener('click', e => {
    if (timezoneDropdown && !timezoneDropdown.contains(e.target)) {
        closeTimezoneList();
    }
});

modalClose.addEventListener('click', closeModal);

modal.addEventListener('click', e => {
    if (e.target === modal) {
        closeModal();
    }
});

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        closeModal();
        closeTimezoneList();
    }
});

initializeTimeButtons();
buildCalendar(viewYear, viewMonth);
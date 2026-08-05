const modal = document.getElementById('bookingModal');
const modalClose = document.getElementById('bookingModalClose');
const modalSlotText = document.getElementById('modalSlotText');
const hiddenSlot = document.getElementById('hiddenSlot');
const timezoneField = document.getElementById('timezoneField');
const timesDateEl = document.querySelector('.times-date');
const calendarGrid = document.querySelector('.calendar-grid');
const calendarMonthEl = document.querySelector('.calendar-month');
const timezoneButton = document.querySelector('.calendar-tz');
const timeButtons = Array.from(document.querySelectorAll('.time-slot'));
const prevMonthBtn = document.querySelectorAll('.calendar-nav')[0];
const nextMonthBtn = document.querySelectorAll('.calendar-nav')[1];

const today = new Date();
let viewYear = today.getFullYear();
let viewMonth = today.getMonth();
let selectedDate = new Date(today.getFullYear(), today.getMonth(), today.getDate());

function pad(value) {
    return String(value).padStart(2, '0');
}

function buildTimezoneLabel() {
    const timeZone = Intl.DateTimeFormat().resolvedOptions().timeZone || 'UTC';
    const offsetMinutes = -new Date().getTimezoneOffset();
    const offsetHours = Math.trunc(offsetMinutes / 60);
    const offsetMins = Math.abs(offsetMinutes % 60);
    const sign = offsetHours >= 0 ? '+' : '-';
    const hours = pad(Math.abs(offsetHours));
    const minutes = pad(offsetMins);

    return `(${sign}${hours}:${minutes}) ${timeZone}`;
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

function setTimeSlotAvailability(bookedSlots) {
    timeButtons.forEach(btn => {
        const label = btn.textContent.trim();
        btn.disabled = bookedSlots.includes(label);
        btn.classList.toggle('time-slot--disabled', bookedSlots.includes(label));
        btn.classList.remove('time-slot--active');
    });
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

function selectDate(date, button) {
    selectedDate = date;
    const buttons = calendarGrid.querySelectorAll('.calendar-day');
    buttons.forEach(btn => btn.classList.remove('calendar-day--active'));
    button.classList.add('calendar-day--active');
    updateActiveDateText(date);
    fetchAvailabilityForDate(date);
}

function createCalendarCell(dayNumber, isDisabled, date) {
    const button = document.createElement('button');
    button.type = 'button';
    button.className = 'calendar-day';

    if (isDisabled) {
        button.classList.add('calendar-day--disabled');
        button.disabled = true;
        button.textContent = dayNumber > 0 ? dayNumber : '';
        return button;
    }

    button.textContent = dayNumber;
    button.addEventListener('click', () => selectDate(date, button));
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
    const currentDate = new Date();
    currentDate.setHours(0, 0, 0, 0);

    if (selectedDate.getMonth() !== month || selectedDate.getFullYear() !== year || selectedDate < currentDate) {
        if (year === today.getFullYear() && month === today.getMonth()) {
            selectedDate = new Date(today.getFullYear(), today.getMonth(), today.getDate());
        } else {
            selectedDate = new Date(year, month, 1);
        }
    }

    for (let i = 0; i < dayOfWeek; i += 1) {
        calendarGrid.appendChild(createCalendarCell(0, true));
    }

    for (let day = 1; day <= daysInMonth; day += 1) {
        const cellDate = new Date(year, month, day);
        cellDate.setHours(0, 0, 0, 0);
        const isPast = cellDate < currentDate;
        const button = createCalendarCell(day, isPast, cellDate);
        calendarGrid.appendChild(button);
    }

    while (calendarGrid.children.length < 42) {
        calendarGrid.appendChild(createCalendarCell(0, true));
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
    if (!timezoneButton) {
        return;
    }

    const label = buildTimezoneLabel();
    timezoneButton.textContent = label;
    timezoneField.value = Intl.DateTimeFormat().resolvedOptions().timeZone || 'UTC';
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
            setTimeSlotAvailability([]);
            return;
        }

        const data = await response.json();
        setTimeSlotAvailability(Array.isArray(data.booked_slots) ? data.booked_slots : []);
    } catch (error) {
        setTimeSlotAvailability([]);
    }
}

function initializeTimeButtons() {
    timeButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            if (btn.disabled) {
                return;
            }

            timeButtons.forEach(b => b.classList.remove('time-slot--active'));
            btn.classList.add('time-slot--active');
            openModal(btn.textContent.trim());
        });
    });
}

if (prevMonthBtn && nextMonthBtn) {
    prevMonthBtn.addEventListener('click', () => changeMonth(-1));
    nextMonthBtn.addEventListener('click', () => changeMonth(1));
}

modalClose.addEventListener('click', closeModal);

modal.addEventListener('click', e => {
    if (e.target === modal) {
        closeModal();
    }
});

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        closeModal();
    }
});

initializeTimeButtons();
buildCalendar(viewYear, viewMonth);

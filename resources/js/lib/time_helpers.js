function duration(start, end) {
    const start_hours = parseInt(start.slice(0, 2));
    const start_mins = parseInt(start.slice(3, 5));

    const end_hours = parseInt(end.slice(0, 2));
    const end_mins = parseInt(end.slice(3, 5));

    const end_total = (end_hours * 60) + end_mins;
    const start_total = (start_hours * 60) + start_mins;

    const duration_mins = end_total - start_total;

    return `${Math.floor(duration_mins / 60)}hr ${pad(duration_mins % 60)}min`;
}

function pad(value) {
    return value < 10 ? `0${value}` : `${value}`;
}

function time_hours_ago(hoursAgo) {
    const time = new Date();
    return `${pad(time.getHours() - hoursAgo)}:${pad(time.getMinutes() >= 30 ? 30 : 0)}`
}

function timeOfDayAsMinutes(time) {
    const hours = parseInt(time.slice(0, 2));
    const mins = parseInt(time.slice(3, 5));

    return (hours * 60) + mins;
}

function sortSessionsByTimeOfDay(a, b) {
    return timeOfDayAsMinutes(a.start_time) - timeOfDayAsMinutes(b.start_time);
}

function sortByDate(a, b) {
    if (a.month !== b.month) {
        return a.month - b.month;
    }

    return a.day - b.day;
}

function groupDaysByYear(all_days) {
    const by_years = all_days.reduce((years, day) => {
        if (years[day.year]) {
            years[day.year].days.push(day);
        } else {
            years[day.year] = {year: day.year, days: [day]}
        }
        return years;
    }, {});

    return Object.keys(by_years)
                 .sort((a, b) => b - a)
                 .map(key => by_years[key])
                 .map(year => {
                     year.days = year.days.sort(sortByDate);
                     return year;
                 });
}

function withLeadingZero(value) {
    if(value < 10) {
        return `0${value}`;
    }
    return `${value}`;
}

function formattedDate(date) {
    const year = date.getFullYear();
    const month = withLeadingZero(date.getMonth());
    const day = withLeadingZero(date.getDate());
    return `${year}-${month}-${day}`;
}

export {duration, time_hours_ago, sortSessionsByTimeOfDay, sortByDate, groupDaysByYear, formattedDate};